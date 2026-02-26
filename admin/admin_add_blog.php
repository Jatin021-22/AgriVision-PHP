<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog - Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            
           
        }
        .container1 {
           
        
            max-width: 1000px;
            border-radius:20px;
    
            margin-left:350px;
            overflow: hidden;
            padding: 20px;
            background: #fff;
          
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
           
        }
        form {
            display: flex;
            flex-direction: column;
            border-radius:10px;
        }
        input[type="text"], textarea {
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px;
            background: #74b2f4;
            color: #fff;
            border: none;
            cursor: pointer;
            width:40%;
            display: block; 
            margin: 0 auto;
            border-radius: 10px;
        }
        input[type="submit"]:hover {
            background: #007bff;
        }
    </style>
   
   
</head>

<body>
<?php include('includes/sidebar.php'); ?>

<main id="main" class="main">

<div class="pagetitle">
  <h3>Blogs</h3>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Add Blogs</li>
    </ol>
  </nav>
</div><!-- End Page Title -->
    </main>
    <div class="container1">

        <h1>Add New Blog</h1>
        <form action="admin_add_blog.php" method="POST">
            <input type="text" name="bloguser" placeholder="Enter your name" required>
            <input type="text" name="blogTitle" placeholder="Enter blog title" required>
            <textarea name="blogContent" rows="10" placeholder="Enter blog content" required></textarea>
            <input type="submit" name="submit" value="Add Blog">
        </form>
        <?php
        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'farm'); // Update with your database credentials

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['submit'])) {
            $bloguser = $_POST['bloguser'];
            $blogTitle = $_POST['blogTitle'];
            $blogContent = $_POST['blogContent'];

            // Insert into the database
            $sql = "INSERT INTO blogdata (bloguser, blogTitle, blogContent, blogTime) VALUES ('$bloguser', '$blogTitle', '$blogContent', NOW())";
            
            if ($conn->query($sql) === TRUE) {
                echo "<p>Blog added successfully!</p>";
            } else {
                echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
            }
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
<?php include 'includes\footer.php'?>
