<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Delete the user profile from the database
    $sql = "DELETE FROM users WHERE user_id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        // Unset all session variables and destroy session
        session_unset();
        session_destroy();
        echo "Profile deleted successfully!";
        header("Location: register.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <title>Delete Profile</title>
</head>
<body>
<h2>Delete Profile</h2>

<p>Are you sure you want to delete your profile? This action cannot be undone.</p>

<form action="profile_delete.php" method="POST">
    <input type="submit" value="Yes, Delete My Profile">
</form>

<a href="profile.php">Back to Profile</a>

</body>
</html>
