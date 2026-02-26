<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli('localhost', 'root', '', 'farm'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from AJAX request
$product_id = isset($_POST['productid']) ? intval($_POST['productid']) : 0;
$user_id = 1; // Replace with the actual user ID from the session

if ($product_id > 0) {
    $stmt = $conn->prepare("DELETE FROM cart WHERE product_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $product_id, $user_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo 'Product removed successfully';
    } else {
        echo 'Failed to remove product';
    }
    $stmt->close();
}

$conn->close();
?>
