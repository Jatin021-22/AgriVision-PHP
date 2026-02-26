<?php
// Start session
session_start();

// Include the database connection file
$conn = new mysqli('localhost', 'root', '', 'farm');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get the logged-in user's information
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT userid, username, created_at FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Update user profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = $_POST['username'];

    // Update the username in the database
    $updateStmt = $conn->prepare("UPDATE users SET username = ? WHERE userid = ?");
    $updateStmt->bind_param("si", $newUsername, $user['userid']);
    $updateStmt->execute();

    // Update session variable
    $_SESSION['username'] = $newUsername;

    // Redirect to the same page to see updated username
    header("Location: userprofile.php");
    exit();
}

// Close the statement
$stmt->close();
?>
<?php //include 'header.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - AgriVision</title>
    <link rel='stylesheet' href='https://unpkg.com/boxicons@latest/css/boxicons.min.css'>
    <style>
        body {
    font-family: 'Arial', sans-serif;
 
}

.container1 {
    max-width: 600px;
    margin-top:;
    margin-left:530px;
    margin-bottom:50px;
  
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

   .profile-card h2, 
        .profile-card p,h1 {
            opacity: 0; /* Start as invisible */
            transform: translateY(20px); /* Start slightly lower */
            animation: fadeInUp 0.6s forwards; /* Apply the animation */
        }
        .profile-card h2 {
            animation-delay: 0.2s; /* Delay for heading */
        }

        .profile-card p:nth-of-type(1) {
            animation-delay: 0.4s; /* Delay for first paragraph */
        }

        .profile-card p:nth-of-type(2) {
            animation-delay: 0.6s; /* Delay for second paragraph */
        }

.profile-card {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background: #ffffff;
    transition: transform 0.2s, box-shadow 0.2s;
}

.profile-card:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}


input[type="text"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border 0.3s;
}

input[type="text"]:focus {
    border-color: #007bff;
}

.btn8 {
    display: inline-block;
    padding: 10px 15px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: background 0.3s;
    margin-top: 20px;
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
                    <h4 style="font-size:40px;color:#5eb4ee;">User Profile </h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">User Profile </li>
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
        
        <div class="profile-card">
            <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>
            <p><strong>User ID:</strong> <?php echo $user['userid']; ?></p>
            <p><strong>Account Created:</strong> <?php echo $user['created_at']; ?></p>
            
            <form method="POST" action="">
                <button type="submit" class="btn8" data-toggle="tooltip" title="Update Profile"><a href="updateuserprofile.php">Update Profile</a></button>
            </form>
        </div>
       
    </div>
</body>
</html>
<?php include 'footer.php';?>

