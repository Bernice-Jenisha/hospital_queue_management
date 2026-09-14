
<?php
include("includes/db.php");

$patientName = $_SESSION['patient_name'] ?? "Patient";
$patientId = $_SESSION['patient_id'];

// Count appointments of this patient
$totalAppointments = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) AS total FROM appointments WHERE patient_id='$patientId'"))['total'];

// Latest Queue Token
$queue = mysqli_query($conn,"
SELECT queue_tokens.token_number, queue_tokens.waiting_status
FROM queue_tokens
JOIN appointments ON queue_tokens.appointment_id = appointments.appointment_id
WHERE appointments.patient_id='$patientId'
ORDER BY queue_tokens.queue_id DESC
LIMIT 1
");

$queueData = mysqli_fetch_assoc($queue);
?>

<!-- Welcome Banner -->

<section class="welcome-banner">

    <div>
        <h1>Welcome, <?php echo $patientName; ?> 👋</h1>
        <p>Manage your appointments and track your hospital queue from one place.</p>
    </div>

</section>

<!-- Patient Statistics -->

<section class="stats-grid">

    <div class="stats-card">
        <i class="fa-solid fa-calendar-check"></i>
        <h2><?php echo $totalAppointments; ?></h2>
        <p>Total Appointments</p>
    </div>

    <div class="stats-card">
        <i class="fa-solid fa-ticket"></i>
        <h2>
            <?php echo $queueData['token_number'] ?? "--"; ?>
        </h2>
        <p>Queue Token</p>
    </div>

    <div class="stats-card">
        <i class="fa-solid fa-hourglass-half"></i>
        <h2>
            <?php echo $queueData['waiting_status'] ?? "Waiting"; ?>
        </h2>
        <p>Queue Status</p>
    </div>

</section>

<!-- Patient Services -->

<section class="actions-section">

    <h2>Patient Services</h2>

    <div class="action-grid">

        <a href="dashboard.php?page=appointment" class="action-card">
            <i class="fa-solid fa-calendar-plus"></i>
            <h3>Book Appointment</h3>
            <p>Choose a doctor and schedule your consultation.</p>
        </a>

        <a href="dashboard.php?page=queue" class="action-card">
            <i class="fa-solid fa-ticket"></i>
            <h3>Queue Status</h3>
            <p>Track your queue token and waiting time.</p>
        </a>

        <a href="dashboard.php?page=profile" class="action-card">
            <i class="fa-solid fa-user"></i>
            <h3>My Profile</h3>
            <p>View and update your personal information.</p>
        </a>

    </div>

</section>

<!-- Recent Appointments -->

<section class="appointment-history">

    <h2>My Recent Appointments</h2>

    <table>

        <tr>
            <th>Doctor</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
        </tr>

<?php

$appointments = mysqli_query($conn,"
SELECT doctors.doctor_name,
appointments.appointment_date,
appointments.appointment_time,
appointments.status
FROM appointments
JOIN doctors ON appointments.doctor_id = doctors.doctor_id
WHERE appointments.patient_id='$patientId'
ORDER BY appointments.appointment_date DESC
LIMIT 5
");

while($row=mysqli_fetch_assoc($appointments)){
?>

<tr>

<td><?php echo $row['doctor_name']; ?></td>

<td><?php echo $row['appointment_date']; ?></td>

<td><?php echo $row['appointment_time']; ?></td>

<td>
    <span class="status waiting">
        <?php echo $row['status']; ?>
    </span>
</td>

</tr>

<?php } ?>

    </table>

</section>
