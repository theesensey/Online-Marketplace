<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php ');
}

require_once '../config.php';

$provider_id = $_SESSION['id'];

// Retrieve users who have booked this service provider
$sql = "SELECT * FROM bookings";
$result = mysqli_query($con, $sql);
$num_bookings = mysqli_num_rows($result);

// Retrieve all users in the system
$sql = "SELECT * FROM users";
$result = mysqli_query($con, $sql);
$num_users = mysqli_num_rows($result);

// Retrieve users who have booked this service provider
$sql = "SELECT * FROM providers";
$result = mysqli_query($con, $sql);
$num_providers = mysqli_num_rows($result);

// Retrieve users who have booked this service provider
$sql = "SELECT * FROM providers WHERE verification_status = 'unverified'";
$result = mysqli_query($con, $sql);
$unverified_providers = mysqli_num_rows($result);

// Retrieve verifies users
$sql = "SELECT * FROM providers WHERE verification_status = 'verified'";
$result = mysqli_query($con, $sql);
$verified_providers = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css" class="css">
    <title>Admin</title>
    <style>
        /* Style for the dashboard */
        .dashboard {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 20px;
            justify-items: center;
            align-items: center;
            margin: 20px;
        }

        .dashboard__card {
            width: 60%;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .dashboard__card h2 {
        font-size: 36px;
        font-weight: 700;
        margin: 0;
    }

    .dashboard__card p {
        font-size: 18px;
        font-weight: 400;
        margin: 0;
        color: #e5dddd;
    }

    .bookings {
        background-color: #1abc9c;
        color: #fff;
    }

    .users {
        background-color: #3498db;
        color: #fff;
    }

    .providers {
        background-color: #9b59b6;
        color: #fff;
    }

    .unverified {
        background-color: #a5d748;
        color: #fff;
    }
    .verified {
        background-color: #a5d748;
        color: #fff;
    }
    </style>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a class="active" href="index.php">Home</a>
        <a href="verify.php">Verification</a>
        <a href="reports.php">Reports</a>
        <a href="deleteupdate.php">Delete and Update</a>
        <a href="../index.php">Log Out</a>
    </div>

    <div class="content">
    <!-- The dashboard -->
    <div class="dashboard">
        <div class="dashboard__card bookings">
            <h2><?php echo $num_bookings; ?></h2>
            <a href="bookedproviders.php"><p>Booked Providers</p></a>
        </div>
        <div class="dashboard__card users">
            <h2><?php echo $num_users; ?></h2>
        <a href="users.php"><p>Users in the System</p> </a>
        </div>
        <div class="dashboard__card providers">
            <h2><?php echo $num_providers; ?></h2>
            <a href="filterproviders.php"><p>Providers in the System</p></a>
        </div>
        <div class="dashboard__card unverified">
        <h2><?php echo $unverified_providers; ?></h2>
        <a href="verify.php"> Unverified Providers</a>
        </div>
        <div class="dashboard__card verified">
        <h2><?php echo $verified_providers; ?></h2>
        <a href="verified.php">Verified Providers</a>
        </div>
    </div>
</body>