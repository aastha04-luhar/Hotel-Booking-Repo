<?php
// Database Connection
$host = "localhost"; // Change if needed
$user = "root"; // Default for XAMPP
$password = ""; // Default for XAMPP
$database = "hbook"; // Change to your database name

$conn = new mysqli($host, $user, $password, $database);

// Check Connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    // Basic Validation
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required!";
        exit;
    }

    // Insert Data into Database
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close Resources
    $stmt->close();
}

$conn->close();
?>
