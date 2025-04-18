<?php
session_start();


// Database connection
$conn = new mysqli("localhost", "root", "", "hbook");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['hotel_name'])) {
        // Add hotel
        $name = $_POST['hotel_name'];
        $location = $_POST['hotel_location'];
        $rating = $_POST['hotel_rating'];
        
        $query = "INSERT INTO hotels (name, location, rating) VALUES ('$name', '$location', '$rating')";
        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Hotel added successfully!');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    } elseif (isset($_POST['hotel_id'])) {
        // Add room
        $hotel_id = $_POST['hotel_id'];
        $room_type = $_POST['room_type'];
        $price = $_POST['price'];
        
        $query = "INSERT INTO rooms (hotel_id, room_type, price) VALUES ('$hotel_id', '$room_type', '$price')";
        if ($conn->query($query) === TRUE) {
            echo "<script>alert('Room added successfully!');</script>";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Fetch hotels for dropdown
$hotelQuery = "SELECT id, name FROM hotels";
$hotels = $conn->query($hotelQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Add Hotel & Room</title>
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
            background-color: rgba(92, 45, 145, 0.8); 
            color: white; 
            padding: 20px; 
            text-align: center; 
            font-size: 24px;
        }
        nav { 
            display: flex; 
            justify-content: center; 
            background-color: rgba(51, 51, 51, 0.8); 
            padding: 10px; 
        }
        nav a { 
            color: white; 
            text-decoration: none; 
            padding: 10px 20px; 
            margin: 0 10px; 
        }
        nav a:hover { 
            background-color: #4CAF50; 
            border-radius: 5px; 
        }
        .container { 
            padding: 20px; 
            background: rgba(255, 255, 255, 0.9); 
            color: black; 
            margin: 20px auto; 
            border-radius: 8px; 
            max-width: 600px; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        label, input, select, button { 
            display: block; 
            width: 100%; 
            margin: 10px 0; 
            padding: 10px; 
            font-size: 16px; 
        }
        button { 
            background-color: #5c2d91; 
            color: white; 
            border: none; 
            cursor: pointer; 
        }
        button:hover { 
            background-color: #4CAF50; 
        }
        footer { 
            text-align: center; 
            padding: 20px; 
            background-color: rgba(51, 51, 51, 0.8); 
            color: white; 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
        }

    </style>
</head>
<body>

<header>Admin Panel - Add Hotel & Room</header>

<nav>
    <a href="user_hotels.php">View Hotels</a>
    <a href="delete_hotel_room.php">Cancel Hotel/Room</a> 
    <a href="admin_manage_booking.php">Cancel Bookings</a> 
	<a href="admin_logout.php">Log Out</a> 
</nav>

<div class="container">
    <h2>Add a New Hotel</h2>
    <form method="POST">
        <label>Hotel Name:</label>
        <input type="text" name="hotel_name" required>
        
        <label>Location:</label>
        <input type="text" name="hotel_location" required>
        
        <label>Rating (1-5):</label>
        <input type="number" name="hotel_rating" min="1" max="5" required>
        
        <button type="submit">Add Hotel</button>
    </form>
</div>

<div class="container">
    <h2>Add a New Room</h2>
    <form method="POST">
        <label>Select Hotel:</label>
        <select name="hotel_id" required>
            <option value="">-- Choose Hotel --</option>
            <?php while ($row = $hotels->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
            <?php } ?>
        </select>
        
        <label>Room Type:</label>
        <input type="text" name="room_type" required>
        
        <label>Price:</label>
        <input type="number" name="price" min="0" required>
        
        <button type="submit">Add Room</button>
    </form>
</div>

<footer>&copy; 2025 BookEase | All Rights Reserved</footer>

</body>
</html>
