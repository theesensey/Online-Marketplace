<?php
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page / method
    header('Location: ../login.php');
}

require_once '../config.php';

$user_id = $_SESSION['id'];

if(isset($_GET['provider'])) {
    $provider_id = $_GET['provider'];
    
    // Prepare a delete statement for the selected provider
    $query = "DELETE FROM bookings WHERE user_id = '$user_id' AND provider_id = '$provider_id'";
    
    // Execute the delete statement
    if(mysqli_query($con, $query)) {
        // If the delete statement was successful, redirect the user to the bookingview page
        echo "<script>alert('Delete Successful);</script>";
        header("Location: bookingview.php");
        exit;
    } else {
        // If there was an error with the delete statement, display an error message
        echo "<script>alert('Book not deleted');</script>";
    }
} else {
    // If the provider parameter is not set, redirect the user to the bookingview page
    header("Location: bookingview.php");
    exit;
}
?>
