<?php
session_start();


$conn = new mysqli('localhost', 'root', '', 'farm');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if product ID is set
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare delete statement
    $stmt = $conn->prepare("DELETE FROM product WHERE productid = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    // Redirect to manage product page
    header("Location: manage_product.php?deleted=success");
    exit();
} else {
    header("Location: manage_product.php?error=invalid_id");
    exit();
}

// Close the database connection
$stmt->close();
$conn->close();
?>
