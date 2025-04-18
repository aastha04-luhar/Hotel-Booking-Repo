<?php
session_start();
$conn = new mysqli("localhost", "root", "", "hbook");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Check admin credentials
    $sql = "SELECT * FROM admins WHERE email = ? AND password = ?"; // Plain text password check
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_name"] = $admin["name"];
        $_SESSION["admin_email"] = $admin["email"];

        header("Location: admin_add_room.php"); // Redirect to add room page after login
        exit();
    } else {
        $message = "Invalid email or password!";
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
    <title>Admin Login</title>
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
        .register-link {
            margin-top: 15px;
            display: block;
            color: #007BFF;
            text-decoration: none;
        }
        .register-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Admin Login</h2>
    <p class="message"><?= $message; ?></p>
    <form method="POST">
        <input type="email" name="email" placeholder="Admin Email" required>
        <input type="text" name="password" placeholder="Password" required> <!-- Normal text password -->
        <button type="submit">Login</button>
    </form>
    <a href="admin_register.php" class="register-link">Don't have an account? Register here</a>
</div>

</body>
</html>
