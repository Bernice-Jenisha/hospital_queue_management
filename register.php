<?php
include("includes/db.php");

if(isset($_POST['register'])){

    $name = mysqli_real_escape_string($conn, $_POST['fullname']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if passwords match
    if($password != $confirmPassword){
        echo "<script>alert('Passwords do not match!');</script>";
    }

    // Check if email already exists
    else{

        $checkEmail = "SELECT * FROM patients WHERE email='$email'";
        $result = mysqli_query($conn, $checkEmail);

        if(mysqli_num_rows($result) > 0){
            echo "<script>alert('Email already registered! Please login.');</script>";
        }

        else{

            $sql = "INSERT INTO patients
                    (full_name, age, gender, phone, email, address, password)
                    VALUES
                    ('$name','$age','$gender','$phone','$email','$address','$password')";

            if(mysqli_query($conn, $sql)){
                echo "<script>
alert('Registration Successful!');
window.location='index.php';
</script>";
            }else{
                echo "<script>alert('Registration Failed!');</script>";
            }

        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration | CareConnect Hospital</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

<div class="auth-container">

    <!-- Left Image -->
    <div class="auth-image">
        <img src="https://images.unsplash.com/photo-1584515933487-779824d29309?w=600"
             alt="Hospital Registration">
    </div>

    <!-- Registration Form -->
    <div class="auth-form register-form">

        <h2><i class="fa-solid fa-user-plus"></i> Patient Registration</h2>
        <p>Create your CareConnect patient account.</p>

        <form method="POST" action="">

            <label>Full Name</label>
            <input type="text"
                   name="fullname"
                   placeholder="Enter full name"
                   required>

            <label>Age</label>
            <input type="number"
                   name="age"
                   placeholder="Enter age"
                   required>

            <label>Gender</label>
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <label>Phone Number</label>
            <input type="tel"
                   name="phone"
                   placeholder="Enter phone number"
                   required>

            <label>Email Address</label>
            <input type="email"
                   name="email"
                   placeholder="Enter email address"
                   required>

            <label>Address</label>
            <textarea name="address"
                      placeholder="Enter address"
                      rows="3"></textarea>

            <label>Password</label>
            <input type="password"
                   name="password"
                   placeholder="Create password"
                   required>

            <label>Confirm Password</label>
            <input type="password"
                   name="confirm_password"
                   placeholder="Confirm password"
                   required>

            <button type="submit"
                    name="register"
                    class="submit-btn">
                Create Account
            </button>

        </form>

        <div class="auth-links">
            <a href="index.php">Already have an account? Login</a>
            <a href="index.php">← Back to Home</a>
        </div>

    </div>

</div>

</body>
</html>