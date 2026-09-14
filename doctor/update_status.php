<?php
include("../includes/db.php");

if(isset($_GET['id']) && isset($_GET['status'])){

    $appointment_id = $_GET['id'];
    $status = $_GET['status'];

    // Update Appointment Status
    mysqli_query($conn,"
    UPDATE appointments
    SET status='$status'
    WHERE appointment_id='$appointment_id'
    ");

    // Update Queue Token Status
    mysqli_query($conn,"
    UPDATE queue_tokens
    SET waiting_status='$status'
    WHERE appointment_id='$appointment_id'
    ");

}

header("Location: ../dashboard.php?page=doctor");
exit();
?>