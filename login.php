<?php
// Creates a session or resumes the current one based on a session identifier 
session_start();
require 'config.php';

// Check if Login is set
if (isset($_POST['login'])) {
    // Validate the email address format
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    if (!$email) {
        echo "<script>
        alert('Invalid email format!');
        </script>";
        exit;
    }

    // Ignore input that is not string to prevent SQL injection
    $email = mysqli_real_escape_string($con, $email);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Check if the user is a provider
    $provider_query = "SELECT * FROM providers WHERE email='$email'";
    $provider_run = mysqli_query($con, $provider_query) or die(mysqli_connect_error());

    if (mysqli_num_rows($provider_run) > 0) {
        // The user is a provider
        $provider_row = mysqli_fetch_array($provider_run);
        $provider_id = $provider_row['id'];

        // Verify the password
        if (password_verify($password, $provider_row['password'])) {
            // Password is correct
            // Redirect the user to the appropriate landing page
            $_SESSION["email"] = $email;
            $_SESSION['id'] = $provider_id;
            header("location: service-provider/index.php");
            exit;
        } else {
            // Show an error message if the email or password is incorrect
            echo "<script>
                alert('Invalid email or password!');
                </script>";
            header('refresh:0.1; url=login.php');
        }
    }

    // Get the user from the database
    $user_query = "SELECT * FROM users WHERE email='$email'";
    $user_run = mysqli_query($con, $user_query) or die(mysqli_connect_error());

    if (mysqli_num_rows($user_run) > 0) {
        // The user exists in the database
        $user_row = mysqli_fetch_array($user_run);
        $user_id = $user_row['id'];

        // Verify the password
        if (password_verify($password, $user_row['password'])) {
            // Password is correct

            // Check if the user is an admin
            if ($user_row['usertype'] === 'User') {
                // User is an admin

                // Redirect the user to the admin landing page
                $_SESSION["email"] = $email;
                $_SESSION['id'] = $user_id;
                header("location: User/index.php");
            } else {
                // User is an Admin
                echo "<script>
                alert('Log in at the Admin Page!');
                </script>";
            }
        } else {
            // Show an error message if the email or password is incorrect
            echo "<script>
            alert('Invalid email or password!');
            </script>";
        }
    } else {
        // The user does not exist in the database
        echo "<script>
        alert('User with email $email does not exist!');
        </script>";
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
    <link rel="stylesheet" href="css/login.css">
    <title>User Log In</title>
    <style>
        body {
            background-color: #939393;
        }
    </style>
</head>

<body>
    <h3>LOGIN</h3>
    <br>
    <p>Login to view Marketplace.</p>
    <form method="post">
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email">
        </div><br>
        <div class="form-group">
            <input type="password" class="form-control" name="password" placeholder="Password(min. 6 characters)">
        </div><br>
        <div class="form-group">
            <input type="submit" name="login" value="Login" class="btn btn-primary">
        </div><br>
    </form>
    <div class="panel-footer">Don't have an account yet? <a href="signup.php">User Register</a>&nbsp&nbsp<a href="register.php">Service-Provider Register</a>
        &nbsp<br><br><a href="#">Forgot Password</a></div>
    </div>
    <div class="panel-footer">Go back to home <a href="index.php">Home</a></div>

</body>

</html>