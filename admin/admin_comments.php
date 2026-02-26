<?php include('includes/header.php'); ?>
<?php
// admin_comments.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "farm"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle comment deletion
if (isset($_GET['delete_comment'])) {
    $commentId = intval($_GET['delete_comment']);
    $sql = "DELETE FROM comments WHERE commentId = $commentId";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Comment ID $commentId has been deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting comment: " . $conn->error . "');</script>";
    }
}

// Fetch all comments
$sql = "SELECT * FROM comments";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Comments</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            padding: 20px;
        }
        table {
           
            animation: fadeIn 1s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @media (max-width: 768px) {
            table {
                width: 100%;
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            thead {
                display: none;
            }
            tr {
                display: flex;
                flex-direction: column;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 10px;
                padding: 10px;
            }
            td {
                text-align: left;
                padding: 8px;
                border: none;
                border-bottom: 1px solid #ddd;
            }
            td:last-child {
                border-bottom: none; /* Remove bottom border for last td */
            }
            td::before {
                content: attr(data-label);
                font-weight: bold;
                display: inline-block;
                margin-right: 10px;
            }
        }
    </style>
</head>
<body>
    
<?php include('includes/sidebar.php'); ?>
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
        <h2 class="text-center" style="margin-bottom:30px;">Admin - Comment Management</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Comment ID</th>
                    <th>Blog ID</th>
                    <th>Username</th>
                    <th>Comment</th>
                    <th>Comment Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td data-label='Comment ID'>" . $row['commentId'] . "</td>";
                        echo "<td data-label='Blog ID'>" . $row['blogId'] . "</td>";
                        echo "<td data-label='Username'>" . htmlspecialchars($row['username']) . "</td>";
                        echo "<td data-label='Comment'>" . htmlspecialchars($row['comment']) . "</td>";
                        echo "<td data-label='Comment Time'>" . $row['commentTime'] . "</td>";
                        echo "<td data-label='Action'>
                                <a href='?delete_comment=" . $row['commentId'] . "' class='btn btn-danger btn-sm' 
                                   onclick='return confirm(\"Are you sure you want to delete this comment?\");'>
                                   <i class='fas fa-trash'></i> Delete
                                </a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>No comments found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>

<?php include 'includes\footer.php'?>