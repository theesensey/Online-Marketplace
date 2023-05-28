<?php
//Creates a session or Resumes the current one based on a session identifier 
session_start();

//Checking if user is logged in
if (!isset($_SESSION['email'])) {
    //Redirects to appropriate page/method
    header('Location: ../login.php');
    exit();
}

require_once '../config.php';

//Fetching user data
$email = mysqli_real_escape_string($con, $_SESSION['email']);
$user_query = mysqli_query($con, "SELECT * FROM users WHERE email = '$email'");
$user = mysqli_fetch_assoc($user_query);

// Get unhashed password
$unhashed_password = '';
if (isset($user['password'])) {
    $unhashed_password = password_get_info($user['password'])['algo'] === 0 ? $user['password'] : '';
}

//Handling form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = isset($_POST['password']) && !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];
    $usertype = mysqli_real_escape_string($con, $_POST['usertype']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $address = mysqli_real_escape_string($con, $_POST['address']);

    // Update user data
    mysqli_query($con, "UPDATE users SET name='$name', username='$username', email='$email', password='$password', usertype='$usertype', contact='$contact', city='$city', address='$address' WHERE id={$user['id']}");

    // Redirect to profile page
    header('Location: profile.php');
    exit();
}

$cities = ["Karen", "Langata", "Ruaka", "Runda", "Westlands", "Parklands", "Kileleshwa", "Lavington"];
$provider = ["Plumber", "Electrician", "nanny", "cleaner"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <link rel="shortcut icon" href="../marketplace.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user.css">
    <title>Profile</title>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a class="active" href="profile.php">Profile</a>
        <a href="bookingview.php">Booking View</a>
        <a href="../logout.php">Log Out</a>
    </div>
    <div class="content">
        <h2>Profile</h2>
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label" for="name">Name</label>
                    <input value="<?= $user['name'] ?>" id="name" name="name" type="text" class="form-input" placeholder="Name">
                </div>

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input value="<?= $user['username'] ?>" id="username" name="username" type="text" class="form-input" placeholder="Username">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input value="<?= $user['email'] ?>" id="email" name="email" type="text" class="form-input" placeholder="Email">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label" for="usertype">User Type</label>
                    <select id="usertype" name="usertype" class="form-input">
                        <option value="User" <?php if ($user['usertype'] == 'User') echo 'selected'; ?>>User</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="contact">Contact</label>
                    <input value="<?= $user['contact'] ?>" id="contact" name="contact" type="text" class="form-input" placeholder="Contact">
                </div>
                <div class="form-group">
                    <label class="form-label" for="city">City</label>
                    <select id="city" name="city" class="form-input">
                        <?php foreach ($cities as $city) : ?>
                            <option value="<?= $city ?>" <?php if ($user['city'] == $city) echo 'selected'; ?>><?= $city ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="address">Address</label>
                    <input value="<?= $user['address'] ?>" id="address" name="address" type="text" class="form-input" placeholder="address">
                </div>
                <div class="form-control">
                    <button class="form-button" type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>