<?php
include("includes/db.php");

$patients = mysqli_query($conn,"
SELECT patient_id,full_name,age,gender,phone,email
FROM patients
ORDER BY patient_id DESC
");
?>

<section class="welcome-banner">

<div>
<h1>Manage Patients</h1>
<p>View all registered patients.</p>
</div>

</section>

<section class="appointment-history">

<table>

<tr>
<th>ID</th>
<th>Name</th>
<th>Age</th>
<th>Gender</th>
<th>Phone</th>
<th>Email</th>
</tr>

<?php while($patient=mysqli_fetch_assoc($patients)){ ?>

<tr>

<td><?php echo $patient['patient_id']; ?></td>
<td><?php echo $patient['full_name']; ?></td>
<td><?php echo $patient['age']; ?></td>
<td><?php echo $patient['gender']; ?></td>
<td><?php echo $patient['phone']; ?></td>
<td><?php echo $patient['email']; ?></td>

</tr>

<?php } ?>

</table>

</section>