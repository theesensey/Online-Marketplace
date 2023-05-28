<?php
// Start a new session
session_start();

// Include the configuration file
require 'config.php';

// An array of cities
$cities = ["Karen", "Langata", "Ruaka", "Runda", "Westlands", "Parklands", "Kileleshwa", "Lavington"];
$provider = ["Plumber", "Electrician", "Nanny", "Cleaner"];

function upload($file, $allowed = ['png', 'jpg', 'jpeg', 'gif'])
{
    // Explode the file name by "." to get the extension
    $a = explode('.', $file['name']) ?: '';
    $ext = end($a);

    // Check if the extension is allowed
    if (array_search($ext, $allowed) === false) {
        return false;
    }

    // Generate a unique name for the file
    $dest = uniqid() . '.' . $ext;

    // Move the file to the storage folder
    if (move_uploaded_file($file['tmp_name'], '/Applications/XAMPP/xamppfiles/htdocs/onlinemarketplace/storage/' . $dest)) {
        echo "File uploaded successfully!";
        return $dest;
    } else {
        echo "Error uploading file: " . $file['error'];
    }

    return false;
}

// If the HTTP method is POST, process the form data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $descr = $_POST['descr'];
    $adder1 = $_POST['adder1'];
    $adder2 = $_POST['adder2'];
    $city = $_POST['city'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $profession = $_POST['profession'];

    // Hash the password
    $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Get the uploaded file
    $photo = $_FILES['photo'];

    // Check for required fields
    if (empty($name) || empty($contact) || empty($descr) || empty($adder1) || empty($city) || empty($username) || empty($password) || empty($email) || empty($profession)) {
        // If a required field is empty, display an error message and exit the script
        die("All fields are required.");
    }

    // Check if a photo has been uploaded
    if (!isset($_FILES['photo'])) {
        // If no photo has been uploaded, display an error message and exit the script
        die("Photo is required.");
    }

    // Check for file upload errors
    $photo = $_FILES['photo'];
    if ($photo['error'] !== UPLOAD_ERR_OK) {
        // If there is a file upload error, display an error message and exit the script
        die("File upload failed with error code " . $photo['error']);
    }

    // Upload the file and get the file name
    $file1 = upload($photo);
    if ($file1 === false) {
        // If the file upload fails, display an error message and exit the script
        die("File upload failed.");
    }

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // If the email format is invalid, display an error message and exit the script
        die("Invalid email format.");
    }

    // insert the data into the providers table using prepared statements
    $stmt = mysqli_prepare($con, "INSERT INTO providers (name, contact, descr, adder1, adder2, city, username, password, photo, email, profession) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssssssss", $name, $contact, $descr, $adder1, $adder2, $city, $username, $hashed_password, $file1, $email, $profession);
    $result = mysqli_stmt_execute($stmt);

    // check if the query was successful
    if ($result) {
        // redirect to the login page after 1 second
        header("refresh:1; url=login.php");
        echo "<script>
        alert('Account Created Successfully!');
        </script>";
        exit();
    } else {
        echo "<script>
        alert('Account Not Created Successfully!');
        </script>";
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="marketplace.ico"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <script src="script.js"></script>
    <title>Service-Provider Registration</title>
</head>
<style>
    textarea {
        width: 390px;
        height: 100px;
    }
</style>

<body>
    <h3>Service-Provider Registration</h3><br>
    <p>Register today to Nairobi Marketplace</p>
    <form name="myForm" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </div>
        <br>
        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="text" id="contact" name="contact">
        </div>
        <br>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <br>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <br>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <br>
        <div class="form-group">
            <label for="descr">Description About You</label>
            <textarea id="descr" name="descr" cols="30"></textarea>
        </div>
        <br>
        <div class="form-group">
            <label for="photo">Photo:</label>
            <input type="file" name="photo" id="photo" required>
        </div>
        <br>
        <div class="form-group">
            <label for="adder1">Address Line 1</label>
            <input type="text" id="adder1" name="adder1">
        </div>
        <br>
        <div class="form-group">
            <label for="adder2">Address Line 2</label>
            <input type="text" id="adder2" name="adder2">
        </div>
        <br>
        <div class="form-group">
        <label for="city" title="City where services will be offered">City</label>
            <select name="city" id="city">
                <option value="none">-- Select City --</option>
                <?php foreach ($cities as $city) : ?>
                    <option value="<?= $city ?>"> <?= $city ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label for="profession">Profession</label>
            <select name="profession" id="profession">
                <option value="none">-- Select Profession --</option>
                <?php foreach ($provider as $profession) : ?>
                    <option value="<?= $profession ?>"> <?= $profession ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <br>
        <button type="submit" name="submit" value="Create Account">Sign Up</button>

        <div class="panel-footer">Already have an account ?<a href="login.php"> Log In</a></div>
        <div class="panel-footer">Are you a Customer?<a href="signup.php"> User Register</a></div>
        <div class="panel-footer">Go back to home <a href="index.php">Home</a></div>
    </form>

    <script>
        function validateForm() {
            // Get values of all form fields
            var name = document.forms["myForm"]["name"].value;
            var contact = document.forms["myForm"]["contact"].value;
            var descr = document.forms["myForm"]["descr"].value;
            var adder1 = document.forms["myForm"]["adder1"].value;
            var adder2 = document.forms["myForm"]["adder2"].value;
            var city = document.forms["myForm"]["city"].value;
            var password = document.forms["myForm"]["password"].value;
            var profession = document.forms["myForm"]["profession"].value;

            // Check if required fields are not empty
            if (name == "" || contact == "" || descr == "" || password == "") {
                alert("Please fill in all required fields.");
                return false;
            }

            // Check if contact is a valid phone number
            var phoneno = /^\d{10}$/;
            if (!contact.match(phoneno)) {
                alert("Please enter a valid phone number.");
                return false;
            }

            // Check if password is at least 8 characters long and contains at least one uppercase letter, one lowercase letter, and one number
            var passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
            if (!password.match(passwordRegex)) {
                alert("Please enter a password that is at least 8 characters long and contains at least one uppercase letter, one lowercase letter, and one number.");
                return false;
            }


            // Return true if all conditions are met
            return true;
        }
    </script>
</body>

</html>