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

// Get invoice number from URL
if (!isset($_GET['invoice_number'])) {
    die("Invalid request. No invoice number provided.");
}

$invoice_number = $conn->real_escape_string($_GET['invoice_number']);

// Fetch payment details
$sql = "SELECT * FROM payments WHERE invoice_number = '$invoice_number'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Invoice not found.");
}

$invoice = $result->fetch_assoc();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - <?php echo $invoice['invoice_number']; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .invoice-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        h2 {
            color: #28a745;
        }
        .invoice-details {
            text-align: left;
            margin-top: 10px;
        }
        .invoice-details p {
            margin: 5px 0;
        }
        .download-btn {
            margin-top: 15px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }
        .download-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <h2>Invoice</h2>
    <div class="invoice-details">
        <p><strong>Invoice Number:</strong> <?php echo $invoice['invoice_number']; ?></p>
        <p><strong>Date:</strong> <?php echo $invoice['payment_date']; ?></p>
        <p><strong>Name:</strong> <?php echo $invoice['name']; ?></p>
        <p><strong>Email:</strong> <?php echo $invoice['email']; ?></p>
        <p><strong>Amount:</strong> Rs<?php echo $invoice['amount']; ?></p>
        <p><strong>Payment Method:</strong> <?php echo ucfirst(str_replace("_", " ", $invoice['payment_method'])); ?></p>
        <p><strong>Status:</strong> <?php echo $invoice['payment_status']; ?></p>
    </div>
    <a href="invoices/<?php echo $invoice['invoice_number']; ?>.txt" class="download-btn" download>Download Invoice</a>
</div>

</body>
</html>