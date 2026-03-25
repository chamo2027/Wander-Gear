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
    // Sanitize and get the new values from the form
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $user_email = $conn->real_escape_string($_POST['user_email']);
    $user_password = $_POST['user_password'];

    if (!empty($user_password)) {
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET user_name='$user_name', user_email='$user_email', user_password='$hashed_password' WHERE user_id='$user_id'";
    } else {
        $sql = "UPDATE users SET user_name='$user_name', user_email='$user_email' WHERE user_id='$user_id'";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Profile updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch user details for the form
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="profile.css">
    <title>Update Profile</title>
</head>
<body>
<h2>Update Profile</h2>

<form action="profile_up.php" method="POST">
    Name: <input type="text" name="user_name" value="<?php echo $row['user_name']; ?>" required><br><br>
    Email: <input type="email" name="user_email" value="<?php echo $row['user_email']; ?>" required><br><br>
    Password: <input type="password" name="user_password" placeholder="Enter new password (optional)"><br><br>
    <input type="submit" value="Update Profile">
</form>

<a href="profile.php">Back to Profile</a>

</body>
</html>
