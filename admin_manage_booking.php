<?php
// Start session and connect to database
session_start();
$conn = new mysqli("localhost", "root", "", "hbook");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle booking deletion
if (isset($_GET['delete_id'])) {
    $booking_id = $_GET['delete_id'];
    $deleteQuery = "DELETE FROM bookingss WHERE id = '$booking_id'";
    
    if ($conn->query($deleteQuery) === TRUE) {
        echo "<script>alert('Booking deleted successfully!'); window.location.href='admin_manage_booking.php';</script>";
    } else {
        echo "Error deleting booking: " . $conn->error;
    }
}

// Fetch all bookings with check-in and check-out dates
$query = "SELECT b.id, u.name AS user_name, u.email, h.name AS hotel_name, 
                 r.room_type, b.booking_date, b.check_in_date, b.check_out_date 
          FROM bookingss b
          JOIN users u ON b.user_id = u.id
          JOIN rooms r ON b.room_id = r.id
          JOIN hotels h ON r.hotel_id = h.id
          ORDER BY b.booking_date DESC";

$result = $conn->query($query);

// ** Check if the query failed **
if (!$result) {
    die("Error in SQL Query: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Bookings</title>
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
            text-align: center;
            padding: 20px;
            font-size: 24px;
        }
        nav {
            display: flex;
            justify-content: space-evenly;
            background-color: #f9f9f9;
            padding: 10px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background: rgba(255, 255, 255, 0.9);
            color: black;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: center;
        }
        th {
            background: #5c2d91;
            color: white;
        }
        .delete-btn {
            background: red;
            color: white;
            padding: 5px 10px;
            border: none;
            cursor: pointer;
        }
        .delete-btn:hover {
            background: darkred;
        }
        .back-btn {
            background: #4CAF50;
            color: white;
            padding: 10px;
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn:hover {
            background: darkgreen;
        }
    </style>
</head>
<body>


<header>Admin Panel - Manage Bookings</header>
<nav>
    <a href="admin_add_room.php">Add Hotel/Room</a>
    <a href="user_hotels.php">View Hotels</a>
    <a href="delete_hotel_room.php">Cancel Hotel/Room</a> 
	<a href="admin_logout.php">Log Out</a> 
</nav>


<div class="container">
    <h2>All User Bookings</h2>
    
    <?php if ($result->num_rows > 0) { ?>
        <table>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Hotel</th>
                <th>Room Type</th>
                <th>Booking Date</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Action</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['user_name']; ?></td>
                    <td><?= $row['email']; ?></td>
                    <td><?= $row['hotel_name']; ?></td>
                    <td><?= $row['room_type']; ?></td>
                    <td><?= $row['booking_date']; ?></td>
                    <td><?= $row['check_in_date']; ?></td>
                    <td><?= $row['check_out_date']; ?></td>
                    <td>
                        <a href="admin_manage_booking.php?delete_id=<?= $row['id']; ?>" 
                           class="delete-btn" 
                           onclick="return confirm('Are you sure you want to delete this booking?');">
                            Delete
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No bookings found.</p>
    <?php } ?>

    <a href="admin_add_room.php" class="back-btn">Back to Dashboard</a>
</div>

</body>
</html>
