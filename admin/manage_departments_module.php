<?php
include("includes/db.php");

$departments = mysqli_query($conn,"
SELECT department_id,department_name
FROM departments
ORDER BY department_name ASC
");
?>

<section class="welcome-banner">

<div>
<h1>Hospital Departments</h1>
<p>Departments available in CareConnect Hospital.</p>
</div>

</section>

<section class="appointment-history">

<table>

<tr>
<th>Department ID</th>
<th>Department Name</th>
</tr>

<?php while($dept=mysqli_fetch_assoc($departments)){ ?>

<tr>

<td><?php echo $dept['department_id']; ?></td>
<td><?php echo $dept['department_name']; ?></td>

</tr>

<?php } ?>

</table>

</section>