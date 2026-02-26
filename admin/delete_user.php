<?php
// delete_user.php
session_start();
// Database connection
$conn = new mysqli('localhost', 'root', '', 'farm'); // Update with your database credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the delete form is submitted
if (isset($_POST['delete_user'])) {
    $userId = $_POST['user_id'];

    // Prepare the delete statement
    $stmt = $conn->prepare("DELETE FROM registration WHERE id = ?");
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        echo "<script>alert('User deleted successfully.'); window.location.reload();</script>";
    } else {
        echo "<script>alert('Error deleting user: " . $conn->error . "');</script>";
    }
}

// Fetch users from the database
$sql = "SELECT * FROM registration";
$result = $conn->query($sql);
$conn->close();
?>




