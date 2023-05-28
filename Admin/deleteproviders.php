<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php ');
}

require_once '../config.php';

if(isset($_GET['delete_id'])){
    $id = $_GET['delete_id'];

    // delete related rows first
    $sql = "DELETE FROM providers_verification WHERE provider_id = $id";
    $result = mysqli_query($con, $sql);

    // then delete the row from the providers table
    $sql = "DELETE FROM providers WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if($result){
        header("Location: deleteproviders.php");
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
     <link rel="shortcut icon" href="../marketplace.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Providers</title>
    <link rel="stylesheet" href="../user/user.css" class="css">
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a href="verify.php">Verification</a>
        <a href="reports.php">Reports</a>
        <a class="active" href="deleteupdate.php">Delete and Update</a>
        <a href="../index.php">Log Out</a>
    </div>
    <div class="content">
    <div class="table">
            <table id="providers" class="table">
                <tr>
                <th>Service Provider Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Username</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Profession</th>
                    <th>Verification Status</th>
                    <th>Action</th>
                </tr>
                <?php
            $sql = "SELECT * FROM providers";
            $result = mysqli_query($con, $sql);

            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    echo "<tr>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td>" . $row['contact'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['descr'] . "</td>";
                    echo "<td>" . $row['adder1'] . "</td>";
                    echo "<td>" . $row['city'] . "</td>";
                    echo "<td>" . $row['profession'] . "</td>";
                    echo "<td>" . $row['verification_status'] . "</td>";
                    echo "<td>";
                    echo "<a href='?delete_id=" . $row['id'] . "' onClick='return confirm(\"Are you sure you want to delete this provider?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No providers found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>