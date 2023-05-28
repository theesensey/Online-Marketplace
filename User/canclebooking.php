<?php
session_start();

if (!isset($_SESSION['email'])) { // added isset function
    header('Location: ../loginadmin.php');
    exit; // added exit after header
}

require_once '../config.php';

if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) { // changed parameter name to delete_id
    $booking_id = $_GET['delete_id']; // changed variable name to booking_id

    // Delete booking from database
    $delete_booking_query = "DELETE FROM bookings WHERE id = $booking_id";
    $result = mysqli_query($con, $delete_booking_query);

    // Check if query was successful
    if ($result) {
        header("Location: deletebookings.php");
        exit; // added exit after header
    } else {
        echo "Error deleting record: " . mysqli_error($con);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Providers</title>
    <link rel="stylesheet" href="../user/user.css" class="css">
     <link rel="shortcut icon" href="../marketplace.ico">
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
    <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="bookingview.php">Booking View</a>
        <a class="active" href="cancelbooking.php">Cancel Booking</a>
        <a href="../logout.php">Log Out</a>
    </div>
    <div class="content">
        <div class="table">
            <table id="providers" class="table">
                <tr>
                    <th>Provider Id Booked</th>
                    <th>User Id Booked</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Date Booked</th>
                    <th>Payment</th>
                    <th>Problems</th>
                </tr>
                <?php
                $sql = "SELECT * FROM bookings";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['provider_id'] . "</td>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['fname'] . "</td>";
                        echo "<td>" . $row['lname'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo "<td>" . $row['adder'] . "</td>";
                        echo "<td>" . $row['date'] . "</td>";
                        echo "<td>" . $row['payment'] . "</td>";
                        echo "<td>" . $row['problems'] . "</td>";
                        echo "<td>";
                        echo "<a href='?delete_id=" . $row['id'] . "' onClick='return confirm(\"Are you sure you want to Cancel this booking?\")'>Cancel</a>"; // changed the text and message of confirmation box
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No bookings found</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>
</body>

</html>