<?php
include('config.php');
include('header.php');

?>
<?php
// Database connection
// Database connection
$conn = new mysqli('localhost', 'root', '', 'farm'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Fetch products from the database
$sql = "SELECT productid, productname, productprice, productdescription, productphoto FROM product";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Add your Bootstrap path -->
    <style>
        
        .card {
            transition: transform 0.2s;
            margin-top:30px;
            border-radius:10px;
            
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0px 4px 16px rgba(114, 179, 244, 0.84);
        }
        .form-control{
            border-radius:13px;
            
        }
    </style>
</head>
<body>
<?php //include ('header.php'); ?>

<!-- ***** Breadcrumb Area Start ***** -->
<div class="breadcrumb-area">
    <div class="container h-100">
        <div class="row h-100 align-items-end">
            <div class="col-12">
                <div class="breadcumb--con">
                    <h4 style="font-size:40px;color:#5eb4ee;">Shopping</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Shopping - products</li>
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
    <h2 class="text-center">Our Products</h2>
    <div class="row">
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($row['productphoto']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['productname']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['productname']); ?></h5>
                            <p class="card-text">Price: <i class='bx bx-rupee' ></i><?php echo number_format($row['productprice'], 2); ?>/Kg.</p>
                            <p class="card-text"><?php echo htmlspecialchars($row['productdescription']); ?></p>
                           <form id="add-to-cart-form-<?php echo $row['productid']; ?>" method="POST" action="add_to_cart.php" style="display: none;">
                                  <input type="hidden" name="product_id" value="<?php echo $row['productid']; ?>">
                             </form>
                      <a href="#" class="add-to-cart-btn" data-id="<?php echo $row['productid']; ?>" data-name="<?php echo htmlspecialchars($row['productname']); ?>" style="
                                            display: inline-block; /* Block-level for better click area */
                                            background-color: #49abe8; 
                                             box-shadow: 0px 4px 16px rgba(175, 214, 236, 0.84);
                                            color: white; /* White text color */
                                            padding: 10px 20px; /* Padding around the text */
                                            border: none; /* No border */
                                            border-radius: 10px; /* Slightly rounded corners */
                                            text-align: center; /* Center the text */
                                            text-decoration: none; /* Remove underline */
                                            font-size: 15px; /* Font size */
                                            cursor: pointer; /* Pointer cursor on hover */
                                            transition: background-color 0.3s; /* Smooth transition for background color */
   "
   onmouseover="this.style.backgroundColor='#1f6bae';" 
   onmouseout="this.style.backgroundColor='#49abe8';).submit();">
                            <i class='bx bx-cart-add' style="color:#e4dfdf,font-size: 40px;"></i> Add To Cart
                     </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No products found.</p>
        <?php endif; ?>
    </div>
</div>
<!-- Quantity Modal -->
<div class="modal fade" id="quantityModal" tabindex="-1" role="dialog" aria-labelledby="quantityModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quantityModalLabel">Enter Quantity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="quantity-form">
                    <input type="hidden" id="product-id" name="product_id">
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control"> 
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirm-btn">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        // Show the modal when "Add to Cart" is clicked
        $('.add-to-cart-btn').on('click', function() {
            var productId = $(this).data('id');
            var productName = $(this).data('name');

            // Set the product ID in the modal form
            $('#product-id').val(productId);
            $('#quantityModalLabel').text('Enter Quantity for ' + productName);

            // Show the modal
            $('#quantityModal').modal('show');
        });

        // Handle the confirm button click in the modal
        $('#confirm-btn').on('click', function() {
            var productId = $('#product-id').val();
            var quantity = $('#quantity').val();

            // Send an AJAX POST request to update the cart
            $.ajax({
                url: 'add_to_cart.php',
                method: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity
                },
                success: function(response) {
                    alert('Product added to cart successfully!');
                    $('#quantityModal').modal('hide'); // Hide the modal
                },
                error: function() {
                    alert('Failed to add product to cart.');
                }
            });
        });
        
    });
</script>

</body>
</html>




<?php
// Close connection at the end of the script
//$conn->close();
?>
<?php include('footer.php');?>
