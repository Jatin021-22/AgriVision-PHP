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
    header("Location: login.php"); // Redirect to login page if no session is active
    exit();
}

// Retrieve the logged-in username from the session
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT userid, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$successMessage = "";
$error = "";

// Update user profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture old password and new inputs
    $oldPassword = $_POST['old_password'];
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];
    
    // Check if the old password is correct
    if (password_verify($oldPassword, $user['password'])) {
        // Update the username in the database if provided
        if (!empty($newUsername)) {
            $updateStmt = $conn->prepare("UPDATE users SET username = ? WHERE userid = ?");
            $updateStmt->bind_param("si", $newUsername, $user['userid']);
            $updateStmt->execute();
            $_SESSION['username'] = $newUsername; // Update session variable
        }

        // Update the password if provided
        if (!empty($newPassword)) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordStmt = $conn->prepare("UPDATE users SET password = ? WHERE userid = ?");
            $updatePasswordStmt->bind_param("si", $hashedPassword, $user['userid']);
            $updatePasswordStmt->execute();
        }

     
        $successMessage = "Profile updated successfully!";
        
    } else {
        $error = "Old password is incorrect. Please try again.";
    }
}

// Delete user account
if (isset($_POST['delete'])) {
    // Capture password for account deletion
    $deletePassword = $_POST['delete_password'];

    // Check if the provided password matches the stored password
    if (password_verify($deletePassword, $user['password'])) {
        $deleteStmt = $conn->prepare("DELETE FROM users WHERE userid = ?");
        $deleteStmt->bind_param("i", $user['userid']);
        $deleteStmt->execute();
        session_destroy(); // Destroy session
        header("Location: signup.php"); // Redirect to signup or homepage
        exit();
    } else {
        $deleteError = "Password is incorrect. Unable to delete account.";
    }
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
    <title>Update User Profile - Green and Stretch Farms</title>
    <link rel='stylesheet' href='https://unpkg.com/boxicons@latest/css/boxicons.min.css'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

    <style>
        body {
    font-family: 'Arial', sans-serif;
    
   
}

.container1 {
    max-width: 1300px;
    margin-left:140px;
    margin-bottom:50px;
    margin-top: ;
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(13, 140, 238, 0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
}

.profile-card {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background: #ffffff;
    transition: transform 0.2s, box-shadow 0.2s;
}

.profile-card h2, 
        .profile-card p,
        .profile-card label,
        .profile-card input,
        h1 {
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
.profile-card:hover {
    transform: translateY(-10px);
    box-shadow: 0px 4px 16px rgb(150, 197, 244);
}

.form-group {
    margin-bottom: 15px;
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    transition: border 0.3s;
}

input[type="text"]:focus,
input[type="password"]:focus {
    border-color: #007bff;
}

.btn8 {
    display: inline-block;
    margin-top:10px;
    margin-bottom:10px;
    padding: 10px 15px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 20px;
    cursor: pointer;
    transition: background 0.3s;
}

.btn8:hover {
    background: #0056b3;
}

.btn8-danger {
    background: #e74c3c;
}

.btn8-danger:hover {
    background: #c0392b;
}

[data-tooltip] {
    position: relative;
}

[data-tooltip]:hover:before {
    content: attr(data-tooltip);
    position: absolute;
    bottom: 100%; /* Position above the element */
    left: 50%;
    transform: translateX(-50%);
    background-color: black;
    color: white;
    padding: 5px;
    border-radius: 4px;
    white-space: nowrap;
    z-index: 10;
    opacity: 0.8;
}
.popup {
            display: none;
            position: fixed;
            top: 18%;          /* Center vertically */
            left: 18%;         /* Center horizontally */
            transform: translate(-50%, -50%);
            background-color: #0f7deb; /* Green background */
            color: #f4ebeb;
            padding: 15px;
            border-radius: 30px;
            box-shadow: 0 4px 8px rgb(66, 5, 251);
            z-index: 1000;
            animation: slideIn 1s forwards, fadeOut 2.5s forwards 3.5s; /* Animation for slide in and fade out */
        }
        .bi{
            text-shadow:0 4px 8px rgb(248, 121, 121);
            margin-right:9px;
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
            }
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
                    <h4 style="font-size:40px;color:#5eb4ee;">Update Profile</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Update profile </li>
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
        <!--<h1>Update User Profile</h1>-->
        <div class="profile-card">
            <h2>Welcome, <?php echo htmlspecialchars($user['username']); ?></h2>

            <?php if (isset($error)): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="old_password">Enter Old Password:</label>
                    <input type="password" id="old_password" name="old_password" required>
                </div>
                <div class="form-group">
                    <label for="username">Update Username:</label>
                    <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Update Password:</label>
                    <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
                </div>
                <button type="submit" class="btn8" data-toggle="tooltip" title="Update Profile"><i class="bi bi-person-plus-fill"></i>Update Profile</button>
            </form>

            <form method="POST" action="" class="delete-account-form">
                <h3>Delete Account</h3>
                <p>Are you sure you want to delete your account? This action cannot be undone.</p>
                <label for="delete_password">Enter Your Password:</label>
                <input type="password" id="delete_password" name="delete_password" required>
                <?php if (isset($deleteError)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($deleteError); ?></div>
                <?php endif; ?>
                <button type="submit" name="delete" class="btn8 btn-danger"data-toggle="tooltip" title="Delete Account "><i class="bi bi-person-x-fill"></i>Delete Account</button>
            </form>
        </div>
         <!-- Popup for successful update -->
         <?php if ($successMessage): ?>
            <div class="popup" id="successPopup">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        <?php endif; ?>
     
    </div>
    <script>
        // Show popup if there's a success message
        window.onload = function() {
            const popup = document.getElementById('successPopup');
            if (popup) {
                popup.style.display = 'block'; // Show the popup
            }
        };
    </script>
</body>
</html>
<?php include 'footer.php';?>