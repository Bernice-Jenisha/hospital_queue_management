<?php
include("includes/db.php");

// Register Walk-in Patient
if(isset($_POST['registerPatient'])){

    $name = mysqli_real_escape_string($conn,$_POST['full_name']);
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);

    mysqli_query($conn,"
    INSERT INTO patients
    (full_name,age,gender,phone,email,address,password)
    VALUES
    ('$name','$age','$gender','$phone','','','')
    ");

    echo "<script>alert('Walk-in Patient Registered Successfully');</script>";
}

// Fetch Doctors
$doctors = mysqli_query($conn,"
SELECT doctor_id,doctor_name,specialization
FROM doctors
ORDER BY doctor_name ASC
");

// Today's Queue
$queue = mysqli_query($conn,"
SELECT queue_tokens.token_number,
       queue_tokens.waiting_status,
       patients.full_name,
       doctors.doctor_name
FROM queue_tokens
JOIN appointments
ON queue_tokens.appointment_id = appointments.appointment_id
JOIN patients
ON appointments.patient_id = patients.patient_id
JOIN doctors
ON appointments.doctor_id = doctors.doctor_id
ORDER BY queue_tokens.queue_id DESC
LIMIT 10
");
?>

<section class="welcome-banner">
    <div>
        <h1>Receptionist Dashboard</h1>
        <p>Register walk-in patients and manage today's queue.</p>
    </div>
</section>

<!-- Walk-in Registration -->

<div class="appointment-form-card">

    <h2>Register Walk-in Patient</h2>

    <form method="POST">

        <label>Patient Name</label>
        <input type="text" name="full_name" required>

        <label>Age</label>
        <input type="number" name="age" required>

        <label>Gender</label>
        <select name="gender" required>
            <option value="">Select Gender</option>
            <option>Male</option>
            <option>Female</option>
            <option>Other</option>
        </select>

        <label>Phone Number</label>
        <input type="text" name="phone" required>

        <button type="submit"
                name="registerPatient"
                class="submit-btn">
            Register Patient
        </button>

    </form>

</div>

<!-- Walk-in Appointment -->

<div class="appointment-form-card" style="margin-top:25px;">

<h2>Book Walk-in Appointment</h2>

<form action="receptionist/book_walkin.php" method="POST">

<label>Select Patient</label>

<select name="patient_id" required>

<option value="">Select Patient</option>

<?php
$patients = mysqli_query($conn,"
SELECT patient_id,full_name
FROM patients
ORDER BY patient_id DESC
");

while($patient=mysqli_fetch_assoc($patients)){
?>

<option value="<?php echo $patient['patient_id']; ?>">
<?php echo $patient['full_name']; ?>
</option>

<?php } ?>

</select>

<label>Select Doctor</label>

<select name="doctor_id" required>

<option value="">Choose Doctor</option>

<?php while($doctor=mysqli_fetch_assoc($doctors)){ ?>

<option value="<?php echo $doctor['doctor_id']; ?>">
<?php echo $doctor['doctor_name']; ?>
(<?php echo $doctor['specialization']; ?>)
</option>

<?php } ?>

</select>

<label>Appointment Date</label>

<input type="date"
name="appointment_date"
required>

<label>Appointment Time</label>

<select name="appointment_time" required>

<option value="">Choose Time</option>

<option>09:00 AM</option>
<option>10:00 AM</option>
<option>11:00 AM</option>
<option>12:00 PM</option>
<option>02:00 PM</option>
<option>03:00 PM</option>
<option>04:00 PM</option>

</select>

<button type="submit"
class="submit-btn">
Generate Queue Token
</button>

</form>

</div>

<!-- Today's Queue -->

<section class="appointment-history">

<h2>Today's Queue</h2>

<table>

<tr>
<th>Token</th>
<th>Patient</th>
<th>Doctor</th>
<th>Status</th>
</tr>

<?php while($row=mysqli_fetch_assoc($queue)){ ?>

<tr>

<td><?php echo $row['token_number']; ?></td>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['doctor_name']; ?></td>

<td><?php echo $row['waiting_status']; ?></td>

</tr>

<?php } ?>

</table>

</section>