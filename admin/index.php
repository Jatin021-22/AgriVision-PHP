<?php
session_start();

// Include the database connection
$conn = new mysqli('localhost', 'root', '', 'farm');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if delete request is sent
if (isset($_POST['delete_user'])) {
    $user_id = intval($_POST['user_id']);  // Get user ID from POST and ensure it's an integer to prevent SQL injection
    $delete_from = $_POST['delete_from'];  // Determine which table to delete from

    if ($delete_from === 'registration') {
        // Delete the user from the registration table
        $delete_sql = "DELETE FROM registration WHERE id = $user_id";
    } elseif ($delete_from === 'users') {
        // Delete the user from the users table
        $delete_sql = "DELETE FROM users WHERE id = $user_id AND username != 'admin'";
    }

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>alert('User deleted successfully.');</script>";
       // Redirect to avoid form resubmission
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Fetch registered users from the registration table
$registered_sql = "SELECT * FROM registration";
$registered_result = $conn->query($registered_sql);

// Fetch non-admin users from the users table
$non_admin_users_sql = "SELECT * FROM users WHERE username != 'admin'";
$non_admin_users_result = $conn->query($non_admin_users_sql);
?>

<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css">
    <?php include 'includes/sidebar.php'; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.0.9/css/boxicons.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .bx {
            padding: 10px;
        }
        .card-text {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        .btn {
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #007bff;
            color: white;
        }
        .container {
            margin-top: 50px;
        }
        @media (max-width: 768px) {
            .card-title {
                font-size: 1.25rem;
            }
            .card-text {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
<main id="main" class="main">

<div class="pagetitle">
    <h3>Dashboard</h3>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
    </nav>
</div>

<div class="container">
    <h2 class="text-center mb-4">Active  Users</h2>
    <div class="row">
        <?php if ($non_admin_users_result->num_rows > 0): ?>
            <?php while($row = $non_admin_users_result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class='bx bxs-user-circle'></i><?php echo htmlspecialchars($row['username']); ?></h5>
                            <div class="details">
                                <p class="card-text">User ID: <?php echo htmlspecialchars($row['userid']); ?></p>
                                <p class="card-text">Created At: <?php echo htmlspecialchars($row['created_at']); ?></p>
                                <form method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="delete_from" value="users">
                                    <button type="submit" name="delete_user" class="btn btn-danger">Delete User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No users found (excluding Admin).</p>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <h2 class="text-center mb-4">Registered Users</h2>
    <div class="row">
        <?php if ($registered_result->num_rows > 0): ?>
            <?php while($row = $registered_result->fetch_assoc()): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><i class='bx bxs-user-circle'></i><?php echo htmlspecialchars($row['name']); ?></h5>
                            <div class="details">
                                <p class="card-text">Name: <?php echo htmlspecialchars($row['name']); ?></p>
                                <p class="card-text">Email: <?php echo htmlspecialchars($row['email']); ?></p>
                                <p class="card-text">Phone: <?php echo htmlspecialchars($row['phone']); ?></p>
                                <p class="card-text">Address: <?php echo htmlspecialchars($row['address']); ?></p>
                                <p class="card-text">Gender: <?php echo htmlspecialchars($row['gender']); ?></p>
                                <form method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                                    <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="delete_from" value="registration">
                                    <button type="submit" name="delete_user" class="btn btn-danger">Delete User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-center">No registered users found.</p>
        <?php endif; ?>
    </div>
</div>

<script>
function confirmDelete() {
    return confirm('Are you sure you want to delete this user?');
}
</script>

</body>
</html>

<?php
// Close connection
$conn->close();
?>

<?php include('includes/footer.php'); ?>
