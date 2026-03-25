<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $user_name = $conn->real_escape_string($_POST['user_name']);
    $user_email = $conn->real_escape_string($_POST['user_email']);
    $user_password = $_POST['user_password'];

    // Hash the password using password_hash()
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Insert user into the database with the hashed password
    $sql = "INSERT INTO users (user_name, user_email, user_password) 
            VALUES ('$user_name', '$user_email', '$hashed_password')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to login page upon successful registration
        header("Location: login.php");
        exit(); // Ensure script execution stops after the redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" type="text/css" href="register.css">
    </head>

<body>

 <h2>SIGN UP </h2>
<!-- Sign up form -->
<form action="register.php" method="POST">
    Name: <input type="text" name="user_name" required><br><br>
    Email: <input type="email" name="user_email" required><br><br>
    Password: <input type="password" name="user_password" required><br><br>
    <input type="submit" value="Sign Up">

    <a href="login.php">Log in here !</a>

</form>

</body>
</html>