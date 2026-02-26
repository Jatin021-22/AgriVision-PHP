<?php
session_start();


$conn = new mysqli('localhost', 'root', '', 'farm'); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $user_id = 1; 
    $quantity = intval($_POST['quantity']); 

    $checkQuery = "SELECT * FROM cart WHERE product_id = $product_id AND user_id = $user_id";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        
        $updateQuery = "UPDATE cart SET quantity = quantity + $quantity WHERE product_id = $product_id AND user_id = $user_id";
        $conn->query($updateQuery);
    } else {
      
        $insertQuery = "INSERT INTO cart (product_id, user_id, quantity) VALUES ($product_id, $user_id, $quantity)";
        $conn->query($insertQuery);
    }

    echo "Product added to cart successfully!";
    header("Location: cart.php");
    exit();
} else {
    echo "Product ID or quantity not specified.";
}

$conn->close(); 
?>
