<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id = null;

// Check if 'id' is set in POST request
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = intval($_POST['id']);
} 
// Otherwise, check if 'id' is in the URL
elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
} 
// Start the session
?>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Dashboard - AgriVision Growing a Better Tomorrow</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    

    <!-- Favicons -->
    <link href="./assets/img/favicon.png" rel="icon">
    <link href="./assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="./assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="./assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="./assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="./assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="./assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">

</head>
<body>
<div id="preloader">
    <div class="wrapper">
        <div class="cssload-loader"></div>
    </div>
</div>


<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
    <?php echo '    
        <a href="index.php?id=' . $id . '" class="logo d-flex align-items-center">
            <img style="padding-right: 15px;" src="assets/img/logo.png" alt="">
            <span style="font-size:18px;" class="d-none d-lg-block">AgriVision</span>
        </a>
      
        ';?>
    </div>
    
    <div class="d-flex align-items-center justify-content-between">
    <?php
            echo '<div style="display: flex; align-items: center; gap: 15px; margin-left:1000px;">
                   <a href="#"><i class="bx bxs-user-circle" style="font-size: 24px; color: #090909;cursor: pointer;" title="Profile""></i></a>
                  <span style="font-size: 20px; color: #040609;">Admin</span>
                   <a href="includes\logout.php"> <i class="bx bx-log-out" style="font-size: 24px; color: #0b0c0e;cursor: pointer;" title="Log Out""></i></a>
                    </div>';
?>

    </div>
    <!-- End Logo

            <li class="nav-item dropdown pe-3">
  
    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
        <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
        <span class="d-none d-md-block dropdown-toggle ps-2">Admin</span>
    </a>

   
    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
        <li class="dropdown-header">
            <h6>Admin</h6>
            <span>Administrator</span>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        <!-- Profile option 
        <li>
            <a class="dropdown-item d-flex align-items-center" href="profile.php?id=<?php echo $id; ?>">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
            </a>
        </li>
        <li>
            <hr class="dropdown-divider">
        </li>

        
        <li>
            <a class="dropdown-item d-flex align-items-center" href="admin\includes\logout.php">
                <i class="bx bx-log-out"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</li>

         
        </ul>
    </nav><!-- End Icons Navigation -->


</header>

    <!-- Bootstrap and Popper.js (Ensure these are added just before the closing </body> tag) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>