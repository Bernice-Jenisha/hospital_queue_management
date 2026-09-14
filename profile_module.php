
<?php
include("includes/db.php");

$patient_id = $_SESSION['patient_id'];

// UPDATE PROFILE
if(isset($_POST['updateProfile'])){

    $name = mysqli_real_escape_string($conn,$_POST['fullname']);
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $gender = mysqli_real_escape_string($conn,$_POST['gender']);
    $phone = mysqli_real_escape_string($conn,$_POST['phone']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);

    mysqli_query($conn,"
        UPDATE patients SET
        full_name='$name',
        age='$age',
        gender='$gender',
        phone='$phone',
        email='$email',
        address='$address'
        WHERE patient_id='$patient_id'
    ");

    $_SESSION['patient_name'] = $name;

    echo "<script>alert('Profile Updated Successfully!');</script>";
}

// FETCH DETAILS
$result = mysqli_query($conn,"
SELECT * FROM patients WHERE patient_id='$patient_id'
");

$patient = mysqli_fetch_assoc($result);
?>

<section class="welcome-banner">
    <h1>My Profile</h1>
    <p>Update your personal information.</p>
</section>

<div class="profile-card">

<form method="POST">

    <label>Full Name</label>
    <input type="text" name="fullname"
    value="<?php echo $patient['full_name']; ?>" required>

    <label>Age</label>
    <input type="number" name="age"
    value="<?php echo $patient['age']; ?>" required>

    <label>Gender</label>

    <select name="gender" required>

        <option value="Male"
        <?php if($patient['gender']=="Male") echo "selected"; ?>>
        Male
        </option>

        <option value="Female"
        <?php if($patient['gender']=="Female") echo "selected"; ?>>
        Female
        </option>

        <option value="Other"
        <?php if($patient['gender']=="Other") echo "selected"; ?>>
        Other
        </option>

    </select>

    <label>Phone Number</label>
    <input type="text" name="phone"
    value="<?php echo $patient['phone']; ?>" required>

    <label>Email Address</label>
    <input type="email" name="email"
    value="<?php echo $patient['email']; ?>" required>

    <label>Address</label>
    <textarea name="address" rows="3"><?php echo $patient['address']; ?></textarea>

    <button type="submit"
            name="updateProfile"
            class="submit-btn">
        Update Profile
    </button>

</form>

</div>
