
<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Blog - Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 800px;
           
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        form {
            display: flex;
            flex-direction: column;
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
            border-radius: 5px;
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
      <h3>Manage Blogs</h3>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Manageblogs</li>
        </ol>
      </nav>
    </div>
<div class="container">
    <h1>Update Blog</h1>

    <?php
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'farm'); 

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch blog data for the specific blogId
    if (isset($_GET['id'])) {
        $blogId = $_GET['id'];
        $sql = "SELECT bloguser, blogTitle, blogContent FROM blogdata WHERE blogId = $blogId";
        $result = $conn->query($sql);
        $blog = $result->fetch_assoc();
    }

    // Handle the update
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $bloguser = $_POST['bloguser'];
        $blogTitle = $_POST['blogTitle'];
        $blogContent = $_POST['blogContent'];

        $sql = "UPDATE blogdata SET bloguser='$bloguser', blogTitle='$blogTitle', blogContent='$blogContent' WHERE blogId=$blogId";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Blog updated successfully!</p>";
        } else {
            echo "<p>Error updating blog: " . $conn->error . "</p>";
        }
    }
    ?>

    <form action="" method="POST">
        <input type="text" name="bloguser" placeholder="Enter your name" required value="<?php echo htmlspecialchars($blog['bloguser']); ?>">
        <input type="text" name="blogTitle" placeholder="Enter blog title" required value="<?php echo htmlspecialchars($blog['blogTitle']); ?>">
        <textarea name="blogContent" rows="10" placeholder="Enter blog content" required><?php echo htmlspecialchars($blog['blogContent']); ?></textarea>
        <input type="submit" value="Update Blog">
    </form>
</div>

</body>
</html>

<?php include('includes/footer.php'); ?>