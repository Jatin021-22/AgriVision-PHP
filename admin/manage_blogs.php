<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blogs - Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 1000px;
            margin-top:60px;
          /*  margin-left:350px;*/
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 15px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #74b2f4;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            padding: 10px 15px;
            background-color: #74b2f4;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn1 {
            padding: 10px 15px;
            background-color: #f85c5c;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #007bff;
        }
    </style>
</head>

<body>

<?php include('includes/sidebar.php'); ?>

<main id="main" class="main">



<div class="pagetitle">
      <h3>Manage Blogs</h3>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Manageblogs</li>
        </ol>
      </nav>
    </div>
<div class="container">
    <h1>Manage Blogs</h1>

    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'farm'); 

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle deletion of a blog
    if (isset($_GET['delete'])) {
        $blogId = $_GET['delete'];
        $sql = "DELETE FROM blogdata WHERE blogId = $blogId";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Blog deleted successfully!</p>";
        } else {
            echo "<p>Error deleting blog: " . $conn->error . "</p>";
        }
    }

    // Fetch blog data
    $sql = "SELECT blogId, bloguser, blogTitle, blogContent, blogTime FROM blogdata ORDER BY blogTime DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>Title</th><th>Author</th><th>Date</th><th>Actions</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['blogTitle']) . "</td>";
            echo "<td>" . htmlspecialchars($row['bloguser']) . "</td>";
            echo "<td>" . $row['blogTime'] . "</td>";
            echo "<td>
                    <a href='update_blog.php?id=" . $row['blogId'] . "' class='btn'>Update</a>
                    <a href='manage_blogs.php?delete=" . $row['blogId'] . "' class='btn1'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No blogs found.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
