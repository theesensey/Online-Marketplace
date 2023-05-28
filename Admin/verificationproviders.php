<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php ');
}

require_once '../config.php';

$verification = ["verified", "unverified"];

if(isset($_GET['verification']) && $_GET['verification'] != "none") {
    $verification_status = $_GET['verification'];
    $sql = "SELECT * FROM providers WHERE verification_status = '$verification_status'";
    $result = mysqli_query($con, $sql);
}
else {
    $sql = "SELECT * FROM providers";
    $result = mysqli_query($con, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <p>Reports Based on Service Providers </p><a href="reports.php">Back to Reports</a><br>
        <form method="GET">
            <div class="search-box">
                <label for="">Verification Status</label>
                <select name="verification" id="verification">
                    <option value="none">-- Select Status --</option>
                    <?php foreach ($verification as $verification_status) : ?>
                        <option value="<?= $verification_status ?>"> <?= $verification_status ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="search">
                    <label for="">Action</label>
                    <button type="submit" id="search">Search</button>
                </div>
        </form>
    </div>
    <!-- Display the data in a table format -->
    <?php if (!empty($result)) : ?>
        <div class="table">
            <table id="providers" class="table">
                <tr>
                    <th>Id</th>
                    <th>Photo</th>
                    <th>Service Provider Name</th>
                    <th>Email Address</th>
                    <th>Phone Number</th>
                    <th>Username</th>
                    <th>Description</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Profession</th>
                    <th>Verification Status</th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $row) : ?>
                        <tr>
                        <td><?php echo $row['id']; ?></td>
                            <td class="photo"><img src="../storage/<?= $row['photo'] ?>"></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td><?= $row['contact'] ?></td>
                            <td><?= $row['username'] ?></td>
                            <td><?= $row['descr'] ?></td>
                            <td><?= $row['adder1'] ?>/<?= $row['adder2'] ?></td>
                            <td><?= $row['city'] ?></td>
                            <td><?= $row['profession'] ?></td>
                            <td><?= $row['verification_status'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No data available</p>
        <?php endif; ?>
</body>

</html>