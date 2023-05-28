<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php ');
}

require_once '../config.php';
//Query to get all new provider registrations
$query = "SELECT * FROM providers WHERE verification_status = 'verified'";
$result = mysqli_query($con, $query);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css" class="css">
    <title>Verification</title>
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
    <!-- The main content area -->
    <div class="content">
        <h2>Provider Registrations</h2>
        <a href="index.php">Back to Home</a>
        <div class="table">
                <table id="providers" class="table">
                    <tr>
                    <th>Photo</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Profession</th>
                    <th>Contact</th>
                    <th>Verification Status</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                        <td class="photo"><img src="../storage/<?= $row['photo'] ?>"></td>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['profession']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['verification_status']; ?></td>
                        </tr>
                    <?php } 
                    ?>
                </table>
            </div>

        </form>
</body>