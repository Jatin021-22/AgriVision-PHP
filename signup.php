<?php
// Start session
session_start();

// Include the database connection file
$conn = new mysqli('localhost', 'root', '', 'farm');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the registration form is submitted
if (isset($_POST['register'])) {
    // Get form inputs
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];

    // Validate password (must be at least 6 characters long)
    if (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long.";
    }
    // Validate confirm password
    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }
    // Validate pincode (must be 6 digits)
    elseif (!preg_match('/^\d{6}$/', $pincode)) {
        $error = "Pincode must be exactly 6 digits.";
    }
    // Validate phone number (must be 10 digits)
    elseif (!preg_match('/^\d{10}$/', $phone)) {
        $error = "Phone number must be exactly 10 digits.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the registration table
        $stmt = $conn->prepare("INSERT INTO registration (name, username, password, email, address, pincode, phone, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $name, $username, $hashed_password, $email, $address, $pincode, $phone, $gender);

        if ($stmt->execute()) {
            // Get the last inserted id from registration table for reference
            $last_id = $stmt->insert_id;

            // Insert the username and hashed password into the users table
            $stmt_users = $conn->prepare("INSERT INTO users (userid, username, password) VALUES (?, ?, ?)");
            $stmt_users->bind_param("iss", $last_id, $username, $hashed_password);

            if ($stmt_users->execute()) {
                echo "Registration successful! User details stored in users table.";
            } else {
                echo "Error storing user details in users table: " . $stmt_users->error;
            }

            $stmt_users->close(); // Close users statement
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close(); // Close registration statement
    }
    $conn->close(); // Close database connection
}
?>


<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Register - AgriVision</title>

    <link rel="stylesheet" href="./admin/store-assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="./admin/store-assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="./admin/store-assets/css/demo.css" />
    <link rel="stylesheet" href="./admin/store-assets/vendor/css/pages/page-auth.css" />
</head>
<body>
<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card">
                <div class="card-body">
                    <div class="app-brand justify-content-center">
                        <a href="index.php" class="app-brand-link gap-2">
                            <span class="app-brand-logo demo">
                                <img src="./img/logo.png" style="width:50px;" alt="">
                            </span>
                            <span class="app-brand-text demo text-body fw-bolder">AgriVision</span>
                        </a>
                    </div>
                    <h4 class="mb-2">Welcome to Our Website! 👋</h4>
                    <h4 class="mb-2">Create a New Account</h4>
                    <p class="mb-4">Please fill in the details below to register.</p>

                    <form id="formRegistration" class="mb-3" action="" method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" required />
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Choose a username" required />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required />
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required />
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address" />
                        </div>
                        <div class="mb-3">
                            <label for="pincode" class="form-label">Pincode</label>
                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter your pincode" required />
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required />
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <!-- Error message section -->
                        <?php if (isset($error) && !empty($error)): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit" name="register">Register</button>
                        </div>
                    </form>

                    <p class="text-center">
                        <span>Already have an account?</span>
                        <a href="login.php"><span>Sign in</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
