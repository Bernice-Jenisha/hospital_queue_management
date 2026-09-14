<?php
session_start();
include("../includes/db.php");

// Check Admin Login
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// ---------------- ADD DEPARTMENT ----------------
if (isset($_POST['addDepartment'])) {

    $department = mysqli_real_escape_string($conn, $_POST['department_name']);

    // Check duplicate department
    $check = mysqli_query($conn,
        "SELECT * FROM departments WHERE department_name='$department'");

    if (mysqli_num_rows($check) > 0) {

        echo "<script>alert('Department already exists!');</script>";

    } else {

        mysqli_query($conn,
            "INSERT INTO departments(department_name)
             VALUES('$department')");

        echo "<script>
                alert('Department Added Successfully!');
                window.location='manage_departments.php';
              </script>";
    }
}

// ---------------- DELETE DEPARTMENT ----------------
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    // Check if doctors belong to this department
    $doctorCheck = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT COUNT(*) AS total
         FROM doctors
         WHERE department_id='$id'"));

    if ($doctorCheck['total'] > 0) {

        echo "<script>
                alert('Cannot delete! Doctors are assigned to this department.');
                window.location='manage_departments.php';
              </script>";

    } else {

        mysqli_query($conn,
            "DELETE FROM departments
             WHERE department_id='$id'");

        echo "<script>
                alert('Department Deleted Successfully!');
                window.location='manage_departments.php';
              </script>";
    }
}

// Total Departments
$totalDepartments = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM departments"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments | CareConnect Hospital</title>

    <link rel="stylesheet" href="../css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

<div class="dashboard-container">

    <!-- Sidebar -->
    <aside class="sidebar">

        <h2>
            <i class="fa-solid fa-user-shield"></i>
            Admin Panel
        </h2>

        <ul>

            <li>
                <a href="../dashboard.php?page=admin">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="manage_doctors.php">
                    <i class="fa-solid fa-user-doctor"></i>
                    Manage Doctors
                </a>
            </li>

            <li>
                <a href="manage_patients.php">
                    <i class="fa-solid fa-users"></i>
                    Manage Patients
                </a>
            </li>

            <li class="active">
                <a href="manage_departments.php">
                    <i class="fa-solid fa-building"></i>
                    Departments
                </a>
            </li>

            <li>
                <a href="reports.php">
                    <i class="fa-solid fa-chart-column"></i>
                    Reports
                </a>
            </li>

            <li>
                <a href="../logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- Main Content -->
    <main class="dashboard-content">

        <!-- Welcome Banner -->
        <section class="welcome-banner">

            <div>

                <h1>Manage Departments</h1>

                <p>Create and manage hospital departments.</p>

            </div>

        </section>

        <!-- Statistics Card -->
        <section class="stats-grid">

            <div class="stats-card">

                <i class="fa-solid fa-building"></i>

                <h2><?php echo $totalDepartments; ?></h2>

                <p>Total Departments</p>

            </div>

        </section>

        <!-- Add Department -->
        <section class="appointment-form-card">

            <h2>
                <i class="fa-solid fa-plus"></i>
                Add New Department
            </h2>

            <form method="POST">

                <label>Department Name</label>

                <input type="text"
                       name="department_name"
                       placeholder="Enter department name"
                       required>

                <button type="submit"
                        name="addDepartment"
                        class="submit-btn">
                    Add Department
                </button>

            </form>

        </section>

        <!-- Department Table -->
        <section class="appointment-history">

            <h2>
                <i class="fa-solid fa-building"></i>
                Department List
            </h2>

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Department Name</th>
                        <th>Doctors Assigned</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                <?php

                $departmentList = mysqli_query($conn,
                "SELECT
                    dep.department_id,
                    dep.department_name,
                    COUNT(d.doctor_id) AS total_doctors
                 FROM departments dep
                 LEFT JOIN doctors d
                 ON dep.department_id = d.department_id
                 GROUP BY dep.department_id
                 ORDER BY dep.department_id ASC");

                while($department = mysqli_fetch_assoc($departmentList)){
                ?>

                    <tr>

                        <td><?php echo $department['department_id']; ?></td>

                        <td><?php echo $department['department_name']; ?></td>

                        <td><?php echo $department['total_doctors']; ?></td>

                        <td>

                            <?php if($department['total_doctors']==0){ ?>

                            <a href="manage_departments.php?delete=<?php echo $department['department_id']; ?>"
                               onclick="return confirm('Delete this department?')">

                                <i class="fa-solid fa-trash"></i> Delete

                            </a>

                            <?php } else { ?>

                            <span style="color:gray;">Doctors Assigned</span>

                            <?php } ?>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </section>

    </main>

</div>

</body>
</html>