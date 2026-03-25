<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize email and password inputs
    $user_email = $conn->real_escape_string($_POST['user_email']);
    $user_password = $_POST['user_password'];

    // Fetch user details by email
    $sql = "SELECT * FROM users WHERE user_email = '$user_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify the entered password with the hashed password stored in the database
        if (password_verify($user_password, $row['user_password'])) {
            // Password is correct, set session variables
            $_SESSION['user_name'] = $row['user_name'];
            $_SESSION['user_id'] = $row['user_id'];  // Store user ID for future use
            $_SESSION['user_email'] = $row['user_email'];

            // Redirect to the index page after login
            header("Location: profile.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid password!";
        }
    } else {
        // No user found with this email
        echo "No user found with this email!";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<html>
    <head>
    <link rel="stylesheet" type="text/css" href="login.css">
    </head>
<body>



<!-- Login form -->
<h2>Login</h2>
<form action="login.php" method="POST">
    Email: <input type="email" name="user_email" required><br><br>
    Password: <input type="password" name="user_password" required><br><br>
    <a href="register.php">Don't have an account ?</a>
    <input type="submit" value="Login">
    
</form>


</body>
</html>
