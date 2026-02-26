<?php 
include('header.php'); 
include('config.php');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'farm'); // Update with your database credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert comment into the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $blogId = $_POST['blogId'];
    $username = $_POST['username'];
    $comment = $_POST['comment'];

    $stmt = $conn->prepare("INSERT INTO comments (blogId, username, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $blogId, $username, $comment);

    if ($stmt->execute()) {
       // header("Location: display_blog.php"); // Redirect back to the blog page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
   // $stmt->close();
}

// Increment likes count
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['like'])) {
    $blogId = $_POST['blogId'];

    $stmt = $conn->prepare("UPDATE blogdata SET likes = likes + 1 WHERE blogId = ?");
    $stmt->bind_param("i", $blogId);

    if ($stmt->execute()) {
        echo "Liked successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - User View</title>
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
        }

        .container1 {
            width: 80%;
            margin-top: 20px;
            margin-left:150px;
            max-width: 1400px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            margin-top: 30px;
        }

        /* Blog Styles */
        .blog-item {
            border-bottom: 1px solid #ddd;
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }

        .blog-item:hover {
            transform: translateY(-10px);
            box-shadow: 0px 4px 16px rgb(150, 197, 244);
        }

        h2 {
            color: #444;
            font-size: 24px;
            margin: 0;
        }

        p {
            line-height: 1.6;
            color: #555;
            margin: 10px 0;
        }

        .blog-meta {
            color: #777;
            font-size: 14px;
        }

        .like-button, .comment-button, .add-comment-button {
            margin-top:10px;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
            margin-right: 10px;
        }

        .like-button:hover, .comment-button:hover, .add-comment-button:hover {
            background-color: #0056b3;
        }

        /* Comment Section */
        .comment-section {
            margin-top: 20px;
            display: none; 
        }

        .comment-form {
            display: none; 
            flex-direction: column;
            margin-top: 10px;
        }

        .comment-form input,
        .comment-form textarea {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .comment-form button {
            background-color: #0fb5f1;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .comment-form button:hover {
            background-color: #3b62e3;
        }

      
        @media (max-width: 768px) {
            .container {
                width: 90%;
                padding: 15px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 18px;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
</head>
<body>
    <!-- Background Curve -->
    <?php //include ('header.php'); ?>

<!-- ***** Breadcrumb Area Start ***** -->
<div class="breadcrumb-area">
    <div class="container h-100">
        <div class="row h-100 align-items-end">
            <div class="col-12">
                <div class="breadcumb--con">
                    <h4 style="font-size:40px;color:#5eb4ee;">Blogs</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Blogs</li>
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
        <h1>Latest Blogs</h1>
        <?php
      
        $sql = "SELECT blogId, bloguser, blogTitle, blogContent, blogTime, likes FROM blogdata ORDER BY blogTime DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
           
            while($row = $result->fetch_assoc()) {
                echo "<div class='blog-item'>";
                echo "<h2>" . htmlspecialchars($row['blogTitle']) . "</h2>";
                echo "<p class='blog-meta'>By " . htmlspecialchars($row['bloguser']) . " on " . $row['blogTime'] . "</p>";
                echo "<p>" . nl2br(htmlspecialchars($row['blogContent'])) . "</p>";
                echo "<p><i class='bx bxs-like' ></i> : <span id='likes-" . $row['blogId'] . "' >" . $row['likes'] . "</span></p>";
                echo "<form method='post' action=''>"; 
                echo "<input type='hidden' name='blogId' value='" . $row['blogId'] . "'>";
                echo "<button type='submit' name='like' class='like-button' data-toggle='tooltip' title='Like Blog'><i class='bx bx-like'></i></button>";
                echo "</form>";

               
                echo "<button class='comment-button' data-blogid='" . $row['blogId'] . "' data-toggle='tooltip' title='Veiw Comments'><i class='bx bxs-comment'></i></button>";
                echo "<button class='add-comment-button' data-blogid='" . $row['blogId'] . "' data-toggle='tooltip' title='Add Comments'><i class='bx bxs-comment-add'></i></button>";

                
                echo "<div class='comment-section' id='comments-" . $row['blogId'] . "'>";
                echo "<h3>Comments:</h3>";

                $commentSql = "SELECT username, comment, commentTime FROM comments WHERE blogId = " . $row['blogId'];
                $comments = $conn->query($commentSql);
                
                if ($comments->num_rows > 0) {
                    while ($comment = $comments->fetch_assoc()) {
                        echo "<p><strong>" . htmlspecialchars($comment['username']) . ":</strong> " . htmlspecialchars($comment['comment']) . " <em>(" . $comment['commentTime'] . ")</em></p>";
                    }
                } else {
                    echo "<p>No comments yet.</p>";
                }

                
                echo "<form class='comment-form' method='post' action=''>";
                echo "<input type='hidden' name='blogId' value='" . $row['blogId'] . "' required>";
                echo "<input type='text' name='username' placeholder='Your Name' required>";
                echo "<textarea name='comment' placeholder='Your Comment' required></textarea>";
                echo "<button type='submit'>Submit Comment</button>";
                echo "</form>";
                echo "</div>"; 
                echo "</div>";
            }
        } else {
            echo "<p>No blogs found.</p>";
        }

        //$conn->close();
        ?>
    </div>

    <script>
        
        document.querySelectorAll('.comment-button').forEach(button => {
            button.addEventListener('click', () => {
                const blogId = button.getAttribute('data-blogid');
                const commentSection = document.getElementById('comments-' + blogId);
                if (commentSection.style.display === 'none' || commentSection.style.display === '') {
                    commentSection.style.display = 'block';
                    button.innerHTML = '<i class="bx bx-chevron-up"></i>';
                } else {
                    commentSection.style.display = 'none';
                    button.innerHTML = '<i class="bx bxs-comment"></i>';
                }
            });
        });

     
        document.querySelectorAll('.add-comment-button').forEach(button => {
            button.addEventListener('click', () => {
                const blogId = button.getAttribute('data-blogid');
                const commentForm = document.querySelector(`form.comment-form input[name='blogId'][value='${blogId}']`).closest('form');
                if (commentForm.style.display === 'none' || commentForm.style.display === '') {
                    commentForm.style.display = 'flex';
                    button.innerHTML = '<i class="bx bx-chevron-up"></i>';
                } else {
                    commentForm.style.display = 'none';
                    button.innerHTML = '<i class="bx bxs-comment-add"></i>';
                }
            });
        });
    </script>
</body>
</html>

<?php include('footer.php'); ?>
