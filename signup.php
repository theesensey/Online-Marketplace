<?php
//Creates a session or Resumes the current one based on a session identifier 
require 'config.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $usertype = $_POST['usertype'];
    $contact = $_POST['contact'];
    $city = $_POST['city'];
    $address = $_POST['address'];
    
    // Validate inputs
    if (empty($name) || empty($username) || empty($email) || empty($password) || empty($usertype) || empty($contact) || empty($city) || empty($address)) {
        die("Please fill in all the fields.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    // Insert data into MySQL database using prepared statement
    $stmt = mysqli_prepare($con, "INSERT INTO users (name, username, email, password, usertype, contact, city, address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssssss", $name, $username, $email, $password, $usertype, $contact, $city, $address);
    $result = mysqli_stmt_execute($stmt);
    if ($result) {
        // query was successful
        header("refresh:1; url=login.php");
        echo "<script>
        alert('Account Created Successfully!');
        </script>";
    } else {
        // query failed
        echo "Error: " . mysqli_error($con);
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
    <title>User Sign Up</title>
</head>

<body>
    <h3>User Registration</h3><br>
    <p>Register today to Nairobi Marketplace</p>
    <form name="myForm" onsubmit="return validateForm()" method="POST">
        <div class="field">
            <label for="name">Name</label>
            <input type="text" id="name" name="name">
        </div>
        <br>
        <div class="field">
            <label for="username">Username</label>
            <input type="text" id="username" name="username">
        </div>
        <br>
        <div class="field">
            <label for="email">Email</label>
            <input type="email" id="email" name="email">
        </div>
        <br>
        <div class="field">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
        </div>
        <br>
        <div class="field">
            <label for="usertype">User Type</label>
            <select id="usertype" name="usertype">
                <option value="">Select user type</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
        </div>
        <br>
        <div class="field">
            <label for="contact">Contact Number</label>
            <input type="text" id="contact" name="contact">
        </div>
        <br>
        <div class="field">
            <label for="city">Current City</label>
            <input type="text" id="city" name="city">
        </div>
        <br>
        <div class="field">
            <label for="address">Address</label>
            <input type="text" id="address" name="address">
        </div>
        <br>
        <button type="submit" name="submit" value="Create Account">Sign Up</button>

        <div class="panel-footer">Already have an account ?<a href="login.php"> Log In</a></div>
        <div class="panel-footer">Want to work with us today ?<a href="register.php"> Service-Provider Register</a></div>
        <div class="panel-footer">Go back to home <a href="index.php">Home</a></div>
    </form>
    <script>
        function validateForm() {
            // get input fields
            const name = document.forms["myForm"]["name"].value;
            const username = document.forms["myForm"]["username"].value;
            const email = document.forms["myForm"]["email"].value;
            const password = document.forms["myForm"]["password"].value;
            const contact = document.forms["myForm"]["contact"].value;

            // check if fields are empty
            if (name == "" || username == "" || email == "" || password == "" || contact == "") {
                alert("Please fill in all the fields.");
                return false;
            }

            // check if contact is numeric
            if (isNaN(contact)) {
                alert("Contact number must be a number.");
                return false;
            }

            // check if email is valid format
            const emailRegex = /\S+@\S+\.\S+/;
            if (!emailRegex.test(email)) {
                alert("Invalid email format.");
                return false;
            }

            // check if password is strong
            const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
            if (!passwordRegex.test(password)) {
                alert(
                    "Password must be at least 8 characters long and contain at least one number, one lowercase letter, and one uppercase letter.");
                return false;
            }
        }
    </script>
</body>

</html>