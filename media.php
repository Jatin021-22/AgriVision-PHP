<?php?>
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//include 'header.php';
$conn = new mysqli('localhost', 'root', '', 'farm'); // Update with your database credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch news items from the database
$sql = "SELECT * FROM news";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Media</title>

    <style>
        body {
           
            font-family: 'Arial', sans-serif;
           
        }
        .container {
          
           
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .card {
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 4px 16px rgb(150, 197, 244);
        }
        .btn {
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn:hover {
            background-color: #007bff;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
<?php include ('header.php'); ?>

<!-- ***** Breadcrumb Area Start ***** -->
<div class="breadcrumb-area">
    <div class="container h-100">
        <div class="row h-100 align-items-end">
            <div class="col-12">
                <div class="breadcumb--con">
                    <h4 style="font-size:40px;color:#5eb4ee;">News </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">News</li>
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
        <h2>Available News Documents</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-body">
                        
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                        <p class="card-text"><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?> <strong>Time:</strong> <?php echo htmlspecialchars($row['time']); ?></p>
                        <a href="<?php echo htmlspecialchars($row['document']); ?>" class="btn btn-info" target="_blank">Read News</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No news documents available.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
//$conn->close(); // Close the database connection
?>
<?php include 'footer.php'?>