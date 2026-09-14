<?php
session_start();

// User must be logged in
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

// Current page
$page = $_GET['page'] ?? "home";

// Display logged-in user's name
$userName = "User";

switch ($_SESSION['role']) {
    case "patient":
        $userName = $_SESSION['patient_name'] ?? "Patient";
        break;

    case "doctor":
        $userName = $_SESSION['doctor_name'] ?? "Doctor";
        break;

    case "receptionist":
        $userName = $_SESSION['receptionist_name'] ?? "Receptionist";
        break;

    case "admin":
        $userName = $_SESSION['admin_name'] ?? "Administrator";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareConnect Dashboard</title>

    <link rel="stylesheet" href="css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>

<body>

<div class="dashboard-container">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <h2>
            <i class="fa-solid fa-hospital"></i>
            CareConnect
        </h2>

        <div class="user-role">
            <p><strong><?php echo ucfirst($_SESSION['role']); ?></strong></p>
            <small><?php echo $userName; ?></small>
        </div>

        <ul>

            <!-- Common Dashboard -->
            <li class="menu-title">Main Menu</li>

            <?php if($_SESSION['role']=="patient"){ ?>
<li>
    <a href="dashboard.php?page=patient">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>
</li>
<?php } ?>

<?php if($_SESSION['role']=="doctor"){ ?>
<li>
    <a href="dashboard.php?page=doctor">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>
</li>
<?php } ?>

<?php if($_SESSION['role']=="receptionist"){ ?>
<li>
    <a href="dashboard.php?page=reception">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>
</li>
<?php } ?>

<?php if($_SESSION['role']=="admin"){ ?>
<li>
    <a href="dashboard.php?page=admin">
        <i class="fa-solid fa-house"></i>
        Dashboard
    </a>
</li>
<?php } ?>

            <!-- PATIENT MENU -->
            <?php if($_SESSION['role']=="patient"){ ?>

                <li class="menu-title">Patient</li>

                <li>
                    <a href="dashboard.php?page=patient">
                        <i class="fa-solid fa-user"></i>
                        Patient Home
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=appointment">
                        <i class="fa-solid fa-calendar-check"></i>
                        Book Appointment
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=queue">
                        <i class="fa-solid fa-ticket"></i>
                        Queue Status
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=profile">
                        <i class="fa-solid fa-user-pen"></i>
                        My Profile
                    </a>
                </li>

            <?php } ?>

            <!-- DOCTOR MENU -->
            <?php if($_SESSION['role']=="doctor"){ ?>

                <li class="menu-title">Doctor</li>

                <li>
                    <a href="dashboard.php?page=doctor">
                        <i class="fa-solid fa-user-doctor"></i>
                        Doctor Dashboard
                    </a>
                </li>

            <?php } ?>

            <!-- RECEPTIONIST MENU -->
            <?php if($_SESSION['role']=="receptionist"){ ?>

                <li class="menu-title">Receptionist</li>

                <li>
                    <a href="dashboard.php?page=reception">
                        <i class="fa-solid fa-users"></i>
                        Reception Dashboard
                    </a>
                </li>

            <?php } ?>

            <!-- ADMIN MENU -->
            <?php if($_SESSION['role']=="admin"){ ?>

                <li class="menu-title">Administrator</li>

                <li>
                    <a href="dashboard.php?page=admin">
                        <i class="fa-solid fa-user-shield"></i>
                        Admin Dashboard
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=manageDoctors">
                        <i class="fa-solid fa-user-doctor"></i>
                        Manage Doctors
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=managePatients">
                        <i class="fa-solid fa-users"></i>
                        Manage Patients
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=manageDepartments">
                        <i class="fa-solid fa-building"></i>
                        Departments
                    </a>
                </li>

                <li>
                    <a href="dashboard.php?page=reports">
                        <i class="fa-solid fa-chart-column"></i>
                        Reports
                    </a>
                </li>

            <?php } ?>

            <!-- LOGOUT -->
            <li class="menu-title">Account</li>

            <li>
                <a href="logout.php">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </li>

        </ul>

    </aside>

    <!-- ================= MAIN CONTENT ================= -->

    <main class="dashboard-content">

        <?php

        switch($page){

            case "home":

    if($_SESSION['role'] == "patient"){
        include("patient_module.php");
    }

    elseif($_SESSION['role'] == "doctor"){
        include("doctor/doctor_module.php");
    }

    elseif($_SESSION['role'] == "receptionist"){
        include("receptionist/receptionist_module.php");
    }

    elseif($_SESSION['role'] == "admin"){
        include("admin/admin_module.php");
    }

    break;

            /* PATIENT MODULES */
            case "patient":
                include("patient_module.php");
                break;

            case "appointment":
                include("appointment_module.php");
                break;

            case "queue":
                include("queue_module.php");
                break;

            case "profile":
                include("profile_module.php");
                break;

            /* DOCTOR MODULE */
            case "doctor":
                include("doctor/doctor_module.php");
                break;

            /* RECEPTIONIST MODULE */
            case "reception":
                include("receptionist/receptionist_module.php");
                break;

            /* ADMIN MODULES */
            case "admin":
                include("admin/admin_module.php");
                break;

            case "manageDoctors":
                include("admin/manage_doctors_module.php");
                break;

            case "managePatients":
                include("admin/manage_patients_module.php");
                break;

            case "manageDepartments":
                include("admin/manage_departments_module.php");
                break;

            case "reports":
                include("admin/reports_module.php");
                break;

            default:
                include("home_module.php");
                break;
        }

        ?>

    </main>

</div>

</body>
</html>