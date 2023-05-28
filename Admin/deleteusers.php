<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!isset($_SESSION['email'])) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php');
    exit();
}

require_once '../config.php';

// Check if user_id is set and is a valid number
if (isset($_GET['user_id']) && is_numeric($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    
    // Delete user from database
    $delete_user_query = "DELETE FROM users WHERE id = $user_id";
    $result = mysqli_query($con, $delete_user_query);
    
    // Check if query was successful
if($result){
    header("Location: deleteusers.php");
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
    <title>Delete Users</title>
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
            <table id="users" class="table">
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Contact</th>
                    <th>City</th>
                    <th>Address</th>
                    <th></th>
                </tr>
                <?php
                $sql = "SELECT * FROM users";
                $result = mysqli_query($con, $sql);

                if(mysqli_num_rows($result) > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo "<tr>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['usertype'] . "</td>";
                        echo "<td>" . $row['contact'] . "</td>";
                        echo "<td>" . $row['city'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>";
                        echo "<a href='?user_id=" . $row['id'] . "' onClick='return confirm(\"Are you sure you want to delete this user?\")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No providers found</td></tr>";
                }
                ?>
                </table>
                </div>
                
                </div>
                <?php
                // Check if success message exists in the URL
                if (isset($_GET['success'])) {
                    echo '<script>alert("User deleted successfully")</script>';
                }
                
                // Check if error message exists in the URL
                if (isset($_GET['error'])) {
                    echo '<script>alert("Error deleting user")</script>';
                }
                ?>
                </body>
                </html>