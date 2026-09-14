<?php
session_start();
include("../includes/db.php");

// Check Admin Login
if(!isset($_SESSION['admin_email'])){
    header("Location: admin_login.php");
    exit();
}

// ---------------- ADD DOCTOR ----------------
if(isset($_POST['addDoctor'])){

    $name = mysqli_real_escape_string($conn,$_POST['doctor_name']);
    $specialization = mysqli_real_escape_string($conn,$_POST['specialization']);
    $department = mysqli_real_escape_string($conn,$_POST['department']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $experience = mysqli_real_escape_string($conn,$_POST['experience']);
    $password = mysqli_real_escape_string($conn,$_POST['password']);

    // Check duplicate email
    $check = mysqli_query($conn,"SELECT * FROM doctors WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('Doctor email already exists!');</script>";
    }else{

        mysqli_query($conn,"
        INSERT INTO doctors
        (doctor_name,specialization,department_id,phone,email,experience,password)
        VALUES
        ('$name','$specialization','$department','$phone','$email','$experience','$password')
        ");

        echo "<script>
                alert('Doctor Added Successfully!');
                window.location='manage_doctors.php';
              </script>";
    }
}

// ---------------- DELETE DOCTOR ----------------
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query($conn,"
    DELETE FROM doctors
    WHERE doctor_id='$id'
    ");

    echo "<script>
            alert('Doctor Deleted Successfully!');
            window.location='manage_doctors.php';
          </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Doctors | CareConnect Hospital</title>

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

            <li class="active">
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

            <li>
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

                <h1>Manage Doctors</h1>

                <p>Add, view and remove doctors from the hospital database.</p>

            </div>

        </section>

        <!-- Add Doctor Form -->
        <section class="appointment-form-card">

            <h2><i class="fa-solid fa-user-plus"></i> Add New Doctor</h2>

            <form method="POST">

                <label>Doctor Name</label>
                <input type="text"
                       name="doctor_name"
                       placeholder="Enter doctor's full name"
                       required>

                <label>Specialization</label>
                <input type="text"
                       name="specialization"
                       placeholder="Example: Cardiologist"
                       required>

                <label>Department</label>

                <select name="department" required>

                    <option value="">Select Department</option>

                    <?php
                    $dept = mysqli_query($conn,"SELECT * FROM departments");

                    while($row=mysqli_fetch_assoc($dept)){
                    ?>

                    <option value="<?php echo $row['department_id']; ?>">
                        <?php echo $row['department_name']; ?>
                    </option>

                    <?php } ?>

                </select>

                <label>Phone Number</label>

                <input type="tel"
                       name="phone"
                       placeholder="Enter phone number"
                       required>

                <label>Email Address</label>

                <input type="email"
                       name="email"
                       placeholder="doctor@example.com"
                       required>

                <label>Experience (Years)</label>

                <input type="number"
                       name="experience"
                       placeholder="Enter years of experience"
                       required>

                <label>Password</label>

                <input type="password"
                       name="password"
                       placeholder="Create login password"
                       required>

                <button type="submit"
                        name="addDoctor"
                        class="submit-btn">
                    Add Doctor
                </button>

            </form>

        </section>

        <!-- Doctor List -->
        <section class="appointment-history">

            <h2><i class="fa-solid fa-user-doctor"></i> Doctor List</h2>

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Doctor Name</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th>Email</th>
                        <th>Experience</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                <?php

                $doctorList = mysqli_query($conn,"
                SELECT
                d.doctor_id,
                d.doctor_name,
                d.specialization,
                d.email,
                d.experience,
                dep.department_name

                FROM doctors d

                JOIN departments dep
                ON d.department_id = dep.department_id

                ORDER BY d.doctor_id ASC
                ");

                if(mysqli_num_rows($doctorList)>0){

                    while($doctor=mysqli_fetch_assoc($doctorList)){

                ?>

                    <tr>

                        <td><?php echo $doctor['doctor_id']; ?></td>

                        <td><?php echo $doctor['doctor_name']; ?></td>

                        <td><?php echo $doctor['department_name']; ?></td>

                        <td><?php echo $doctor['specialization']; ?></td>

                        <td><?php echo $doctor['email']; ?></td>

                        <td><?php echo $doctor['experience']; ?> Years</td>

                        <td>

                            <a href="manage_doctors.php?delete=<?php echo $doctor['doctor_id']; ?>"
                               onclick="return confirm('Are you sure you want to delete this doctor?')">

                                <i class="fa-solid fa-trash"></i> Delete

                            </a>

                        </td>

                    </tr>

                <?php

                    }

                } else {

                ?>

                    <tr>

                        <td colspan="7" style="text-align:center;padding:20px;">
                            No doctors available.
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