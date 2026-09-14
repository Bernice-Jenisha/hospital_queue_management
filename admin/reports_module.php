<?php
include("includes/db.php");

$totalPatients = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM patients"))['total'];

$totalDoctors = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM doctors"))['total'];

$totalAppointments = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM appointments"))['total'];

$completed = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM appointments WHERE status='Completed'"))['total'];

$waiting = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) total FROM appointments WHERE status='Waiting'"))['total'];
?>

<section class="welcome-banner">

<div>
<h1>Hospital Reports</h1>
<p>Summary of hospital activities.</p>
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
    <i class="fa-solid fa-circle-check"></i>
    <h2><?php echo $completed; ?></h2>
    <p>Completed Consultations</p>
</div>

<div class="stats-card">
    <i class="fa-solid fa-hourglass-half"></i>
    <h2><?php echo $waiting; ?></h2>
    <p>Patients Waiting</p>
</div>

</section>

<section class="appointment-history">

<h2>System Report Summary</h2>

<table>

<tr>
<th>Report</th>
<th>Value</th>
</tr>

<tr>
<td>Total Registered Patients</td>
<td><?php echo $totalPatients; ?></td>
</tr>

<tr>
<td>Total Registered Doctors</td>
<td><?php echo $totalDoctors; ?></td>
</tr>

<tr>
<td>Total Appointments</td>
<td><?php echo $totalAppointments; ?></td>
</tr>

<tr>
<td>Completed Consultations</td>
<td><?php echo $completed; ?></td>
</tr>

<tr>
<td>Waiting Appointments</td>
<td><?php echo $waiting; ?></td>
</tr>

</table>

</section>