<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "hbook");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get user details from session
$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['email'];

// Get room_id from URL
if (!isset($_GET['room_id'])) {
    die("Error: room_id is not provided.");
}
$room_id = $_GET['room_id'];

// Fetch room details along with hotel name
$sql = "SELECT rooms.*, hotels.name AS hotel_name 
        FROM rooms 
        JOIN hotels ON rooms.hotel_id = hotels.id 
        WHERE rooms.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $room_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Error: Room not found.");
}

$room = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $num_people = $_POST['num_people'];

    // Check for overlapping bookings
    $conflict_query = "
        SELECT * FROM bookingss 
        WHERE room_id = ? 
        AND (
            (check_in_date <= ? AND check_out_date > ?) OR 
            (check_in_date < ? AND check_out_date >= ?) OR 
            (check_in_date >= ? AND check_out_date <= ?)
        )
    ";

    $stmt = $conn->prepare($conflict_query);
    $stmt->bind_param("issssss", $room_id, $check_in_date, $check_in_date, $check_out_date, $check_out_date, $check_in_date, $check_out_date);
    $stmt->execute();
    $conflict_result = $stmt->get_result();

    if ($conflict_result->num_rows > 0) {
        // Booking conflict detected
        echo "<script>
            alert('This room is already booked for the selected dates. Please choose different dates.');
            window.history.back();
        </script>";
    } else {
        // Proceed with booking
        $book_query = "INSERT INTO bookingss (user_id, email, room_id, check_in_date, check_out_date, num_people, booking_date) 
                       VALUES (?, ?, ?, ?, ?, ?, NOW())";

        $stmt = $conn->prepare($book_query);
        $stmt->bind_param("isissi", $user_id, $user_email, $room_id, $check_in_date, $check_out_date, $num_people);

        if ($stmt->execute()) {
            echo "<script>
                alert('Room booked successfully!');
                setTimeout(function() {
                    window.location.href = 'payment.php';
                }, 1000);
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - <?= htmlspecialchars($room['room_type']); ?></title>
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
            max-width: 500px;
            background: white;
            color: black;
            padding: 20px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background: #007BFF;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s;
        }
        button:hover {
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

<div class="container">
    <h2>Book Room: <?= htmlspecialchars($room['room_type']); ?></h2>
    <p><strong>Hotel:</strong> <?= htmlspecialchars($room['hotel_name']); ?></p>
    <p><strong>Price:</strong> <?= htmlspecialchars($room['price']); ?> INR</p>

    <form method="POST">
        <label for="check_in_date">Check-in Date:</label>
        <input type="date" id="check_in_date" name="check_in_date" required min="<?= date('Y-m-d'); ?>">

        <label for="check_out_date">Check-out Date:</label>
        <input type="date" id="check_out_date" name="check_out_date" required min="<?= date('Y-m-d'); ?>">

        <label for="num_people">Number of People:</label>
        <input type="number" id="num_people" name="num_people" required min="1" max="10">

        <button type="submit">Confirm Booking</button>
    </form>
</div>

</body>
</html>
