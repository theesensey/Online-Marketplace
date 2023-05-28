<?php
//Creates a session or Resumes the current one based on a session identifier 
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page / method
    header('Location: ../login.php');
}

require_once '../config.php';

$user_id = $_SESSION['id'];

// Retrieve booked providers for the logged-in user
//regular join
// Retrieve booked services for the logged-in user
$query = "SELECT *
        FROM bookings
        INNER JOIN providers ON bookings.provider_id = providers.id
        WHERE bookings.user_id = '{$_SESSION['id']}'";

$result = mysqli_query($con, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user.css" class="css">
    <title>View Your Bookings</title>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a class="active" href="bookingview.php">Booking View</a>
        <a href="../logout.php">Log Out</a>
    </div>
    <div class="content">
        <h2 style="text-align: center;">Service-Providers you have booked</h2>

        <div class="table">
            <table id="providers" class="table">
                <tr>
                    <th>Id</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Profession</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Date Booked</th>
                    <th>Provider-Feedback</th>
                    <th>Delete</th>
                </tr>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td class="photo"><img src="../storage/<?= $row['photo'] ?>"></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['adder']; ?></td>
                        <td><?php echo $row['profession']; ?></td>
                        <td><?php echo $row['descr']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['feedback']; ?></td>
                        <td><a href='delete.php? provider=<?= $row["id"] ?>'>Cancel Booking</a></td>

                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</body>

</html>