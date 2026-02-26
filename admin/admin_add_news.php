<?php include('includes/header.php'); ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    
    // Handle file upload
    $document = $_FILES['document']['name'];
    $target_dir = "../uploads/"; // Directory to save uploaded files
   // $target_file = $target_dir . basename($document);
    $target_file = $target_dir . basename($_FILES['document']['name']);
    // Move the uploaded file to the specified directory
    if (copy($_FILES['document']['tmp_name'], $target_file)) {
        // Insert news item into the database
        $conn = new mysqli('localhost', 'root', '', 'farm');
        $sql = "INSERT INTO news (title, content, time, date, document) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $title, $content, $time, $date, $target_file);
        
        if ($stmt->execute()) {
            echo "<script>alert('News added successfully!');</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "');</script>";
        }
        
        $stmt->close();
        $conn->close();
    } else {
        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include('includes/sidebar.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add News</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
          
        }
        .container {
            max-width: 600px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            background-color: #ffffff;
            padding: 20px;
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
    </style>
</head>
<body>
<main id="main" class="main">

<div class="pagetitle">
  <h3>News</h3>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Add News</li>
    </ol>
  </nav>
</div>
    
    <div class="container">
        <h2>Add News</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea class="form-control" name="content" required></textarea>
            </div>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" class="form-control" name="time" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" name="date" required>
            </div>
            <div class="form-group">
                <label for="document">Document (PDF):</label>
                <input type="file" class="form-control-file" name="document" accept=".pdf" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Add News</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include 'includes\footer.php'?>