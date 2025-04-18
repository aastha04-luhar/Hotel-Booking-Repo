<?php
session_start();

$conn = new mysqli("localhost", "root", "", "hbook");

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_hotel'])) {
        $hotel_id = $_POST['delete_hotel'];

        // Check if any room in this hotel has bookings
        $check_bookings = $conn->query("
            SELECT b.id FROM bookingss b
            JOIN rooms r ON b.room_id = r.id
            WHERE r.hotel_id = '$hotel_id'
        ");

        if ($check_bookings->num_rows > 0) {
            echo "<script>alert('Cannot delete this hotel. Bookings exist for its rooms.');</script>";
        } else {
            // First delete rooms, then hotel
            $conn->query("DELETE FROM rooms WHERE hotel_id = '$hotel_id'");
            $conn->query("DELETE FROM hotels WHERE id = '$hotel_id'");
            echo "<script>alert('Hotel and its rooms deleted successfully!');</script>";
        }

    } elseif (isset($_POST['delete_room'])) {
        $room_id = $_POST['delete_room'];

        // Check if this room has bookings
        $check_room_booking = $conn->query("SELECT id FROM bookingss WHERE room_id = '$room_id'");

        if ($check_room_booking->num_rows > 0) {
            echo "<script>alert('Cannot delete this room. Bookings exist for this room.');</script>";
        } else {
            $conn->query("DELETE FROM rooms WHERE id = '$room_id'");
            echo "<script>alert('Room deleted successfully!');</script>";
        }
    }
}

// Fetch hotels and rooms again after possible deletion
$hotels = $conn->query("SELECT id, name FROM hotels");
$rooms = $conn->query("
    SELECT r.id, r.room_type, h.name AS hotel_name 
    FROM rooms r 
    JOIN hotels h ON r.hotel_id = h.id
");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Hotel/Room</title>

    <style>
        body {
            font-family: Arial, sans-serif; 
            background: url('admin.png') no-repeat center center fixed; 
            background-size: cover;
            color: white; 
            margin: 0; 
            padding: 0;
        }
        header {
            background-color: #5c2d91;
            color: white;
            padding: 20px 40px;
            text-align: center;
            font-size: 30px;
            font-weight: bold;
        }
        nav {
            display: flex;
            justify-content: space-evenly;
            background-color: #333;
            padding: 10px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        nav a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            font-size: 16px;
            transition: background 0.3s ease;
            border-radius: 5px;
        }
        nav a:hover {
            background-color: #4CAF50;
        }
        .container {
            padding: 40px;
            background-color: white;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }
        h2 {
            color: #5c2d91;
            text-align: center;
        }
        label, select, button {
            display: block;
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            font-size: 16px;
        }
        select {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: red;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
        }
        button:hover {
            background-color: darkred;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>

    <script>
        function confirmDelete() {
            return confirm("Are you sure you want to delete this?");
        }
    </script>
</head>
<body>

<header>Cancel Hotel or Room</header>

<nav>
    <a href="admin_add_room.php">Add Hotel/Room</a>
    <a href="user_hotels.php">View Hotels</a>
    <a href="admin_manage_booking.php">Cancel Booking</a> 
	<a href="admin_logout.php">Log Out</a> 
</nav>

<div class="container">
    <h2>Cancel a Hotel</h2>
    <form method="POST" onsubmit="return confirmDelete()">
        <label>Select Hotel:</label>
        <select name="delete_hotel" required>
            <option value="">-- Choose Hotel --</option>
            <?php while ($row = $hotels->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php } ?>
        </select>
        <button type="submit">Delete Hotel</button>
    </form>
</div>

<div class="container">
    <h2>Cancel a Room</h2>
    <form method="POST" onsubmit="return confirmDelete()">
        <label>Select Room:</label>
        <select name="delete_room" required>
            <option value="">-- Choose Room --</option>
            <?php while ($row = $rooms->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['room_type'] ?> - <?= $row['hotel_name'] ?></option>
            <?php } ?>
        </select>
        <button type="submit">Delete Room</button>
    </form>
</div>

<footer>&copy; 2025 BookEase | All Rights Reserved</footer>

</body>
</html>
