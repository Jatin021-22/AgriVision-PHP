<?php
// Include header file and start session

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'farm'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'delete' parameter is set in the URL (to delete an order)
if (isset($_GET['delete'])) {
    $order_id_to_delete = intval($_GET['delete']);
    
    // Prepare and execute the delete query
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $order_id_to_delete);
    
    if ($stmt->execute()) {
        // Set a flag to indicate successful deletion
        $deletion_success = true;
    } else {
        $deletion_success = false;
        echo "Error deleting order: " . $conn->error;
    }
    
    $stmt->close();
}

// Get user_id from the session or database (replace with your own logic)
$sql = "SELECT DISTINCT user_id FROM orders";
$result = $conn->query($sql);

if ($result) {
    $user_ids = [];
    while ($row = $result->fetch_assoc()) {
        $user_ids[] = $row['user_id'];
    }
    $user_id = !empty($user_ids) ? $user_ids[0] : null; // Example: Assign the first user_id
} else {
    echo "Query error: " . $conn->error;
    $user_id = null;
}

if ($user_id) {
    // Fetch ordered items for the logged-in user
    $sql = "SELECT o.order_id, o.product_id, o.quantity, o.created_at, p.productname, p.productprice 
            FROM orders o 
            JOIN product p ON o.product_id = p.productid 
            WHERE o.user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        
           
        }
        .order-table-container {
          
            margin-left:150px;
            margin-bottom:50px;
            max-width: 800px;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(70, 189, 233, 0.54);
            animation: fadeIn 1s ease-in-out;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #a8cdf3;
        }
        th, td {
            text-align: center;
            vertical-align: middle; 
        }
       
        .cancel-order-btn {
            background-color: #ff6b6b;
            color: white;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(242, 141, 141, 0.77);
            padding: 5px 10px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .cancel-order-btn:hover {
            background-color: #ff4757;
        }
        .table-header {
            margin-top:10px;
            background-color: #98c7e6;
        }
       
        
    </style>
    <script>
        function confirmCancel(orderId) {
            // Show a confirm box before canceling the order
            if (confirm("Are you sure you want to cancel this order?")) {
                // Redirect to the same page with delete parameter
                window.location.href = "orders.php?delete=" + orderId;
            }
        }
    </script>
</head>
<?php //include 'header.php';?>
<body>
<?php include ('header.php'); ?>

<!-- ***** Breadcrumb Area Start ***** -->
<div class="breadcrumb-area">
    <div class="container h-100">
        <div class="row h-100 align-items-end">
            <div class="col-12">
                <div class="breadcumb--con">
                    <h4 style="font-size:40px;color:#5eb4ee;">Orders</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Order</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Background Curve -->
    <div class="breadcrumb-bg-curve">
        <img src="./img/core-img/curve-5.png" alt="">
    </div>
</div>
    <div class="container">
        
        <div class="order-table-container animate__animated animate__fadeInUp">
        <h3 class="text-center">Your Orders</h3>
            <table class="table table-striped table-hover">
                <thead class="table-header">
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Order Date</th>
                        <th>Cancel Order</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Check if any orders exist
                    if ($result->num_rows > 0) {
                        // Fetching and displaying ordered items
                        while ($row = $result->fetch_assoc()) {
                            $totalPrice = $row['productprice'] * $row['quantity']; // Calculate total price for each order
                            echo '<tr>
                                    <td>' . htmlspecialchars($row['order_id']) . '</td>
                                    <td>' . htmlspecialchars($row['productname']) . '</td>
                                    <td>' . htmlspecialchars($row['quantity']) . '/kg</td>
                                    <td><i class="bi bi-currency-rupee"></i>' . number_format($totalPrice, 2) . '/kg</td>
                                    <td>' . htmlspecialchars($row['created_at']) . '</td>
                                    <td><button class="cancel-order-btn" onclick="confirmCancel(' . $row['order_id'] . ')"><i class="bi bi-trash"></i></button></td>
                                  </tr>';
                        }
                    } else {
                        echo '<tr><td colspan="6" class="text-center">No orders found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php
    // Show a popup message if an order was deleted successfully
    if (isset($deletion_success) && $deletion_success) {
        echo '<script>alert("Order canceled successfully.");</script>';
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include 'footer.php';?>