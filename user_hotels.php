<?php

session_start();


// Database connection
$conn = new mysqli("localhost", "root", "", "hbook");

// Fetch hotels
$query = "SELECT * FROM hotels";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Hotels</title>

    <!-- Internal CSS -->
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
            max-width: 800px;
        }
        h2 {
            color: #5c2d91;
        }
        .hotel-card {
            background-color: #fff;
            padding: 20px;
            margin: 10px 0;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .hotel-card h3 {
            color: #5c2d91;
            font-size: 24px;
        }
        .hotel-card p {
            font-size: 16px;
            color: #555;
        }
        .hotel-card .book-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #5c2d91;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            transition: background 0.3s ease;
        }
        .hotel-card .book-btn:hover {
            background-color: #4CAF50;
        }
		.room-list {
		list-style: none;
		padding: 15px;
		background-color: #f3f3f3;
		color: #222;
		border-radius: 8px;
		}
		.room-list li {
		margin-bottom: 12px;
		padding: 10px;
		border-bottom: 1px solid #ccc;
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
</head>
<body>

<header>Available Hotels</header>

<nav>
    <a href="admin_add_room.php">Add Hotel/Room</a>
    <a href="delete_hotel_room.php">Cancel Hotel/Room</a> 
    <a href="admin_manage_booking.php">Cancel Bookings</a> 
	<a href="admin_logout.php">Log Out</a> 
</nav>

<div class="container">
    <h2>Hotels List</h2>
	<?php while ($hotel = $result->fetch_assoc()) { 
    $hotel_id = $hotel['id'];

    // Fetch rooms for this hotel
    $rooms_result = $conn->query("
        SELECT r.*, 
               (SELECT COUNT(*) FROM bookingss WHERE room_id = r.id) AS booking_count 
        FROM rooms r 
        WHERE r.hotel_id = $hotel_id
    ");
?>
    <div class="hotel-card">
    <h3><?= htmlspecialchars($hotel['name']) ?></h3>
    <p><strong>Location:</strong> <?= htmlspecialchars($hotel['location']) ?></p>
    <p><strong>Rating:</strong> <?= htmlspecialchars($hotel['rating']) ?> ⭐</p>

    <?php if ($rooms_result->num_rows > 0): ?>
        <h4 style="color:#5c2d91; margin-top: 20px;">Rooms:</h4>
        <ul class="room-list">
            <?php while ($room = $rooms_result->fetch_assoc()) { ?>
                <li>
                    <strong>Room Type:</strong> <?= htmlspecialchars($room['room_type']) ?><br>
                    <strong>Price:</strong> ₹<?= $room['price'] ?><br>
                    <strong>Bookings:</strong> <?= $room['booking_count'] ?>
                </li>
            <?php } ?>
        </ul>
    <?php else: ?>
        <p style="color: #999;">No rooms available for this hotel.</p>
    <?php endif; ?>
</div>

<?php } ?>


</div>

<footer>&copy; 2025 BookEase | All Rights Reserved</footer>

</body>
</html>
