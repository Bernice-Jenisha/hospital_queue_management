<?php
include("includes/db.php");

if(!isset($_SESSION['patient_id'])){
    header("Location: index.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];

/* BOOK APPOINTMENT */

if(isset($_POST['bookAppointment'])){

    $doctor_id = $_POST['doctor'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];

    mysqli_query($conn,"
    INSERT INTO appointments
    (patient_id,doctor_id,appointment_date,appointment_time,status)
    VALUES
    ('$patient_id','$doctor_id','$date','$time','Waiting')
    ");

    $appointment_id = mysqli_insert_id($conn);

    // Generate Queue Token
    $token = "A-" . str_pad(rand(1,99),2,"0",STR_PAD_LEFT);
    $wait = rand(10,30);

    mysqli_query($conn,"
    INSERT INTO queue_tokens
    (appointment_id,token_number,waiting_status,estimated_wait_time)
    VALUES
    ('$appointment_id','$token','Waiting','$wait')
    ");

    echo "<script>
        alert('Appointment Booked Successfully!');
        window.location='dashboard.php?page=queue';
    </script>";
}

/* FETCH DOCTORS */

$doctors = mysqli_query($conn,"
SELECT doctor_id,doctor_name,specialization
FROM doctors
ORDER BY doctor_name ASC
");
?>

<section class="welcome-banner">

<div>
<h1>Book Appointment</h1>
<p>Schedule an appointment with your preferred doctor.</p>
</div>

</section>

<div class="appointment-form-card">

<h2>Appointment Form</h2>

<form method="POST">

<label>Select Doctor</label>

<select name="doctor" required>

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

<option value="09:00 AM">09:00 AM</option>
<option value="10:00 AM">10:00 AM</option>
<option value="11:00 AM">11:00 AM</option>
<option value="12:00 PM">12:00 PM</option>
<option value="02:00 PM">02:00 PM</option>
<option value="03:00 PM">03:00 PM</option>
<option value="04:00 PM">04:00 PM</option>

</select>

<button type="submit"
name="bookAppointment"
class="submit-btn">

Confirm Appointment

</button>

</form>

</div>