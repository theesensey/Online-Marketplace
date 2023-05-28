<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php ');
}

require_once '../config.php';

$query = "SELECT * FROM users";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($con)); // Print the error message if there is any query error
}

if (mysqli_num_rows($result) == 0) {
    echo "No users found."; // Print the message if the result set is empty
} else {
    // Display the data in a table format
}
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
        <p>Users In The System</p><a href="reports.php">Back to Reports</a><br>
        <!-- Display the data in a table format -->
        <?php if (!empty($result)) : ?>
            <div class="table">
                <table id="providers" class="table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Contact</th>
                            <th>City</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($result as $row) : ?>
                            <tr>
                            <td><?php echo $row['id']; ?></td>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['usertype'] ?></td>
                                <td><?= $row['contact'] ?></td>
                                <td><?= $row['city'] ?></td>
                                <td><?= $row['address'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <p>No data available</p>
        <?php endif; ?>
        </div>
</body>

</html>

