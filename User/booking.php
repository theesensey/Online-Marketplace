<?php

//Creates a session or Resumes the current one based on a session identifier 
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to approriate page / method
    header('Location: ../login.php ');
}
$user_id = $_SESSION['id'];

require_once '../config.php';

// Check if provider id is set
if (!isset($_GET['provider'])) {
    echo "<script>alert('You are yet to book!');</script>";
    header('refresh:0.1; url=index.php');
    exit();
}
// Get provider id from the URL
$provider_id = $_GET['provider'];


// Prepare SQL query
$sql = "SELECT * FROM providers WHERE id=$provider_id";
// Perform Query against the database
$result = mysqli_query($con, $sql);
// Check if query was successful and if provider was found
if ($result === false || mysqli_num_rows($result) == 0) {
    header('Location: index.php');
    exit();
}

// Get provider details
$row = mysqli_fetch_assoc($result);

$name = $row['name'];
$profession = $row['profession'];
$photo = $row['photo'];
$address = $row['adder1'];
$address2 = $row['adder2'];
$city = $row['city'];



if (isset($_POST['book'])) {

    $user_id = $_SESSION['id'];
    $provider_id = $_GET['provider'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $contact = $_POST['contact'];
    $adder = $_POST['adder'];
    //Changing the date into Y-m-d
    $date = date('Y-m-d', strtotime($_POST['date']));
    $queries = $_POST['queries'];
    $payment = $_POST['payment'];

    // Check if user has already booked the provider on the day they are choosing
    $sql = "SELECT * FROM bookings WHERE provider_id = $provider_id AND user_id = $user_id AND date = '$date'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('You have already booked this provider on this date! Please choose another provider or a different date.');</script>";
        header('refresh:0.1; url=index.php');
        exit();
    }

    // Insert data into MySQL database using prepared statement
    $stmt = mysqli_prepare($con, "INSERT INTO bookings (provider_id, user_id, fname, lname, contact, adder, date, queries, payment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssssss", $provider_id, $user_id, $fname, $lname, $contact, $adder, $date, $queries, $payment);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // query was successful
        header("refresh:0.5; url=bookingview.php");
        echo "<script>alert('Booked Successfully!: We will Contact you soon!');</script>";
    } else {
        // query failed
        echo "Error: " . mysqli_error($con);
    }
}


// Perform the query against the database
$usersdata = mysqli_query($con, "SELECT name, email, contact, city, address FROM users WHERE id=$user_id");

if (mysqli_num_rows($usersdata) == 0) {
    header('Location: index.php');
    exit();
}

$user = mysqli_fetch_assoc($usersdata);


// Separate full name into first and last names
$username = $user['name'];
$name_parts = explode(' ', $username);
$ufirstname = $name_parts[0];
$ulastname = $name_parts[1];
$email = $user['email'];
$contact = $user['contact'];
$city = $user['city'];
$uaddress = $user['address'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="user.css" class="css">
    <title>Bookings</title>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a href="profile.php">Profile</a>
        <a href="bookingview.php">Booking View</a>
        <a href="../logout.php">Log Out</a>
    </div>
    <div class="content">
        <table class="table">
            <tr>
                <th>Name</th>
                <td><?= $name ?></td>
                <th>Profession</th>
                <td><?= $profession; ?></td>
            </tr>
            <tr>
                <th>Address</th>
                <td><?= $address ?><?= $address2 ?></td>
                <th>City</th>
                <td><?= $city ?></td>
            </tr>
        </table>
        <br>
        <h2 style="text-align: center; color: #04AA6D; border:1px solid black; padding: 4px;">Book <?= $name ?> Today</h2>
        <div class="form-container">
            <form method="post" onsubmit="return validate();">
                <div class="form-group">
                    <label class="form-label" for="fname">First Name</label>
                    <input id="fname" name="fname" type="text" placeholder="User First Name" class="form-input" value="<?php echo $ufirstname; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label" for="lname">Last Name</label>
                    <input id="lname" name="lname" type="text" placeholder="User Last Name" class="form-input" value="<?php echo $ulastname; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label" for="contact">Mobile Number</label>
                    <input id="contact" name="contact" type="text" placeholder="User Number" class="form-input" value="<?php echo $contact; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label" for="adder">Address</label>
                    <input id="adder" name="adder" type="text" placeholder="User address" class="form-input" value="<?php echo $uaddress; ?>">
                </div>
                <div class="form-group">
                    <label class="form-label" for="date">Date</label>
                    <input id="date" name="date" type="text" placeholder="dd-mm-yyyy" class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label" for="payment">Payment Method</label>
                    <select id="payment" name="payment" class="form-input">
                        <option value="">Choose payment method</option>
                        <option value="cash">Cash</option>
                        <option value="credit card">Credit Card</option>
                        <option value="paypal">Paypal</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label" for="queries">Problems??</label>
                    <textarea id="queries" name="queries" placeholder="Users Problems and services they want" class="form-input" rows="5"></textarea>
                </div>
                <div class="form-control">
                    <button class="form-button" type="submit" name="book" id="book">Book Now</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function validate() {
            var fname = document.getElementById("fname").value;
            var lname = document.getElementById("lname").value;
            var contact = document.getElementById("contact").value;
            var adder = document.getElementById("adder").value;
            var date = document.getElementById("date").value;
            var payment = document.getElementById("payment").value;
            var queries = document.getElementById("queries").value;

            if (fname == "" || lname == "" || contact == "" || adder == "" || date == "" || payment == "" || queries == "") {
                alert("All fields must be filled out");
                return false;
            }
            //Whether it is of the format dd-mm-yyyy and also if it is empty( Implied)
            //indexOf() method is used to search the specified element in the given array
            //return -1 if element is not found
            if (date.indexOf("-") == -1) {
                alert("Date must be entered and of the format (dd-mm-yyyy)");
                document.getElementById("date").focus();
                return false;
            }
            //The split() method divides a String into an ordered list of substrings, puts these substrings into an array, and returns the array
            comps = date.split("-");
            //Ensuring the date components are of correct length
            //[] get the index position of a character in a set
            //counting starts from 0
            if (comps[0].length < 1 || comps[1].length < 1 || comps[2].length < 4) {
                alert("Date must be of the format (dd-mm-yyyy)");
                document.getElementById("date").focus();
                return false;
            }
            //to check date are numbers we use global JavaScript function isNaN()

            if (isNaN(comps[0]) || isNaN(comps[1]) || isNaN(comps[2])) {
                alert("Date components must be integers and must be of the format (dd-mm-yyyy)");
                document.getElementById("date").focus();
                return false;
            }
            //Date cannot be Earlier than today
            //new Date() creates a new date object with the current date and time:
            var currentdate = new Date(); //Todays Date
            //Creating a date using the entered data
            var specifieddate = new Date(comps[2], comps[1] - 1, comps[0]); //The function setFullYear Set the year(optionally also month and day yyyy,mm,dd)

            //Comparing the dates
            if (specifieddate < currentdate) {
                alert("The date cannot be Earlier than today's date.");
                return false; // return false is used to prevent the submission of the form if the entry of the form is unfilled i.e the date is unfiled.
            }
            if (isNaN(contact) || contact.length != 10) {
                alert("Invalid Contact Number");
                return false;
            }
            return true;
        }
    </script>

</body>

</html>