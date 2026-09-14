<?php
include("includes/db.php");

// Check doctor session
$doctor_id = $_SESSION['doctor_id'];
$doctor_name = $_SESSION['doctor_name'];

// ---------------- UPDATE STATUS ----------------

// Call Next
if(isset($_GET['call'])){

    $appointment_id = $_GET['call'];

    mysqli_query($conn,"
    UPDATE appointments
    SET status='Now Serving'
    WHERE appointment_id='$appointment_id'
    AND doctor_id='$doctor_id'
    ");

    header("Location: dashboard.php?page=doctor");
    exit();
}

// Complete Consultation
if(isset($_GET['complete'])){

    $appointment_id = $_GET['complete'];

    mysqli_query($conn,"
    UPDATE appointments
    SET status='Completed'
    WHERE appointment_id='$appointment_id'
    AND doctor_id='$doctor_id'
    ");

    header("Location: dashboard.php?page=doctor");
    exit();
}

// ---------------- FETCH APPOINTMENTS ----------------

$appointments = mysqli_query($conn,"
SELECT
appointments.appointment_id,
appointments.appointment_date,
appointments.appointment_time,
appointments.status,
patients.full_name,
doctors.doctor_name
FROM appointments

JOIN patients
ON appointments.patient_id = patients.patient_id

JOIN doctors
ON appointments.doctor_id = doctors.doctor_id

WHERE appointments.doctor_id='$doctor_id'

ORDER BY appointments.appointment_date ASC,
appointments.appointment_time ASC
");
?>

<!-- Welcome Banner -->

<section class="welcome-banner">

    <div>
        <h1>Welcome Dr. <?php echo $doctor_name; ?> 👨‍⚕️</h1>
        <p>Manage your patient appointments and consultations.</p>
    </div>

</section>

<!-- Appointment Table -->

<section class="appointment-history">

<h2>Today's Appointments</h2>

<table>

<tr>
    <th>Patient</th>
    <th>Doctor</th>
    <th>Date</th>
    <th>Time</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($appointments)){ ?>

<tr>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['doctor_name']; ?></td>

<td><?php echo $row['appointment_date']; ?></td>

<td><?php echo date("h:i A",strtotime($row['appointment_time'])); ?></td>

<td>

<?php
$status = $row['status'];

if($status=="Waiting"){
    echo "<span class='status waiting'>Waiting</span>";
}

elseif($status=="Now Serving"){
    echo "<span class='status serving'>Now Serving</span>";
}

elseif($status=="Completed"){
    echo "<span class='status completed'>Completed</span>";
}
?>

</td>

<td>

<?php if($status=="Waiting"){ ?>

<a class="primary-btn"
href="dashboard.php?page=doctor&call=<?php echo $row['appointment_id']; ?>">
Call Next
</a>

<?php } ?>

<?php if($status=="Now Serving"){ ?>

<a class="submit-btn"
href="dashboard.php?page=doctor&complete=<?php echo $row['appointment_id']; ?>">
Complete
</a>

<?php } ?>

<?php if($status=="Completed"){ ?>

<span style="color:green;font-weight:600;">
Consultation Completed
</span>

<?php } ?>

</td>

</tr>

<?php } ?>

</table>

</section>