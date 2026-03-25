<?php
session_start();
include 'db_connect.php';

// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch the logged-in user's details from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['user_name'];
    $user_email = $row['user_email'];
} else {
    echo "User not found!";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <title>Profile Page</title>
</head>
<body>
<h2>Welcome, <?php echo $user_name; ?></h2>

<!-- Display user details -->
<p>Name: <?php echo $user_name; ?></p>
<p>Email: <?php echo $user_email; ?></p>

<!-- Links to update, delete profile, and log out -->
<a href="profile_up.php">Update Profile</a> | 
<a href="profile_delete.php">Delete Profile</a> | 
<a href="logout.php">Log Out</a>

</body>
</html>
