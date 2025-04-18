<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Hotel Booking</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
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
            font-weight: bold;
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
            margin: 0 10px;
        }
        nav a:hover {
            background-color: #4CAF50;
        }
        .contact-section {
            padding: 40px;
            background-color: white;
            margin: 20px auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }
        h1, h2 {
            color: #5c2d91;
        }
        .contact-section p {
            font-size: 18px;
            line-height: 1.6;
            color: #666;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 20px;
        }
        input, textarea {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }
        button {
            background-color: #5c2d91;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        button:hover {
            background-color: #4CAF50;
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
        @media (max-width: 768px) {
            .contact-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <header>
        Contact Us
    </header>

    <nav>
    <a href="dashboard.php"> Home</a>
    <a href="hotel.php"> View Hotels</a>
    <a href="manage1.php"> Manage Rooms</a>
    <a href="mybookings.php"> Bookings</a>
   

</nav>

    <section id="about" class="contact-section">
        <h2>About Our Website</h2>
        <p>
            Welcome to our hotel booking platform, your one-stop solution for finding the perfect accommodations for your travels.
            Our goal is to connect travelers with the best hotels, offering a seamless booking experience and a wide range of options
            to suit every budget and preference.
        </p>
        <p>
            With user-friendly search tools, detailed hotel descriptions, and verified reviews, we ensure you can make informed
            decisions for your stay. Whether you're traveling for business or leisure, our platform is designed to make your
            booking process easy, efficient, and enjoyable.
        </p>
    </section>

    <section id="contact-form" class="contact-section">
        <h2>Get in Touch</h2>
        <form action="submit_contact.php" method="POST">
            <label for="name">Your Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter your name" required>

            <label for="email">Your Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>

            <label for="message">Your Message:</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </section>

    <footer>
        &copy; 2025 BookEase | All Rights Reserved
    </footer>
</body>
</html>
