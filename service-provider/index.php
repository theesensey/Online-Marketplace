<?php

//Creates a session or Resumes the current one based on a session identifier 
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to approriate page / method
    header('Location: ../login.php ');
}
require_once '../config.php';

$provider_id = $_SESSION['id'];

// Retrieve users who have booked this service provider
$query = "SELECT bookings.id, users.id as user_id, users.name, users.email, users.contact, bookings.date, bookings.status
        FROM bookings
        INNER JOIN users ON bookings.user_id = users.id
        WHERE bookings.provider_id = '$provider_id'";

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
    <title>Service-Provider</title>
</head>
<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a class="active" href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="../logout.php">Log Out</a>
    </div>
    <div class="content">
        <br>
        <h2 style="text-align: center;">Users who have booked you</h2>
            <div class="table">
            <table id="users" class="table">
    <tr>
        <th>Booking ID</th>
        <th>User ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Booking Date</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['contact']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <?php if ($row['status'] == 'pending') { ?>
                <td><a href="confirm_bookings.php?id=<?php echo $row['id']; ?>">Confirm Booking</a></td>
            <?php } else { ?>
                <td><?php echo ucfirst($row['status']); ?></td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>

            </div>
    </div>
</body>
</html>
