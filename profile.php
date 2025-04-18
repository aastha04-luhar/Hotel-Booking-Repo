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

// Fetch user data
$email = $_SESSION['email'];
$sql = "SELECT name, email, profile_pic, fullname, address, dob, age FROM users WHERE email = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    die("No user found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    
    <style>
      body {
    font-family: Arial, sans-serif;
    background: url('reg.jpeg') no-repeat center center fixed;
    background-size: cover;
    color: #333;
    text-align: center;
    margin: 0;
    padding: 0;
}

        .profile-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 60px auto;
            text-align: center;
        }

        .profile-pic img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #5c2d91;
            margin-bottom: 15px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
            text-align: left;
            width: 100%;
            margin-top: 10px;
            color: #555;
        }

        input, button {
            width: 100%;
            padding: 12px;
            margin: 6px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        input:focus {
            border-color: #5c2d91;
            outline: none;
            box-shadow: 0 0 5px rgba(92, 45, 145, 0.5);
        }

        button {
            background-color: #5c2d91;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease, transform 0.2s;
            border: none;
        }

        button:hover {
            background-color: #4a1e75;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

<div class="profile-container">
    <h2>My Profile</h2>

    <div class="profile-pic">
        <img src="<?php echo htmlspecialchars($user['profile_pic'] ?? 'uploads/default_profile.png'); ?>" alt="Profile Picture">
    </div>
    
    <form action="update_profile.php" method="post" enctype="multipart/form-data">
        <label>Profile Picture:</label>
        <input type="file" name="profile_pic" accept="image/*">
        
        <label>Full Name:</label>
        <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname'] ?? ''); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>

        <label>Address:</label>
        <input type="text" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" required>

        <label>Date of Birth:</label>
        <input type="date" name="dob" id="dob" value="<?php echo htmlspecialchars($user['dob'] ?? ''); ?>" required>

        <label>Age:</label>
        <input type="text" id="age" name="age" value="<?php echo $user['age'] ?? ''; ?>" readonly>

        <button type="submit">Update Profile</button>
    </form>
</div>

<script>
    function calculateAge() {
        let dobField = document.getElementById("dob");
        let ageField = document.getElementById("age");
        let dob = new Date(dobField.value);
        let today = new Date();
        let age = today.getFullYear() - dob.getFullYear();
        let monthDiff = today.getMonth() - dob.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        ageField.value = age;
    }

    window.onload = function() {
        let dobField = document.getElementById("dob");
        if (dobField.value) {
            calculateAge();
        }
    };

    document.getElementById("dob").addEventListener("change", calculateAge);
</script>

</body>
</html>
