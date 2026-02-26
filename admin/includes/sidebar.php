<?php 
 if (session_status() === PHP_SESSION_NONE) {
    session_start();
 }
 if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    // Handle the case where $id is not set
} // Uncomment this to initialize $id
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@2.1.1/css/boxicons.min.css">
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <?php echo '    
        <li class="nav-item">
            <a class="nav-link collapsed" href="index.php?id=' . $id . '">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

       
           <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#product-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-heart"></i><span>Products</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="product-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="add_product.php?id=<?php echo $id; ?>">
                <i class="bi bi-bell"></i>
                <span>Add Products</span>
            </a>
        </li>
        <li>
            <a href="manage_product.php?id=<?php echo $id; ?>">
                <i class="bi bi-circle"></i><span>Manage Products</span>
            </a>
        </li>
    </ul>
</li>
        <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#blog-nav" data-bs-toggle="collapse" href="#">
       <i class="bx bxl-blogger" ></i><span>Blogs</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="blog-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="admin_add_blog.php?id=<?php echo $id; ?>">
                <i class="bi bi-bell"></i>
                <span>Add Blog</span>
            </a>
        </li>
        <li>
            <a href="manage_blogs.php?id=<?php echo $id; ?>">
                <i class="bi bi-circle"></i><span>Manage Blog</span>
            </a>
        </li>
        <li>
            <a href="admin_comments.php?id=<?php echo $id; ?>">
                <i class="bi bi-circle"></i><span>Manage Comments</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#news-nav" data-bs-toggle="collapse" href="feedback.php">
       <i class="bx bx-news"></i><span>Feedback</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="news-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
        <li class="nav-item">
            <a class="nav-link collapsed" href="admin_add_news.php?id=<?php echo $id; ?>">
                <i class="bi bi-bell"></i>
                <span>Add News</span>
            </a>
        </li>
        <li>
            <a href="manage_news.php?id=<?php echo $id; ?>">
                <i class="bi bi-circle"></i><span>Manage News</span>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item">
<a class="nav-link collapsed" href="admin_orders.php?id=' . $id . '">
    <i class="bi bi-bag-fill"></i>
    <span>Orders</span>
</a>
</li>


        <li class="nav-item">
            <a class="nav-link collapsed" href="settings.php?id=' . $id . '">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>
        </li>';
        ?>
    </ul>
</aside>
