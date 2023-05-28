<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php ');
}

require_once '../config.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../marketplace.ico">
    <title>Reports</title>
    <link rel="stylesheet" href="../user/user.css" class="css">
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a href="verify.php">Verification</a>
        <a class="active" href="reports.php">Reports</a>
        <a href="deleteupdate.php">Delete and Update</a>
        <a href="../index.php">Log Out</a>
    </div>
    <div class="content">
        <br>
            <a href="filterproviders.php">
                <button class="submitbtn">Reports On Service Providers</button>
            </a>
            <a href="users.php">
                <button class="submitbtn">Reports On Users </button>
            </a>
            <a href="verificationproviders.php">
                <button class="submitbtn">Reports On Service Providers Based On Verification</button>
            </a>
            <br><br><br>
            <a href="index.php">Back to Home</a><br>
        </div>
    </div>
</body>

</html>