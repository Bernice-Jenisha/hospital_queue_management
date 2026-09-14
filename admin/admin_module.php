<?php
include("includes/db.php");

// Statistics
$totalPatients = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM patients"))['total'];

$totalDoctors = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM doctors"))['total'];

$totalAppointments = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM appointments"))['total'];

$totalDepartments = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM departments"))['total'];
?>

<section class="welcome-banner">

    <div>
        <h1>Administrator Dashboard</h1>
        <p>Manage the complete CareConnect Hospital Management System.</p>
    </div>

</section>

<section class="stats-grid">

    <div class="stats-card">
        <i class="fa-solid fa-users"></i>
        <h2><?php echo $totalPatients; ?></h2>
        <p>Total Patients</p>
    </div>

    <div class="stats-card">
        <i class="fa-solid fa-user-doctor"></i>
        <h2><?php echo $totalDoctors; ?></h2>
        <p>Total Doctors</p>
    </div>

    <div class="stats-card">
        <i class="fa-solid fa-calendar-check"></i>
        <h2><?php echo $totalAppointments; ?></h2>
        <p>Total Appointments</p>
    </div>

    <div class="stats-card">
        <i class="fa-solid fa-building"></i>
        <h2><?php echo $totalDepartments; ?></h2>
        <p>Departments</p>
    </div>

</section>

<section class="actions-section">

<h2>Administration Panel</h2>

<div class="action-grid">

<a href="dashboard.php?page=manageDoctors" class="action-card">
    <i class="fa-solid fa-user-doctor"></i>
    <h3>Manage Doctors</h3>
</a>

<a href="dashboard.php?page=managePatients" class="action-card">
    <i class="fa-solid fa-users"></i>
    <h3>Manage Patients</h3>
</a>

<a href="dashboard.php?page=manageDepartments" class="action-card">
    <i class="fa-solid fa-building"></i>
    <h3>Departments</h3>
</a>

<a href="dashboard.php?page=reports" class="action-card">
    <i class="fa-solid fa-chart-column"></i>
    <h3>Reports</h3>
</a>

</div>

</section>