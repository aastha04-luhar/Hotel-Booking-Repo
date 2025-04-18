<?php
session_start();
$host = "localhost"; // Change if needed
$dbname = "hbook";
$username = "root"; // Change if needed
$password = ""; // Change if needed

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $amount = floatval($_POST['amount']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    // Generate a unique invoice number
    $invoice_number = "INV-" . rand(1000, 9999);
    $date = date("Y-m-d H:i:s");

    // Insert payment record into the database
    $sql = "INSERT INTO payments (invoice_number, name, email, amount, payment_method, payment_status) 
            VALUES ('$invoice_number', '$name', '$email', '$amount', '$payment_method', 'Paid')";

    if ($conn->query($sql) === TRUE) {
        // Save invoice as a text file
        $invoice_content = "Invoice Number: $invoice_number\n";
        $invoice_content .= "Date: $date\n";
        $invoice_content .= "Name: $name\n";
        $invoice_content .= "Email: $email\n";
        $invoice_content .= "Amount: $$amount\n";
        $invoice_content .= "Payment Method: $payment_method\n";
        $invoice_content .= "Status: Paid\n\n";

        if (!is_dir("invoices")) {
            mkdir("invoices", 0777, true);
        }

        $invoice_file = "invoices/$invoice_number.txt";
        file_put_contents($invoice_file, $invoice_content);

        // Success message
        $message = "<h2>Payment Successful!</h2>
                    <p>Thank you, <strong>$name</strong>. Your payment of <strong>Rs$amount</strong> has been received.</p>
                    <p>Invoice Number: <strong>$invoice_number</strong></p>
                    <p><a href='$invoice_file' download>Download Invoice</a></p>";
    } else {
        $message = "<p>Error processing payment: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="payment.css">
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
    <?php if (!empty($message)) { echo $message; } else { ?>
        <h2>Make a Payment</h2>
        <form method="POST">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="amount">Amount (Rs):</label>
            <input type="number" id="amount" name="amount" required>

            <label for="payment_method">Select Payment Method:</label>
            <select id="payment_method" name="payment_method" required>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>

            <button type="submit">Proceed to Pay</button>
        </form>
    <?php } ?>
</div>

</body>
</html>
