<?php
include("includes/db.php");

if(!isset($_SESSION['patient_id'])){
    header("Location: index.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

$result = mysqli_query($conn,"
SELECT queue_tokens.token_number,
       queue_tokens.waiting_status,
       queue_tokens.estimated_wait_time,
       appointments.appointment_date,
       appointments.appointment_time,
       doctors.doctor_name
FROM queue_tokens
JOIN appointments
ON queue_tokens.appointment_id = appointments.appointment_id
JOIN doctors
ON appointments.doctor_id = doctors.doctor_id
WHERE appointments.patient_id='$patient_id'
ORDER BY queue_tokens.queue_id DESC
LIMIT 1
");

$queue = mysqli_fetch_assoc($result);
?>

<section class="welcome-banner">

<div>
<h1>Queue Status</h1>
<p>Track your consultation queue.</p>
</div>

</section>

<div class="queue-token-card">

<?php if($queue){ ?>

<h2>Your Queue Token</h2>

<div class="queue-token">

<?php echo $queue['token_number']; ?>

</div>

<table>

<tr>
<th>Doctor</th>
<td><?php echo $queue['doctor_name']; ?></td>
</tr>

<tr>
<th>Date</th>
<td><?php echo $queue['appointment_date']; ?></td>
</tr>

<tr>
<th>Time</th>
<td><?php echo $queue['appointment_time']; ?></td>
</tr>

<tr>
<th>Status</th>
<td><?php echo $queue['waiting_status']; ?></td>
</tr>

<tr>
<th>Estimated Waiting</th>
<td><?php echo $queue['estimated_wait_time']; ?> Minutes</td>
</tr>

</table>

<?php }else{ ?>

<h2>No Appointment Found</h2>

<p>Please book an appointment first.</p>

<?php } ?>

</div>