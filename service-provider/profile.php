<?php
// Start session or resume current session
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['email'])) {
    header('Location: ../login.php');
    exit();
}

require_once '../config.php';

// Fetch provider data
$email = mysqli_real_escape_string($con, $_SESSION['email']);
$provider_query = mysqli_query($con, "SELECT * FROM providers WHERE email = '$email'");
$provider = mysqli_fetch_assoc($provider_query);

// Handling form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = isset($_POST['password']) && !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $provider['password'];
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $address = mysqli_real_escape_string($con, $_POST['adder1']);
    $profession = mysqli_real_escape_string($con, $_POST['profession']);
    $description = mysqli_real_escape_string($con, $_POST['descr']);

    mysqli_query($con, "UPDATE providers SET name='$name', username='$username', email='$email', password='$password', contact='$contact', city='$city', adder1='$address', descr='$description' WHERE id={$provider['id']}");

    // Redirect to profile page
    header('Location: profile.php');
    // query was successful
    header("refresh:2; url=profile.php");
    echo "<script>
    alert('Updated Successfully!:');
    </script>";
    exit();
}

$cities = ["Karen", "Langata", "Ruaka", "Runda", "Westlands", "Parklands", "Kileleshwa", "Lavington"];
$profession = ["Plumber", "Electrician", "nanny", "cleaner"];
?>
<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css">
    <title>Document</title>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a class="active" href="profile.php">Profile</a>
        <a href="../logout.php">Log Out</a>
    </div>
    <div class="content">
        <h2>Profile</h2>
        <div class="form-container">
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label" for="name">Name</label>
                    <input value="<?= $provider['name'] ?>" id="name" name="name" type="text" class="form-input" placeholder="Name">
                </div>

                <div class="form-group">
                    <label class="form-label" for="username">Username</label>
                    <input value="<?= $provider['username'] ?>" id="username" name="username" type="text" class="form-input" placeholder="Username">
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input value="<?= $provider['email'] ?>" id="email" name="email" type="text" class="form-input" placeholder="Email">
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label" for="profession">Profession</label>
                    <select id="profession" name="profession" class="form-input">
                        <?php foreach ($profession as $profession) : ?>
                            <option value="<?= $profession ?>" <?php if ($provider['profession'] == $profession) echo 'selected'; ?>><?= $profession ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="contact">Contact</label>
                    <input value="<?= $provider['contact'] ?>" id="contact" name="contact" type="text" class="form-input" placeholder="Contact">
                </div>
                <div class="form-group">
                    <label class="form-label" for="city">City</label>
                    <select id="city" name="city" class="form-input">
                        <?php foreach ($cities as $city) : ?>
                            <option value="<?= $city ?>" <?php if ($provider['city'] == $city) echo 'selected'; ?>><?= $city ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="address">Address</label>
                    <input value="<?= $provider['adder1'] ?>" id="address" name="adder1" type="text" class="form-input" placeholder="address">
                </div>
                <div class="form-group">
                    <label class="form-label" for="description">Description</label>
                    <textarea id="description" name="descr" class="form-input" placeholder="Description"><?= $provider['descr'] ?></textarea>
                </div>

                <div class="form-control">
                    <button class="form-button" type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>