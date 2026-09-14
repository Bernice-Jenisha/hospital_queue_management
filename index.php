<?php
session_start();
include("includes/db.php");

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = $_POST['role'];

    // ================= PATIENT LOGIN =================
    if($role == "patient"){

        $query = mysqli_query($conn,
        "SELECT * FROM patients WHERE email='$email' AND password='$password'");

        if(mysqli_num_rows($query) == 1){

            $patient = mysqli_fetch_assoc($query);

            $_SESSION['role'] = "patient";
            $_SESSION['patient_id'] = $patient['patient_id'];
            $_SESSION['patient_name'] = $patient['full_name'];

            header("Location: dashboard.php?page=patient");
            exit();
        }
    }

    // ================= DOCTOR LOGIN =================
    if($role == "doctor"){

        $query = mysqli_query($conn,
        "SELECT * FROM doctors WHERE email='$email' AND password='$password'");

        if(mysqli_num_rows($query) == 1){

            $doctor = mysqli_fetch_assoc($query);

            $_SESSION['role'] = "doctor";
            $_SESSION['doctor_id'] = $doctor['doctor_id'];
            $_SESSION['doctor_name'] = $doctor['doctor_name'];

            header("Location: dashboard.php?page=doctor");
            exit();
        }
    }

    // ================= RECEPTIONIST LOGIN =================
    if($role == "receptionist"){

        $query = mysqli_query($conn,
        "SELECT * FROM receptionists WHERE email='$email' AND password='$password'");

        if(mysqli_num_rows($query) == 1){

            $reception = mysqli_fetch_assoc($query);

            $_SESSION['role'] = "receptionist";
            $_SESSION['receptionist_id'] = $reception['receptionist_id'];
            $_SESSION['receptionist_name'] = $reception['receptionist_name'];

            header("Location: dashboard.php?page=reception");
            exit();
        }
    }

    // ================= ADMIN LOGIN =================
    if($role == "admin"){

        $query = mysqli_query($conn,
        "SELECT * FROM admins WHERE email='$email' AND password='$password'");

        if(mysqli_num_rows($query) == 1){

            $admin = mysqli_fetch_assoc($query);

            $_SESSION['role'] = "admin";
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['admin_name'] = $admin['name'];

            header("Location: dashboard.php?page=admin");
            exit();
        }
    }

    $error = "Invalid Email, Password or Role!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareConnect Hospital | Login</title>

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
             alt="Hospital Login">
    </div>

    <!-- Login Form -->
    <div class="auth-form">

        <h2><i class="fa-solid fa-hospital"></i> CareConnect Hospital</h2>

        <p>Hospital Queue & Appointment Management System</p>

        <?php if(isset($error)){ ?>
            <div style="background:#FEE2E2;color:#B91C1C;padding:10px;border-radius:8px;margin-bottom:15px;">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <form method="POST">

            <label>Email Address</label>
            <input type="email"
                   name="email"
                   placeholder="Enter your email"
                   required>

            <label>Password</label>
            <input type="password"
                   name="password"
                   placeholder="Enter password"
                   required>

            <label>Login As</label>
            <select name="role" required>
                <option value="">Select Role</option>
                <option value="patient">Patient</option>
                <option value="doctor">Doctor</option>
                <option value="receptionist">Receptionist</option>
                <option value="admin">Administrator</option>
            </select>

            <button type="submit"
                    name="login"
                    class="submit-btn">
                Login
            </button>

        </form>

        <div class="auth-links">
            <a href="register.php">New Patient? Register Here</a>
        </div>

        <hr>

        <p style="font-size:13px;color:gray;">
            Login using your role credentials.
        </p>

    </div>

</div>

</body>
</html>