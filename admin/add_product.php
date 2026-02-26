<?php
 include('includes/header.php'); 
// Database connection
$conn = new mysqli('localhost', 'root', '', 'farm'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO product (productname, productprice, productdescription, productphoto) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $productname, $productprice, $productdescription, $productphoto);

    // Set parameters
    $productname = $_POST['productname'];
    $productprice = $_POST['productprice'];
    $productdescription = $_POST['productdescription'];

    // Handle file upload
    if (isset($_FILES['productphoto']) && $_FILES['productphoto']['error'] == 0) {
        $targetDir = "uploads/img2/"; // Make sure this directory exists
        $productphoto = $targetDir . basename($_FILES['productphoto']['name']);
      
    } 

    if ($stmt->execute()) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
           
            margin: 0;
        }
        .form-container {
            background: white;
            max-width:800px;
           
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
          
            transition: transform 0.3s ease;
        }
        .form-container:hover {
            transform: scale(1.02);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #74b2f4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #007bff;
        }
    </style>
</head>
<body>
    
<?php include ('includes/sidebar.php'); ?>
    
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Products</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Add Product</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->


<div class="form-container">
    <h2>Add Product</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="text" name="productname" placeholder="Product Name" required>
        <input type="number" step="0.01" name="productprice" placeholder="Product Price" required>
        <textarea name="productdescription" placeholder="Product Description" rows="4"></textarea>
        <input type="file" name="productphoto" accept="image/*" required>
        <button type="submit">Add Product</button>
    </form>
</div>
    </main>
<script>
function showAlert() {
    <?php if ($message): ?>
        alert("<?php echo $message; ?>"); // Show alert with the message
        <?php // Clear the message after displaying it ?>
        <?php $message = ""; ?>
    <?php endif; ?>
    return true; // Allow form submission
}
</script>
</body>
</html>
<?php include 'includes\footer.php';?>
