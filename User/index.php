<?php

//Creates a session or Resumes the current one based on a session identifier 
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to approriate page / method
    header('Location: ../login.php ');
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
     <link rel="shortcut icon" href="../marketplace.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user.css">
    <title>Home</title>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a class="active" href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="bookingview.php">Booking View</a>
        <a href="../logout.php">Log Out</a>

    </div>
    <div class="content">
        <h1>Welcome to Nairobi Marketplace</h1>
        <p>Please Select City and Profession to book a Service-Provider today.</p>
        <form method="GET" onsubmit="return validateForm()()">
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
    <br>
    <?php if (isset($result) && mysqli_num_rows($result) > 0) : ?>
        
            <div class="table">
                <table id="providers" class="table">
                    <tr>
                        <th>Id</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Address</th>
                        <th>City Where Services Are Offered</th>
                        <th>Profession</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                        <td><?php echo $row['id']; ?></td>
                            <td class="photo"><img src="../storage/<?= $row['photo'] ?>"></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['adder1'] ?></td>
                            <td><?= $row['city']?></td>
                            <td><?= $row['profession'] ?></td>
                            <td><?= $row['verification_status'] ?></td>
                            <td><a href='booking.php? provider=<?= $row["id"] ?>' onclick="return checkVerificationStatus('<?= $row["verification_status"] ?>')">Book</a></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            
        </div>
    <?php else : ?>
    <?php endif; ?>
</body>

</html>
<script>
    function checkVerificationStatus(verification_status) {
        if (verification_status !== 'verified') {
            alert('We will be unable to assist you if any issue arise with an unverified service provider. Do you still want to proceed with the booking?');
        }
        return true;
    }
</script>