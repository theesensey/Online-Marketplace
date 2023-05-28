<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php ');
}

require_once '../config.php';

$cities = ["Karen", "Langata", "Ruaka", "Runda", "Westlands", "Parklands", "Kileleshwa", "Lavington"];
$provider = ["Plumber", "Electrician", "nanny", "cleaner"];

//Initialize variables for search criteria
$city = '';
$profession = '';

//Check if form was submitted and at least one select box is selected
if (isset($_GET['city']) || isset($_GET['profession'])) {
    //Check which select box was selected and set the appropriate search criteria
    if (!empty($_GET['city']) && $_GET['city'] !== 'none') {
        $city = "AND city = '" . $_GET['city'] . "'";
    }
    if (!empty($_GET['profession']) && $_GET['profession'] !== 'none') {
        $profession = "AND profession = '" . $_GET['profession'] . "'";
    }

    //Build SQL query based on search criteria
    $sql = "SELECT * FROM providers WHERE 1=1 $city $profession";

    //Execute SQL query
    $result = mysqli_query($con, $sql);

    //Check if any records are returned and output appropriate message
    if (mysqli_num_rows($result) == 0) {
        echo "<script>
        alert('No records available!');
        </script>";
    }
} else {
    //Build SQL query to retrieve all providers if no search criteria is selected
    $sql = "SELECT * FROM providers";

    //Execute SQL query
    $result = mysqli_query($con, $sql);

    //Check if any records are returned and output appropriate message
    if (mysqli_num_rows($result) == 0) {
        echo "<script>
        alert('No records available!');
        </script>";
    }
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
        <p>Reports Based on Service Providers </p><a href="reports.php">Back to Reports</a><br>
        <form method="GET">
            <div class="search-box">
                <label for="">City</label>
                <select name="city" id="city">
                    <option value="none">-- Select City --</option>
                    <?php foreach ($cities as $city) : ?>
                        <option value="<?= $city ?>"> <?= $city ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="">Who's Required</label>
                <select name="profession" id="profession">
                    <option value="none">-- Select Profession --</option>
                    <?php foreach ($provider as $profession) : ?>
                        <option value="<?= $profession ?>"> <?= $profession ?>
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