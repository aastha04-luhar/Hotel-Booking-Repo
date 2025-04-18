<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "hbook");

// Check for a valid connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$user_email = $_SESSION['email']; // Get logged-in user's email

// Fetch user's booked rooms based on email
$sql = "SELECT bookingss.*, rooms.room_type, rooms.price, hotels.name AS hotel_name, hotels.location 
        FROM bookingss 
        JOIN rooms ON bookingss.room_id = rooms.id
        JOIN hotels ON rooms.hotel_id = hotels.id
        WHERE bookingss.email = ?
        ORDER BY bookingss.booking_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: url('h1.jpg') no-repeat center center fixed;
            margin: 0;
            padding: 0;
            text-align: center;
            color: white;
        }

        nav {
            display: flex;
            font-weight: bold;
            justify-content: space-evenly;
            background-color: #f9f9f9;
            padding: 10px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 800px;
            background: white;
            color: black;
            padding: 20px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }
        .booking-card {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }
        .booking-card h3 {
            margin: 0;
            font-size: 20px;
        }
        .booking-card p {
            margin: 5px 0;
        }
    </style>
</head>
<body>

<nav>
    <a href="dashboard.php"> Home</a>
    <a href="hotel.php"> View Hotels</a>
    <a href="manage1.php"> Manage Rooms</a>
    <a href="contact.php"> Contact Us</a>
</nav>

<div class="container">
    <h2>My Booked Rooms</h2>
    <?php if ($result->num_rows > 0) { ?>
        <?php while ($booking = $result->fetch_assoc()) { ?>
            <div class="booking-card">
                <h3><?= htmlspecialchars($booking['hotel_name']); ?> (<?= htmlspecialchars($booking['location']); ?>)</h3>
                <p><strong>Room Type:</strong> <?= htmlspecialchars($booking['room_type']); ?></p>
                <p><strong>Price:</strong> <?= htmlspecialchars($booking['price']); ?> INR</p>
                <p><strong>Check-in:</strong> <?= htmlspecialchars($booking['check_in_date']); ?></p>
                <p><strong>Check-out:</strong> <?= htmlspecialchars($booking['check_out_date']); ?></p>
                <p><strong>Booked On:</strong> <?= htmlspecialchars($booking['booking_date']); ?></p>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No bookings found.</p>
    <?php } ?>
</div>

</body>
</html>
