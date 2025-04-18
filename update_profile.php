<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "hbook";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit();
}

// Get user data
$email = $_SESSION['email'];
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$dob = $_POST['dob'];
$age = date_diff(date_create($dob), date_create('today'))->y;

// Profile picture upload
$profile_pic = $_FILES['profile_pic']['name'];
$target_dir = "uploads/";
$target_file = $target_dir . basename($profile_pic);

// If a new profile picture is uploaded, move it to the uploads folder
if (!empty($profile_pic)) {
    if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        // Update profile picture in database
    } else {
        echo "<script>alert('Profile picture upload failed!'); window.location.href='profile.php';</script>";
        exit();
    }
} else {
    // If no new profile picture, keep the existing one
    $sql = "SELECT profile_pic FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $profile_pic = $user['profile_pic'];
    $stmt->close();
}

// Update user details in the database
$sql = "UPDATE users SET fullname=?, address=?, dob=?, age=?, profile_pic=? WHERE email=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $fullname, $address, $dob, $age, $profile_pic, $email);

if ($stmt->execute()) {
    echo "<script>
        alert('Profile updated successfully!');
        window.location.href='dashboard.php';
    </script>";
} else {
    echo "<script>
        alert('Update failed! Please try again.');
        window.location.href='profile.php';
    </script>";
}

$stmt->close();
$conn->close();
?>
