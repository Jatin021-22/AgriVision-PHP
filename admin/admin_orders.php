<?php
// admin_orders.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farm"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle order cancellation
if (isset($_GET['cancel_order'])) {
    $order_id = intval($_GET['cancel_order']);
    $sql = "DELETE FROM orders WHERE order_id = $order_id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Order ID $order_id has been canceled successfully!');</script>";
    } else {
        echo "<script>alert('Error canceling order: " . $conn->error . "');</script>";
    }
}

// Fetch all orders
$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
include 'includes\header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">

    <style>
        body {
            padding: 20px;
        }
        table {
            margin-top: 20px;
            box-shadow:#8dc3ef;
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <?php include 'includes\sidebar.php';?>
<main id="main" class="main">

<div class="pagetitle">
  <h3>Orders</h3>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Manage Orders</li>
    </ol>
  </nav>
</div>
    <div class="container">
        <h2 class="text-center" style="margin-bottom:20px;">Admin - Order Management</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product ID</th>
                    <th>User ID</th>
                    <th>Quantity</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['order_id'] . "</td>";
                        echo "<td>" . $row['product_id'] . "</td>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td><a href='?cancel_order=" . $row['order_id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to cancel this order?\");'><i class='fas fa-times'></i> Cancel</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No orders found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
include 'includes\footer.php';
?>

