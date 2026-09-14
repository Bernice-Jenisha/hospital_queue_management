<?php
include("../includes/db.php");

if(isset($_POST['patient_id'])){

    $patient = $_POST['patient_id'];
    $doctor = $_POST['doctor_id'];
    $date = $_POST['appointment_date'];
    $time = $_POST['appointment_time'];

    // Insert Appointment
    mysqli_query($conn,"
    INSERT INTO appointments
    (patient_id,doctor_id,appointment_date,appointment_time,status)
    VALUES
    ('$patient','$doctor','$date','$time','Waiting')
    ");

    $appointment_id = mysqli_insert_id($conn);

    // Queue Token
    $token = "A-" . str_pad(rand(1,99),2,"0",STR_PAD_LEFT);
    $wait = rand(10,30);

    mysqli_query($conn,"
    INSERT INTO queue_tokens
    (appointment_id,token_number,waiting_status,estimated_wait_time)
    VALUES
    ('$appointment_id','$token','Waiting','$wait')
    ");

    echo "<script>
        alert('Walk-in Appointment Booked Successfully!');
        window.location='../dashboard.php?page=reception';
    </script>";
}
?>