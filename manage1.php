<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "hbook");

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

// Handle Cancel Booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];

    $deleteQuery = "DELETE FROM bookingss WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("is", $booking_id, $user_email);

    if ($stmt->execute()) {
        echo "<script>alert('Booking canceled successfully!'); window.location.href='manage1.php';</script>";
    } else {
        echo "<script>alert('Error canceling booking');</script>";
    }
}

// Handle Update Booking Date
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_booking'])) {
    $booking_id = $_POST['booking_id'];
    $new_check_in = $_POST['check_in_date'];
    $new_check_out = $_POST['check_out_date'];

    $updateQuery = "UPDATE bookingss SET check_in_date = ?, check_out_date = ? WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("ssis", $new_check_in, $new_check_out, $booking_id, $user_email);

    if ($stmt->execute()) {
        echo "<script>alert('Booking updated successfully!'); window.location.href='manage1.php';</script>";
    } else {
        echo "<script>alert('Error updating booking');</script>";
    }
}
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
        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 14px;
        }
        .cancel-btn {
            background-color: red;
        }
        .update-btn {
            background-color: green;
        }
    </style>
</head>
<body>

<nav>
    <a href="dashboard.php"> Home</a>
    <a href="hotel.php"> View Hotels</a>
    <a href="mybookings.php"> Bookings</a>
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

                <!-- Cancel Booking Form -->
                <form method="POST">
                    <input type="hidden" name="booking_id" value="<?= $booking['id']; ?>">
                    <button type="submit" name="cancel_booking" class="btn cancel-btn">Cancel Booking</button>
                </form>

                <!-- Update Booking Date Form -->
                <form method="POST">
                    <input type="hidden" name="booking_id" value="<?= $booking['id']; ?>">
                    <label>New Check-in Date:</label>
                    <input type="date" name="check_in_date" required>
                    <label>New Check-out Date:</label>
                    <input type="date" name="check_out_date" required>
                    <button type="submit" name="update_booking" class="btn update-btn">Update Booking</button>
                </form>
            </div>
        <?php } ?>
    <?php } else { ?>
        <p>No bookings found.</p>
    <?php } ?>
</div>

</body>
</html>
