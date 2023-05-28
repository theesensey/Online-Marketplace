<?php
//Creates a session or resumes the current one based on a session identifier
session_start();

//Checking if user is logged in
if (!$_SESSION['email']) {
    //Redirects to appropriate page/method
    header('Location: ../loginadmin.php ');
}

require_once '../config.php';
//Query to get all new provider registrations
$query = "SELECT * FROM providers WHERE verification_status = 'unverified'";
$result = mysqli_query($con, $query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="../marketplace.ico"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../user/user.css" class="css">

    <title>Verification</title>
</head>

<body>
    <!-- The sidebar -->
    <div class="sidebar">
        <a href="index.php">Home</a>
        <a class="active" href="verify.php">Verification</a>
        <a href="reports.php">Reports</a>
        <a href="deleteupdate.php">Delete and Update</a>
        <a href="../index.php">Log Out</a>
    </div>
    <div class="content">
        <h2>Verifiy Providers</h2>
        <form action="update_verification.php" method="post" onsubmit="return validateForm()">
            <?php
            // Query the database for all unverified providers
            $sql = "SELECT * FROM providers WHERE verification_status = 'unverified'";
            $result = mysqli_query($con, $sql);
            // Check if any unverified providers were found
            if (mysqli_num_rows($result) > 0) {
                
            } else {
                // If no unverified providers were found, display a message
                echo '<p>No unverified providers found.</p>';
            }        ?>
            <div class="table">
                <table id="providers" class="table">
                    <tr>
                        <th>ID</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profession</th>
                        <th>Contact</th>
                        <th>City</th>
                        <th>Verification Status</th>
                        <th>Select Users to Verify</th>
                    </tr>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td class="photo"><img src="../storage/<?= $row['photo'] ?>"></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['profession']; ?></td>
                            <td><?php echo $row['contact']; ?></td>
                            <td><?php echo $row['city']; ?></td>
                            <td><?php echo $row['verification_status']; ?></td>
                            <td><?php echo '<input type="checkbox" name="provider_ids[]" value="' . $row['id'] . '">'; ?></td>
                        </tr>
                    <?php } ?>
                    <input type="submit" value="Verify Selected Providers"><br><br>
                    <a href="index.php">Back to Home</a>
                </table>
            </div>

        </form>
</body>
<script>
    function validateForm() {
        var table = document.getElementById("providers");
        var checkboxes = table.getElementsByTagName("input");
        var checked = false;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].type == "checkbox" && checkboxes[i].checked) {
                checked = true;
                break;
            }
        }
        if (!checked) {
            alert("Please select at least one provider for verification.");
            return false;
        }
    }
</script>
</div>
</body>

</html>