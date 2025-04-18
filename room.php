<?php
session_start(); // Start session

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit();
}

$conn = new mysqli("localhost", "root", "", "hbook");

// Check for a valid connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get hotel_id from the URL
$hotel_id = $_GET['hotel_id'];

// Fetch rooms for the specific hotel
$sql = "SELECT * FROM rooms WHERE hotel_id = $hotel_id";
$result = $conn->query($sql);

// Fetch hotel details for display
$hotel_sql = "SELECT * FROM hotels WHERE id = $hotel_id";
$hotel_result = $conn->query($hotel_sql);
$hotel = $hotel_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms in <?= $hotel['name']; ?></title>
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
            padding: 20px;
            background: rgba(0, 0, 0, 0.2);
            font-size: 28px;
            font-weight: bold;
        }
        nav {
            display: flex;
            font-weight: bold;
            justify-content: space-evenly;
            background-color: #f9f9f9;
            padding: 10px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-top: 20px;
            font-size: 30px;
        }
        .room-list {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
            margin-top: 20px;
        }
        .room-card {
            width: 80%;
            background: white;
            color: black;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }
        .room-card:hover {
            transform: scale(1.05);
        }
        .book-btn {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 10px;
            font-size: 18px;
            font-weight: bold;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
        }
        .book-btn:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<nav>
    <a href="dashboard.php"> Home</a>
    <a href="hotel.php"> View Hotels</a>
    <a href="manage1.php"> Manage Rooms</a>
    <a href="mybookings.php"> Bookings</a>
    <a href="contact.php"> Contact Us</a>

</nav>

    <div class="header">BOOKEASE</div>
    <h2>Rooms Available in <?= $hotel['name']; ?> (<?= $hotel['location']; ?>)</h2>
    <div class="room-list">
        <?php if ($result->num_rows > 0) { ?>
            <?php while ($room = $result->fetch_assoc()) { ?>
                <div class="room-card">
                    <h3>Room Type: <?= $room['room_type'] ?></h3>
                    <p>Price: <?= $room['price'] ?> INR</p>
                    <a href="book_room.php?room_id=<?= $room['id'] ?>" class="book-btn">Book Room</a>
                </div>
            <?php } ?>
        <?php } else { ?>
            <p>No rooms available for this hotel at the moment.</p>
        <?php } ?>
    </div>
</body>
</html>
