<?php
session_start();
include("../includes/db.php");

// Check Admin Login
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// ---------------- DELETE PATIENT ----------------
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    // Delete queue tokens related to patient's appointments
    mysqli_query($conn,"
        DELETE q FROM queue_tokens q
        JOIN appointments a ON q.appointment_id = a.appointment_id
        WHERE a.patient_id='$id'
    ");

    // Delete appointments
    mysqli_query($conn,"
        DELETE FROM appointments
        WHERE patient_id='$id'
    ");

    // Delete patient
    mysqli_query($conn,"
        DELETE FROM patients
        WHERE patient_id='$id'
    ");

    echo "<script>
            alert('Patient Deleted Successfully!');
            window.location='manage_patients.php';
          </script>";
}

// ---------------- SEARCH ----------------
$search = "";

if(isset($_GET['search'])){
    $search = mysqli_real_escape_string($conn,$_GET['search']);

    $patients = mysqli_query($conn,"
    SELECT p.*,
           COUNT(a.appointment_id) AS total_appointments
    FROM patients p
    LEFT JOIN appointments a
        ON p.patient_id = a.patient_id
    WHERE p.full_name LIKE '%$search%'
       OR p.email LIKE '%$search%'
    GROUP BY p.patient_id
    ORDER BY p.patient_id DESC
    ");

}else{

    $patients = mysqli_query($conn,"
    SELECT p.*,
           COUNT(a.appointment_id) AS total_appointments
    FROM patients p
    LEFT JOIN appointments a
        ON p.patient_id = a.patient_id
    GROUP BY p.patient_id
    ORDER BY p.patient_id DESC
    ");
}

// Total Patients
$totalPatients = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) AS total FROM patients
"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Patients | CareConnect Hospital</title>

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

            <li class="active">
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
                <h1>Manage Patients</h1>
                <p>View, search and remove registered patients.</p>
            </div>

        </section>

        <!-- Statistics -->
        <section class="stats-grid">

            <div class="stats-card">
                <i class="fa-solid fa-users"></i>
                <h2><?php echo $totalPatients; ?></h2>
                <p>Total Registered Patients</p>
            </div>

        </section>

        <!-- Search Patient -->
        <section class="appointment-form-card">

            <h2><i class="fa-solid fa-magnifying-glass"></i> Search Patient</h2>

            <form method="GET">

                <input type="text"
                       name="search"
                       value="<?php echo $search; ?>"
                       placeholder="Search by Patient Name or Email">

                <button class="submit-btn">
                    Search
                </button>

            </form>

        </section>

        <!-- Patient Table -->
        <section class="appointment-history">

            <h2><i class="fa-solid fa-users"></i> Patient Records</h2>

            <table>

                <thead>

                    <tr>
                        <th>Patient ID</th>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Appointments</th>
                        <th>Action</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                if(mysqli_num_rows($patients) > 0){

                    while($patient = mysqli_fetch_assoc($patients)){
                ?>

                    <tr>

                        <td><?php echo $patient['patient_id']; ?></td>

                        <td><?php echo $patient['full_name']; ?></td>

                        <td><?php echo $patient['age']; ?></td>

                        <td><?php echo $patient['gender']; ?></td>

                        <td><?php echo $patient['phone']; ?></td>

                        <td><?php echo $patient['email']; ?></td>

                        <td><?php echo $patient['total_appointments']; ?></td>

                        <td>

                            <a href="manage_patients.php?delete=<?php echo $patient['patient_id']; ?>"
                               onclick="return confirm('Delete this patient and all appointments?')">

                                <i class="fa-solid fa-trash"></i> Delete

                            </a>

                        </td>

                    </tr>

                <?php
                    }

                }else{
                ?>

                    <tr>
                        <td colspan="8" style="text-align:center;padding:20px;">
                            No patients found.
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