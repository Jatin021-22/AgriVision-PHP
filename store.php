<!--<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="uza - Model Agency HTML5 Template" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

   
    <title>Store - Green and Stretch 77 Farms Limited</title>

    
    <link rel="icon" href="./img/core-img/logo.png" />

    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php include ('header.php'); ?>


                <div class="col mb-5">
                    <div class="card h-100">
                     
                        <img class="card-img-top" src="./img/bg-img/" alt="..." />
                      
                        <div class="card-body p-4">
                            <div class="text-center">
                               
                                <h5 class="fw-bolder">Popular Item</h5>
                             
                                N40.00
                            </div>
                        </div>
                        
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                            <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="single-product.php">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include ('footer.php'); ?>
</body>

</html>-->
<?php
include ('config.php');

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>
<?php include('header.php');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h1>Product List</h1>

<table>
    <tr>
        <th>Product ID</th>
        <th>Product Image</th>
        <th>Product Description</th>
        <th>Product Price</th>
    </tr>
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['productid']); ?></td>
                <td><img src="<?php echo htmlspecialchars($row['productimage']); ?>" alt="Product Image" style="width: 100px; height: auto;"></td>
                <td><?php echo htmlspecialchars($row['productdescription']); ?></td>
                <td><?php echo htmlspecialchars($row['productprice']); ?> INR</td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No products available.</td>
        </tr>
    <?php endif; ?>
</table>

</body>
</html>

<?php
// Close connection at the end of the script
$conn->close();
?>
<?php include('footer.php');?>
