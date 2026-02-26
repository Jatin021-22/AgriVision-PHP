<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$conn = new mysqli('localhost', 'root', '', 'farm'); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = 1;

$sql = "SELECT p.productid, p.productname, p.productprice, p.productphoto, c.quantity 
        FROM cart c 
        JOIN product p ON c.product_id = p.productid 
        WHERE c.user_id = $user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel='stylesheet' href='https://unpkg.com/boxicons@latest/css/boxicons.min.css'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <meta name="description" content="uza - Model Agency HTML5 Template" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <title>Shopping Cart</title>
    <style>
    body {
        font-family: 'Arial', sans-serif;
        margin-top: 130px;
    }

    .container1 {
        max-width: 1300px;
        margin: 0 auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(15, 127, 239, 0.17);
    }

    h2 {
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        animation: fadeIn 0.5s;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        transition: background-color 0.3s;
    }

    th {
        background-color: #007bff;
        color: #0c0d0d;
        font-weight: bold;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

    tfoot th {
        background-color: #e9ecef;
        font-weight: bold;
    }

    .btn8 {
        display: inline-block;
        padding: 10px 15px;
        background-color: #007bff;
        color: white;
        text-align: center;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn8:hover {
        background-color: #0056b3;
    }
    .modal {
    display: none; 
    position: fixed; 
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    
    box-shadow: 0 0 20px rgb(125, 183, 241);
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
    animation: fadeIn 0.5s; /* Fade-in effect */
}

.modal-content {
    background-color: #fff; /* White background */
    margin: 5% auto; /* 15% from the top and centered */
    padding: 20px; /* Padding */
    border: 1px solid #96c1fe; /* Border color */
    border-radius: 20px; /* Rounded corners */
    width: 80%; /* Responsive width */
    max-width: 600px; /* Maximum width */
    max-height: 80%; /* Limit height to 80% of the viewport */
    overflow-y: auto; /* Allow vertical scrolling */
    animation: slideDown 0.5s ease; /* Slide down effect */
}

/* Keep the other styles as they are */


@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.close {
    color: #aaa;
    float: right; 
    font-size: 28px; 
    font-weight: bold; 
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

input {
    width: 100%; 
    padding: 10px; 
    margin-bottom:20px;
    border: 1px solid #ccc; 
    border-radius: 10px;
}

.dropdown select {
    width: 100%; 
    padding: 10px; 
    border: 1px solid #ccc;
    border-radius: 5px; 
    margin: 10px 0; 
}

/* Responsive styles */
@media (max-width: 768px) {
    .modal-content {
        margin: 5% auto; 
        width: 90%; 
    }

    h2, h3 {
        font-size: 1.5rem; 
    }

    .btn8, .btn-secondary {
        width: 100%;
        margin: 5px 0; 
    }
}
    @media (max-width: 768px) {
        th, td {
            padding: 10px;
        }

        h2 {
            font-size: 1.5rem;
        }
    }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>
<body>
<?php include ('header.php'); ?>

<!-- ***** Breadcrumb Area Start ***** -->
<div class="breadcrumb-area">
    <div class="container h-100">
        <div class="row h-100 align-items-end">
            <div class="col-12">
                <div class="breadcumb--con">
                    <h4 style="font-size:40px;color:#5eb4ee;">Cart</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Cart</li>
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
<div class="container1">
    <h2 class="text-center">Your Cart</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Product Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total = 0;

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $subtotal = $row['productprice'] * $row['quantity'];
                    $total += $subtotal;
                    echo "<tr>
                            <td><img src='" . htmlspecialchars($row['productphoto']) . "' alt='" . htmlspecialchars($row['productname']) . "' width='70' height='70'></td>
                            <td>" . htmlspecialchars($row['productname']) . "</td>
                            <td><i class='bi bi-currency-rupee'></i>" . number_format($row['productprice'], 2) . "/kg</td>
                            <td>" . htmlspecialchars($row['quantity']) . "kg</td>
                            <td><i class='bi bi-currency-rupee'></i>" . number_format($subtotal, 2) . "</td>
                            <td>
                                <button class='btn btn-danger remove-btn' data-productid='" . $row['productid'] . "'><i class='bi bi-trash'></i></button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Your cart is empty.</td></tr>";
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total:</th>
                <th><i class="bi bi-currency-rupee"></i><?php echo number_format($total, 2); ?></th>
                <th></th>
            </tr>
        </tfoot>
    </table>
    <a href="checkout.php">
    <div class="text-center mt-4">
        <button class="btn8" ><i class="bi bi-bag" ></i> Confirm Order</button>
        </div>
        </a>
    <!--
    <a href="javascript:void(0);" id="placeOrderBtn">
    <div class="text-center mt-4">
        <button class="btn8"><i class="bi bi-bag"></i> Place Order</button>
    </div>
</a>

</div>

<div class="modal" id="confirmModal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>Confirm Your Order</h2>
        <form id="orderConfirmationForm">
            <h3>Shipping Information</h3>
            <input type="text" placeholder="Full Name" style="margin-bottom:20px;"required>
            <input type="text" placeholder="Address" style="margin-bottom:20px;" required>
            <input type="text" placeholder="City" style="margin-bottom:20px;" required>
            <input type="text" placeholder="State" style="margin-bottom:20px;" required>
            <input type="text" placeholder="Zip Code" style="margin-bottom:20px;"  required>
            <input type="email" placeholder="Email" style="margin-bottom:20px;" required>
            <input type="tel" placeholder="Phone Number" style="margin-bottom:20px;" required>

            <h3>Select Payment Method:</h3>
            <div class="dropdown">
                <select id="paymentMethod" required>
                    <option value="">--Select--</option>
                    <option value="credit">Credit/Debit Card</option>
                    <option value="wallet">Digital Wallet</option>
                    <option value="delivery">Pay on Delivery</option>
                </select>
            </div>

            <div id="paymentDetails" class="hidden">
               
            </div>

            
  
        </form>
        <button id="cancelPurchase" style="margin-top:20px;display: inline-block;
        padding: 10px 15px;
        width:90px;
        margin-left:230px;
        background-color: #f9a07d;
        color: white;
        text-align: center;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;"><i class="bi bi-x"></i>Cancel</button>
    </div>
</div>

<script>
$(document).ready(function() {
    // Show confirmation modal on Place Order button click
    $('#placeOrderBtn').on('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        $('#confirmModal').css('display', 'block'); // Show the modal
    });

    // Close modal on X or Cancel button click
    $('#closeModal, #cancelPurchase').on('click', function() {
        $('#confirmModal').css('display', 'none'); // Hide the modal
    });

    // Handle order confirmation form submission
    $('#orderConfirmationForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        // Here you would typically process the order with an AJAX call
        alert('Order confirmed!'); // For demonstration; replace with actual processing
        $('#confirmModal').css('display', 'none'); // Hide modal
    });

    // Show payment details based on selected method
    $('#paymentMethod').on('change', function() {
        const selectedValue = $(this).val();
        $('#paymentDetails').empty(); // Clear previous details
        if (selectedValue === 'credit') {
            $('#paymentDetails').append('<input type="text" placeholder="Card Number" style="margin-bottom:20px;" required><input type="text" style="margin-bottom:20px;" placeholder="Cardholder Name" required><input type="text" style="margin-bottom:20px;" placeholder="Expiry Date (MM/YY)" required><input type="text" style="margin-bottom:20px;" placeholder="CVV" required>');
        } else if (selectedValue === 'wallet') {
            $('#paymentDetails').append('<input type="text" style="margin-bottom:20px;" placeholder="Wallet ID" required>');
        } else if (selectedValue === 'delivery') {
            $('#paymentDetails').append('<input type="text" style="margin-bottom:20px;" placeholder="Delivery Address" required>');
        }
        $('#paymentDetails').removeClass('hidden'); // Show payment details
    });
});
</script>
        -->



</body>
</html>

<?php include 'footer.php';?>
