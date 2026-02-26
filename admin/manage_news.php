<?php
include('includes/header.php'); 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$conn = new mysqli('localhost', 'root', '', 'farm'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle deletion of news item
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM news WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('News item deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting news item: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Fetch news items from the database
$sql = "SELECT * FROM news";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes\sidebar.php'?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage News</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            
        }
        .container1 {
            max-width: 800px;
            margin: auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s;
        }
        .container:hover {
            transform: scale(1.02);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .btn {
            transition: background-color 0.3s, transform 0.3s;
        }
        .btn:hover {
            background-color: #007bff;
            color: white;
            transform: translateY(-2px);
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    
  <main id="main" class="main">

<div class="pagetitle">
  <h1>News</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Manage News</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

    <div class="container1">
        <h2>Manage News</h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                        <p class="card-text"><strong>Date:</strong> <?php echo htmlspecialchars($row['date']); ?> <strong>Time:</strong> <?php echo htmlspecialchars($row['time']); ?></p>
                        <a href="<?php echo htmlspecialchars($row['document']); ?>" class="btn btn-info" target="_blank">View Document</a>
                        <a href="edit_news.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="?delete_id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this news item?');">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No news items found.</p>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the database connection
?>
<?php include('includes/footer.php');?>