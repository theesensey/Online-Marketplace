<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!isset($_SESSION['email'])) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php');
    exit;
}

require_once '../config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css" class="css">
    <title>View Your Bookings</title>
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
        <h2 style="text-align: center;">Booked Providers</h2>
        <a href="index.php">Back to Home</a>

        <div class="table-container">
            <div class="table">
                <table id="providers" class="table">
                    <tr>
                        <th>Provider ID</th>
                        <th>Booked Provider</th>
                        <th>Provider Profession</th>
                        <th>User Who Booked</th>
                        <th>Contact</th>
                        <th>Address</th>
                        <th>Payment</th>
                        <th>Date</th>
                        <th>Queries</th>
                    </tr>
                    <?php
                    // retrieve the bookings with provider and user names

                    $sql = "SELECT bookings.id, providers.name AS provider_name, users.name AS user_name, providers.profession AS provider_prof, bookings.contact, bookings.adder, bookings.payment, bookings.date, bookings.queries
                            FROM bookings
                            JOIN providers ON bookings.provider_id = providers.id
                            JOIN users ON bookings.user_id = users.id";
                    $result = mysqli_query($con, $sql);

                    // display the bookings in a table
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['provider_name'] . "</td>";
                            echo "<td>" . $row['provider_prof'] . "</td>";
                            echo "<td>" . $row['user_name'] . "</td>";
                            echo "<td>" . $row['contact'] . "</td>";
                            echo "<td>" . $row['adder'] . "</td>";
                            echo "<td>" . $row['payment'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['queries'] . "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>

</html>