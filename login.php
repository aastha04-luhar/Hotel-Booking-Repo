<?php
session_start(); // Start session

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hbook";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and trim user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Query to check if the user exists and the password matches
    $sql = "SELECT id,  password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    // Check if the prepare function failed
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email); // Binding the email parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        // Check if the entered password matches the one in the database
        if ($password === $user['password']) {
            // Successful login, store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;
            
            echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
            exit();
        } else {
            // Incorrect password
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        // User not found
        echo "<script>alert('User not found!');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            background: url('reg.jpeg') no-repeat center center fixed;
            background-size: cover;
        }
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .link {
            margin-top: 15px;
            font-size: 14px;
        }
        .link a {
            color: #4CAF50;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Login Form</h2>
    <form id="loginForm" method="POST" action="">
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Enter your password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <div class="link">
        <a id="forgotPasswordLink">Forgot Password?</a>
    </div>
    <div class="link">
        Don't have an account? <a href="registration.php">Register Now</a>
    </div>
</div>

<!-- JavaScript for modal, if needed -->
<script>
    // Forgot Password Modal Logic (as needed)
</script>

</body>
</html>
