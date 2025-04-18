<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please log in first.'); window.location.href='login.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - BookEase</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
<header>
    Welcome to BookEase
</header>

<nav>
    <a href="#home"><i class="fas fa-home"></i> Home</a>
    <a href="#hotels"><i class="fas fa-bed"></i> Hotels</a>
    <a href="#rooms"><i class="fas fa-cogs"></i> Manage Rooms</a>
    <a href="#bookings"><i class="fas fa-calendar-check"></i> Bookings</a>
    <a href="#contact"><i class="fas fa-envelope"></i> Contact Us</a>
	<a href="profile.php"> My profile</a>
    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</nav>

<main>
    <div class="welcome">
        Welcome, <strong><?php echo htmlspecialchars($_SESSION['email']); ?></strong>! 
        <p>Find your perfect stay with us.</p>
    </div>

    <div class="dashboard-cards">
        <div class="card" id="home" onclick="location.href='#home-section'">
            <i class="fas fa-home"></i>
            <h3>Home</h3>
            <p>Explore the best places to stay</p>
        </div>

        <div class="card" id="hotels" onclick="location.href='#hotels-section'">
            <i class="fas fa-building"></i>
            <h3>Hotels</h3>
            <p>Browse through a variety of hotels</p>
        </div>

        <div class="card" id="rooms" onclick="location.href='#rooms-section'">
            <i class="fas fa-door-open"></i>
            <h3>Manage Rooms</h3>
            <p>Add, edit, or delete room details</p>
        </div>

        <div class="card" id="bookings" onclick="location.href='#bookings-section'">
            <i class="fas fa-bookmark"></i>
            <h3>Bookings</h3>
            <p>View and manage your room bookings</p>
        </div>

        <div class="card" id="contact" onclick="location.href='#contact-section'">
            <i class="fas fa-phone"></i>
            <h3>Contact Us</h3>
            <p>Have questions? We're here to help.</p>
        </div>
    </div>

    <!-- Sections for each category -->
    <div id="home-section" class="section">
        <h2>Welcome to Home</h2>
        <p>Discover our platform that connects travelers with the best accommodations, ensuring comfort, quality, and affordability. Here, you can find the perfect place to stay for your next trip, whether for business or leisure.</p>
    </div>

    <div id="hotels-section" class="section">
    
        <h2>Explore Hotels</h2>
        <p>Our extensive hotel listings offer detailed descriptions, high-quality photos, and user reviews. Use our filters to refine your search by price, location, amenities, and ratings, making your decision-making process seamless and informed.</p>
        <a href="hotel.php"><i class="fas fa-bed"></i> View Hotels</a>
    </div>

    <div id="rooms-section" class="section">
    
        <h2>Manage Your Rooms</h2>
        <p>Easily add new rooms, update existing room details, and remove outdated listings. Our management tools help you maintain accurate and up-to-date information about your offerings to attract more guests.</p>
        <a href="manage1.php"><i class="fas fa-cogs"></i> Manage Rooms</a>
    </div>

    <div id="bookings-section" class="section">
        <h2>Your Bookings</h2>
        <p>Access a comprehensive overview of your bookings, including upcoming reservations and past stays. Modify, cancel, or rebook with just a few clicks, all in one convenient location.</p>
        <a href="mybookings.php"><i class="fas fa-calendar-check"></i> Book Here</a>
    </div>

    <div id="contact-section" class="section">
        <h2>Contact Us</h2>
        <p>Need assistance? Reach out to our dedicated support team via email or phone. We are here to help you with your inquiries, concerns, or feedback to ensure an excellent experience.</p>
        <a href="contact.php"><i class="fas fa-envelope"></i> Contact Here</a>
    </div>
</main>

<footer>
    &copy; 2024 BookEase | All Rights Reserved
</footer>

</body>
</html>
