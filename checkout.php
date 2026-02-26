<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'farm'); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT DISTINCT user_id FROM cart";
$result = $conn->query($sql);

if ($result) {
    
    $user_ids = [];
    while ($row = $result->fetch_assoc()) {
        $user_ids[] = $row['user_id'];
    }
    $user_id = !empty($user_ids) ? $user_ids[0] : null; 
} else {
    
    echo "Query error: " . $conn->error;
    $user_id = null; 
}
$query = "INSERT INTO `orders` (`product_id`, `user_id`, `quantity`) 
           SELECT `product_id`, `user_id`, `quantity` 
           FROM `cart` 
           WHERE `user_id` = '$user_id'";

if (mysqli_query($conn, $query)) {
  $query = "DELETE FROM `cart` WHERE `user_id` = '$user_id'";
  mysqli_query($conn, $query);
  $message = "Order placed successfully!";
  
} else {
    $message = "Error placing order: " . mysqli_error($conn);
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status</title>
    <style>
        #popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: #28a745; 
            color: white;
            padding: 20px;
            border-radius: 8px;
            z-index: 1000;
            animation: fadeIn 0.5s ease, fadeOut 0.5s ease 2.5s forwards; 
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; }
        }
    </style>
</head>
<body>

<div id="popup"><?php echo $message; ?></div>

<script>
    const popup = document.getElementById('popup');
    if (popup.textContent) {
        popup.style.display = 'block';
        
        setTimeout(() => {
            window.location.href = 'orders.php';
        }, 3000); 
    }
</script>

</body>
</html>