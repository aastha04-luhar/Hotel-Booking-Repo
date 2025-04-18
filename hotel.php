<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit();
}

$conn = new mysqli("localhost", "root", "", "hbook");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM hotels";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Listings</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('h1.jpg') no-repeat center center fixed;
            margin: 0;
            padding: 0;
            text-align: center;
            color: white;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(0, 0, 0, 0.2);
        }

        nav {
            display: flex;
            font-weight: bold;
            justify-content: space-evenly;
            background-color: #f9f9f9;
            padding: 10px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
        }
        h2 {
            margin-top: 20px;
            font-size: 30px;
        }
        .hotel-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
        }
        .hotel-btn {
            display: block;
            width: 80%;
            padding: 20px;
            font-size: 24px;
            font-weight: bold;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 0;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        }
        .hotel-btn:hover {
            background: #0056b3;
            transform: scale(1.1);
            box-shadow: 0 8px 14px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>

<nav>
    <a href="dashboard.php"> Home</a>
    <a href="manage1.php"> Manage Rooms</a>
    <a href="mybookings.php"> Bookings</a>
    <a href="contact.php"> Contact Us</a>

</nav>

    <div class="header">
        <div class="logo">BOOKEASE</div>
    </div>
    <h2>Available Hotels</h2>
    <div class="hotel-list">
        <?php while ($row = $result->fetch_assoc()) { ?>
            <a href="room.php?hotel_id=<?= $row['id'] ?>" class="hotel-btn">
                <?= $row['name'] ?>
            </a>
        <?php } ?>
    </div>
</body>
</html>
