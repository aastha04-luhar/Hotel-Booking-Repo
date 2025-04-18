<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hbook");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // No hashing
    $passkey = $_POST["passkey"];

    // Check if the passkey is correct
    if ($passkey !== "hotel1234") {
        $message = "Invalid passkey! Only authorized users can register.";
    } else {
        // Insert admin details (password stored as plain text)
        $sql = "INSERT INTO admins (name, email, password, passkey) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $password, $passkey);

        if ($stmt->execute()) {
            // Store admin session
            $_SESSION["admin_id"] = $stmt->insert_id;
            $_SESSION["admin_name"] = $name;
            $_SESSION["admin_email"] = $email;

            // Redirect to admin add room page
            header("Location: admin_add_room.php");
            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('h1.jpg') no-repeat center center fixed;
            text-align: center;
            color: white;
        }
        .container {
            max-width: 400px;
            background: white;
            color: black;
            padding: 20px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007BFF;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        .message {
            color: red;
        }
        .login-link {
            margin-top: 15px;
            display: block;
            color: #007BFF;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Registration</h2>
    <p class="message"><?= $message; ?></p>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="password" placeholder="Password" required> <!-- Normal text password -->
        <input type="text" name="passkey" placeholder="Enter Admin Passkey" required>
        <button type="submit">Register</button>
    </form>
    <a href="admin_login.php" class="login-link">Already have an account? Login here</a>
</div>

</body>
</html>
