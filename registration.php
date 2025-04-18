<?php
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hbook";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize message
$message = "";

// Form submission logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($password !== $confirmPassword) {
        $message = "Passwords do not match.";
    } else {
        // Check if email exists
        $checkEmailQuery = "SELECT email FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkEmailQuery);
        if (!$stmt) {
            die("Error preparing query: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "Email already registered.";
        } else {
            // Hash the password
            $hashedPassword = $password;//store plain password

            // Debugging: Check hashed password
            // echo "Hashed Password: $hashedPassword<br>";
            // echo "Length: " . strlen($hashedPassword) . "<br>";

            // Insert user data
            $insertQuery = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertQuery);

            if (!$stmt) {
                die("Error preparing insert query: " . $conn->error);
            }

            $stmt->bind_param("sss", $name, $email, $hashedPassword);

            if ($stmt->execute()) {
                $_SESSION['email'] = $email;
                echo "<script>alert('Registration successful!'); window.location.href='dashboard.php';</script>";
                exit();
            } else {
                $message = "Error during registration: " . $stmt->error;
            }
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
    <title>Registration Form</title>
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
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 15px;
            font-size: 24px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .login-link {
            margin-top: 10px;
            font-size: 14px;
        }
        .login-link a {
            color: #4CAF50;
            text-decoration: none;
        }
        .error-message, .success-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
        .success-message {
            color: green;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Register</h2>
    <form method="POST" action="">
        <input type="text" name="name" placeholder="Enter your name" required>
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="Create a password" minlength="6" required>
        <input type="password" name="confirmPassword" placeholder="Confirm your password" minlength="6" required>
        <button type="submit">Register</button>
    </form>
    <div class="login-link">
        Already have an account? <a href="login.php">Login Now</a>
    </div>
</div>

<?php if ($message): ?>
    <script>alert("<?php echo $message; ?>");</script>
<?php endif; ?>

</body>
</html>
