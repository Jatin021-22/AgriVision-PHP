<?php
 include('includes/header.php'); 
session_start();

// Check if the user is logged in


// Database connection

// Database connection
$conn = new mysqli('localhost', 'root', '', 'farm'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
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
// Fetch all products
$sql = "SELECT * FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'includes\sidebar.php'?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Products</title>
    <style>
        /* Add any custom styles here */
        .container{
           

        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: scale(1.05);
        }
        
    </style>
</head>
<body>
    
  <main id="main" class="main">

<div class="pagetitle">
  <h3>Product</h3>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Manage Product</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

    <div class="container">
        <h2 class="text-center">Manage Products</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Product Description</th>
                    <th>Product Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['productid']); ?></td>
                            <td><?php echo htmlspecialchars($row['productname']); ?></td>
                            <td><?php echo number_format($row['productprice'], 2); ?></td>
                            <td><?php echo htmlspecialchars($row['productdescription']); ?></td>
                            <td><img src="<?php echo htmlspecialchars($row['productphoto']); ?>" alt="<?php echo htmlspecialchars($row['productname']); ?>" width="50"></td>
                            <td>
                                <a href="edit_product.php" class="btn btn-warning">Edit</a>
                                <a href="delete_product.php?id=<?php echo $row['productid']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <a href="add_product.php" class="btn btn-primary">Add New Product</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
<?php include('includes/footer.php');?>
