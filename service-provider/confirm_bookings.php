<?php
session_start();
if (!$_SESSION['email']) {
    header('Location: ../login.php');
}
require_once '../config.php';

if (isset($_GET['accept_id'])) {
    $booking_id = $_GET['accept_id'];
    $query = "UPDATE bookings SET status='accepted' WHERE id='$booking_id' AND provider_id='{$_SESSION['id']}'";
    mysqli_query($con, $query);
    echo "<script>
                alert('You have accepted the booking');
                </script>";
    header('refresh:0.1; url=index.php');

    exit();
}
if (isset($_GET['reject_id'])) {
    $booking_id = $_GET['reject_id'];
    $feedback = mysqli_real_escape_string($con, $_GET['feedback']); // Change $_POST to $_GET and get the feedback value from URL parameters
    $query = "UPDATE bookings SET status='rejected', feedback='$feedback' WHERE id='$booking_id' AND provider_id='{$_SESSION['id']}'";
    mysqli_query($con, $query);
    echo "<script>
                alert('You have rejected the booking');
                </script>";
    header('refresh:0.1; url=index.php');
    exit();
}

if (isset($_GET['id'])) {
    $booking_id = $_GET['id'];
} else {
    $booking_id = '';
}

if (!empty($booking_id)) {
    $query = "SELECT * FROM bookings INNER JOIN users ON bookings.user_id = users.id WHERE bookings.id='$booking_id'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows == 0) {
        echo "No booking found with ID: $booking_id";
    }
} else {
    $row = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css" class="css">
    <title>Confirm Booking</title>
</head>

<body>
    <div class="sidebar">
        <a class="active" href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="../logout.php">Log Out</a>
    </div>
    <div class="content">
        <h2 style="text-align: center;">Confirm Booking</h2>
        <div class="form-container">
            <form action="confirm_bookings.php" method="GET">
                <input type="hidden" name="accept_id" value="<?php echo $booking_id; ?>">
                <button type="submit">Accept</button>
            </form>
            <br>
            <form action="confirm_bookings.php" method="GET"> <!-- Change method to GET -->
                <input type="hidden" name="reject_id" value="<?php echo $booking_id; ?>">
                <div class="form-group">
                    <label class="form-label" for="feedback">Reasons For Rejecting The Booking</label>
                    <textarea id="feedback" name="feedback" class="form-input" placeholder="Type here your reason for rejecting"></textarea>
                </div>
                <button type="submit">Reject</button>
            </form>

        </div>
        <?php
        if ($row === null) {
            echo "No booking found with ID: $booking_id";
        }
        ?>
        <?php if ($row !== null) : ?>
            <div class="table">
                <table id="users" class="table">
                    <tr>
                        <th>Booking ID</th>
                        <th>User Name</th>
                        <th>User Mail</th>
                        <th>Contact</th>
                        <th>City Where Services Will Be Offered</th>
                        <th>Booked Date</th>
                        <th>Queries</th>
                    </tr>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['contact']; ?></td>
                        <td><?php echo $row['adder']; ?></td>
                        <td><?php echo $row['date']; ?></td>
                        <td><?php echo $row['queries']; ?></td>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>