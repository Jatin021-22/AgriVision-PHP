<?php

 if (session_status() == PHP_SESSION_NONE) {
    session_start();
} 

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    $loggedInUsername = $_SESSION['username'];
     // Display username safely
}
 
 // Retrieve the logged-in username from the session
 
// Database connection
$conn = new mysqli('localhost', 'root', '', 'farm'); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Example: After successful login

$user_id = $_SESSION['user_id'] ?? 1; // Default to 1 if user_id is not set in session

// Count the total number of items in the cart for the logged-in user
$sql = "SELECT SUM(quantity) as total_items FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($total_items);
$stmt->fetch();
$stmt->close();


$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel='stylesheet' href='https://unpkg.com/boxicons@latest/css/boxicons.min.css'>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
<!-- Favicon -->
<link rel="icon" type="image/x-icon" href="./img/favicon.png" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Core Stylesheet -->
<link rel="stylesheet" href="./style.css" />
<style>
 .user1 {
    color: #5a9bd4; /* Soft blue for text */
    position: relative; /* For potential pseudo-elements */
    margin-left: 16px; /* Subtle spacing */
    display: inline-flex; /* Flex for alignment */
    align-items: center; /* Vertical centering */
    padding: 6px 12px; /* Compact padding */
    border: 1px solid #e1e8f0; /* Light border */
    border-radius: 24px; /* Smooth rounded corners */
    background: linear-gradient(135deg, #f9fcff, #edf3fa); /* Gradient background */
    transition: all 0.3s ease; /* Smooth transitions */
    font-size: 16px; /* Readable text size */
    font-weight: 500; /* Medium-bold text */
    text-decoration: none; /* No underline */
}

.user1:hover {
    background: linear-gradient(135deg, #e6f0fa, #d9e4f2); /* Hover gradient */
    transform: translateY(-2px); /* Slight lift effect */
    color: #2e7bb8; /* Darker blue on hover */
}

.user-container {
    display: flex; /* Horizontal layout */
    align-items: center; /* Vertical centering */
    gap: 12px; /* Consistent spacing */
}

.user-link {
    color: #2c3e50; /* Neutral dark text */
    font-weight: 600; /* Bold text */
    display: flex; /* Flex for icon alignment */
    align-items: center; /* Center icon and text */
    text-decoration: none; /* No underline */
    transition: color 0.3s ease; /* Smooth color change */
    font-size: 16px; /* Consistent size */
}

.user-link i {
    font-size: 20px; /* Slightly smaller icon */
    margin-right: 6px; /* Tight spacing */
    transition: transform 0.3s ease; /* Smooth icon scaling */
}

.user-link:hover {
    color: #1a73e8; /* Vibrant blue on hover */
}

.user-link:hover i {
    transform: scale(1.1); /* Subtle icon scaling */
}
/* Base Styles */
.logout-link {
    position: relative; /* Needed for tooltip positioning */
    display: inline-flex; /* Align items inline with flexbox */
    align-items: center;
    margin-left:20px; /* Center vertically */
    justify-content: center; /* Center horizontally */
    text-decoration: none; 
    text-shadow:0 4px 8px rgba(242, 177, 177, 0.95);
    /* Remove underline */
    color: #ed5a5a; /* Default icon color */
    transition: color 0.3s ease, transform 0.3s ease; /* Smooth color and transform transitions */
    padding: 10px;

}

/* Icon styles */
.logout-link i {
    font-size: 24px; /* Adjust icon size */
}

/* Hover effects */
.logout-link:hover {
    color: #ff3b3b; /* Change color on hover */
    transform: scale(1.1); /* Slightly enlarge the icon */
}

/* Tooltip Styles */
.logout-link::after {
    content: attr(data-tooltip); /* Show tooltip text */
    position: absolute; /* Positioning relative to the link */
    bottom: -45px; /* Position tooltip below the icon */
    left: 20%; /* Center tooltip horizontally */
    transform: translateX(-50%); /* Center alignment */
    background-color: rgba(236, 71, 71, 0.75);
    box-shadow: 0 4px 8px rgb(244, 15, 15);
     /* Dark background for tooltip */
    color: #fff; /* White text color */
    padding: 5px 10px; /* Padding around tooltip text */
    border-radius: 5px; /* Rounded corners for tooltip */
    font-size: 14px; /* Font size for tooltip */
    opacity: 0; /* Hidden by default */
    visibility: hidden; /* Make it non-interactive when hidden */
    transition: opacity 0.3s ease; 
    z-index: 10;
}

/* Show tooltip on hover */
.logout-link:hover::after {
    opacity: 1; /* Show tooltip on hover */
    visibility: visible; /* Make it interactive */
}

/* Media Queries for Responsive Design */
@media (max-width: 768px) {
    .logout-link i {
        font-size: 20px; /* Smaller icon on smaller screens */
    }
}

@media (max-width: 480px) {
    .logout-link i {
        font-size: 18px; /* Further reduce icon size for mobile */
    }

    .logout-link {
        padding: 8px; /* Reduce padding for smaller screens */
    }

    .logout-link::after {
        font-size: 12px; /* Smaller tooltip font size */
    }
}


   
</style>

</head>
<body>
 

<div id="preloader">
    <div class="wrapper">
        <div class="cssload-loader"></div>
    </div>
</div>

<!-- ***** Top Search Area Start ***** -->
<div class="top-search-area">
    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Close Button -->
                    <button type="button" class="btn close-btn" data-dismiss="modal">
                        <i class="fa fa-times"></i>
                    </button>
                    <!-- Form -->
                    <form action="index.html" method="post">
                        <input type="search" name="top-search-bar" class="form-control"
                            placeholder="Search and hit enter..." />
                        <button type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- ***** Top Search Area End ***** -->

<!---***** Development Notice ***** --->


<header class="header-area">
    <!-- Main Header Start -->
    <div class="main-header-area">
        <div class="classy-nav-container breakpoint-off">
            <!-- Classy Menu -->

            <nav class="classy-navbar justify-content-between" id="uzaNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.php"><img src="./img/core-img/logo.png" alt=""
                        style="width: 70px;margin-top: 20px;" /></a>

                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>

                <!-- Menu -->
                <div class="classy-menu">
                    <!-- Menu Close Button -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap">
                            <span class="top"></span><span class="bottom"></span>
                        </div>
                    </div>

                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul id="nav">
                        <li class="user1" data-toggle="tooltip" title="Profile">
                            <div class="user-container">
                                <a href="userprofile.php" class="user-link">
                                <i class='bx bx-user-circle'></i>
                                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                </a>
                               
                            </div>
                        </li>

                      
                            <li><a href="./index.php">Home</a></li>
                            <li><a href="./about.php" data-toggle="tooltip" title="About Us">About</a></li><!--
                            <li><a href="./weather.php" data-toggle="tooltip" title="View Weather">Weather</a></li>
                          
                            <li><a href="./media.php" data-toggle="tooltip" title="Read News">News</a></li>
                            <li><a href="./display_blogs.php" data-toggle="tooltip" title="Read Blogs">Blogs</a></li>
                            <li><a href="./contact.php" data-toggle="tooltip" title="Contact Us">Contact Us</a></li>-->
                          
                        </ul>

                        <!-- Get A Quote -->
                        <div class="get-a-quote ml-4 mr-3">
                            <a href="product.php" class="btn uza-btn" data-toggle="tooltip" title="Shop">Shop Now</a>
                        </div>

                        <!-- Login / Register -->
                        <div class="login-register-btn mx-3">
                            <a href="cart.php" data-toggle="tooltip" title="View Cart">My Cart <span
                                    class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $total_items ?? 0; ?></span></a>
                            &nbsp;
                            <A href="orders.php" data-toggle="tooltip" title="View Orders">Orders </a>
                            <!--   <a href="#"><i class='bx bx-user-circle'></i><?php echo htmlspecialchars($_SESSION['username']); ?></a>
                               <a href="logout.php"><i class='bx bx-power-off'></i></a>-->
                               
                        </div>
                       <!-- 
                        <div class="search-icon" data-toggle="modal" data-target="#searchModal">
                            <i class="icon_search"></i>
                            
                        </div>-->
                        <div class="logout">
                        <a href="logout.php" class="logout-link" data-tooltip="Logout">
                             <i class='bx bx-power-off'></i>
                        </a>

                        
                        </div>

                    </div>
                    <!-- Nav End -->
                </div>
            </nav>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</header>
</body>
</html> 
<!-- ***** Header Area End ***** -->