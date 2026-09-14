<?php
include("includes/db.php");

// Dashboard Statistics
$totalPatients = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM patients"))['total'];

$totalDoctors = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM doctors"))['total'];

$totalAppointments = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM appointments"))['total'];

$totalDepartments = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM departments"))['total'];

// Recent Appointments
$recentAppointments = mysqli_query($conn,"
SELECT appointments.appointment_date,
       appointments.appointment_time,
       appointments.status,
       patients.full_name,
       doctors.doctor_name
FROM appointments
JOIN patients ON appointments.patient_id = patients.patient_id
JOIN doctors ON appointments.doctor_id = doctors.doctor_id
ORDER BY appointments.appointment_id DESC
LIMIT 5
");
?>

<!-- Welcome Banner -->

<section class="welcome-banner">

    <div>
        <h1>Welcome to CareConnect Hospital 👋</h1>

        <p>Hospital Queue and Appointment Management System Dashboard</p>
    </div>

</section>

<!-- Statistics -->

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

<!-- Quick Actions -->

<section class="actions-section">

    <h2>Quick Access</h2>

    <div class="action-grid">

        <a href="dashboard.php?page=appointment" class="action-card">
            <i class="fa-solid fa-calendar-plus"></i>
            <h3>Book Appointment</h3>
        </a>

        <a href="dashboard.php?page=queue" class="action-card">
            <i class="fa-solid fa-ticket"></i>
            <h3>Track Queue</h3>
        </a>

        <a href="dashboard.php?page=doctor" class="action-card">
            <i class="fa-solid fa-user-doctor"></i>
            <h3>Doctor Module</h3>
        </a>

        <a href="dashboard.php?page=reports" class="action-card">
            <i class="fa-solid fa-chart-column"></i>
            <h3>Reports</h3>
        </a>

    </div>

</section>

<!-- Recent Appointments -->

<section class="appointment-history">

    <h2>Recent Appointments</h2>

    <table>

        <tr>
            <th>Patient</th>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($recentAppointments)){ ?>

        <tr>

            <td><?php echo $row['full_name']; ?></td>

            <td><?php echo $row['doctor_name']; ?></td>

            <td><?php echo $row['appointment_date']; ?></td>

            <td><?php echo $row['appointment_time']; ?></td>

            <td><?php echo $row['status']; ?></td>

        </tr>

        <?php } ?>

    </table>

</section>