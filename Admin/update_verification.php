<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginprovider.php ');
}

require_once '../config.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected provider IDs from the form
    $provider_ids = $_POST['provider_ids'];

    // Loop through the selected provider IDs and update their verification status to 'verified'
    foreach ($provider_ids as $provider_id) {
        $query = "UPDATE providers SET verification_status = 'verified' WHERE id = $provider_id";
        mysqli_query($con, $query);
    }

    // Redirect to the verification page
    header("refresh:0.5; url=verify.php");
    echo "<script>
    alert('Verification Successfull!');
    </script>";
}
?>
