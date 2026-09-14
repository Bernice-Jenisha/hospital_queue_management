<?php
include("includes/db.php");

$doctors = mysqli_query($conn,"
SELECT doctor_id,doctor_name,specialization,phone,email
FROM doctors
ORDER BY doctor_name ASC
");
?>

<section class="welcome-banner">

<div>
<h1>Manage Doctors</h1>
<p>View all registered doctors.</p>
</div>

</section>

<div class="appointment-form-card">

<a href="admin/manage_doctors.php"
class="submit-btn"
style="display:inline-block;text-decoration:none;text-align:center;">
Add / Delete Doctors
</a>

</div>

<section class="appointment-history">

<table>

<tr>
<th>ID</th>
<th>Doctor Name</th>
<th>Specialization</th>
<th>Phone</th>
<th>Email</th>
</tr>

<?php while($doctor=mysqli_fetch_assoc($doctors)){ ?>

<tr>

<td><?php echo $doctor['doctor_id']; ?></td>
<td><?php echo $doctor['doctor_name']; ?></td>
<td><?php echo $doctor['specialization']; ?></td>
<td><?php echo $doctor['phone']; ?></td>
<td><?php echo $doctor['email']; ?></td>

</tr>

<?php } ?>

</table>

</section>