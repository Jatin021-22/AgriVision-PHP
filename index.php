<?php 
session_start();
include ('config.php'); 
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login page if no session is active
    exit();
}

// Retrieve the logged-in username from the session
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <meta charset="UTF-8" />
    <meta name="description" content="uza - Model Agency HTML5 Template" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Title -->
    <title>Homepage - AgriVision: Growing a Better Tomorrow</title>
    

</head>

<body>
    <?php include ('header.php'); ?>

    <!-- ***** Welcome Area Start ***** -->
    <section class="welcome-area" style="margin-bottom:60px;">
        <div class="welcome-slides owl-carousel">
            <!-- Single Welcome Slide -->
            <div class="single-welcome-slide">
                <div class="background-curve">
                    <img src="img/bg-img/tomates.png" style="width: auto;padding-top: 300px;padding-right: 50%;">
                </div>
                <!-- Welcome Content -->
                <div class="welcome-content h-100">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <!-- Welcome Text -->
                            <div class="col-12 col-md-6">
                                <div class="welcome-text">
                                    <h2>
                                    AgriVision<br />
                                         <span style="font-size:40px;"> Growing a Better Tomorrow</span>
                                    </h2>
                                    <h5>
                                        From seed to plate, we bring you nature's bounty - freshly picked, packed, and
                                        delivered for your table to enjoy.
                                    </h5>
                                    <a href="about.php" class="btn uza-btn btn-2">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ***** Welcome Area End ***** -->

    <!-- ***** About Us Area Start ***** -->
    <section class="uza-about-us-area">
        <div class="container">
            <div class="row align-items-center">
                <!-- About Thumbnail -->
                <div class="col-12 col-md-6">
                    <div class="about-us-thumbnail mb-80">
                        <img src="img\bg-img\portrait-young-indian-top-manager-t-shirt-tie-crossed-arms-smiling-white-isolated-wall.jpg" alt="" />
                        <!-- Video Area -->
                        <div class="uza-video-area hi-icon-effect-8">
                            <a href="https://youtu.be/SNKWRB1-5pA?si=nJeApLyWdQu5boEt" class="hi-icon video-play-btn"><i
                                    class="fa fa-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                <!-- About Us Content -->
                <div class="col-12 col-md-6">
                    <div class="about-us-content mb-80">
                        <h2>Farmer Friendly Solutions</h2>
                        <p>
                            Our products have a longer shelf life because studies have shown that products grown under
                            green houses retain more nutrients than crops grown under the open sun.
                        </p>
                        <a href="about.php" class="btn uza-btn btn-2 mt-4">Learn More</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Background Pattern -->
        <div class="about-bg-pattern">
            <img src="./img/core-img/curve-2.png" alt="" />
        </div>
    </section>
    <!-- ***** About Us Area End ***** -->


    <!-- ***** Services Area Start ***** -->
    <section class="uza-services-area section-padding-80-0">
        <div class="container">
            <div class="row">
                <!-- Section Heading -->
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Our Services</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Single Service Area -->
                <div class="col-12 col-lg-4">
                    <div class="single-service-area mb-80">
                        <!-- Service Icon -->
                        <div class="service-icon">
                            <i class="icon_cone_alt"></i>
                        </div>
                        <h5>Marketing</h5>
                        <p>
                            At AgriVision we offer marketing services to promote perishable goods and
                            products to attract potential customers.
                        </p>
                    </div>
                </div>

                <!-- Single Service Area -->
                <div class="col-12 col-lg-4">
                    <div class="single-service-area mb-80">
                        <!-- Service Icon -->
                        <div class="service-icon">
                            <i class="icon_piechart"></i>
                        </div>
                        <h5>Sales</h5>
                        <p>
                            We also sell perishable goods directly to customers or to retailers, wholesalers, or
                            distributors.
                        </p>
                    </div>
                </div>

                <!-- Single Service Area -->
                <div class="col-12 col-lg-4">
                    <div class="single-service-area mb-80">
                        <!-- Service Icon -->
                        <div class="service-icon">
                            <i class="icon_easel"></i>
                        </div>
                        <h5>Core Farming</h5>
                        <p>
                            Our wide range of services includes Harvesting, Sorting, Packaging, Transportation, Quality
                            control, and General Sales.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
   

   

    

        <!-- ***** Client Feedback Area Start ***** -->
        <div class="clients-feedback-area section-padding-0-80 clearfix" style="margin-top:60px;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Testimonial Slides -->
                        <div class="testimonial-slides owl-carousel">

                            <!-- Single Testimonial Slide -->
                            <div class="single-testimonial-slide d-flex align-items-center">
                                <!-- Testimonial Thumbnail -->
                                <div class="testimonial-thumbnail">
                                    <img src="img\bg-img\Screenshot 2024-10-08 163728.png" alt="">
                                </div>
                                <!-- Testimonial Content -->
                                <div class="testimonial-content">
                                    <h4>“The farmer is the only man in our economy who buys everything at retail, sells everything at wholesale, and pays the freight both ways.”</h4>
                                    <!-- Ratings -->
                                    <div class="ratings">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                    </div>
                                    <!-- Author Info -->
                                    <div class="author-info">
                                        <h5>john f. Kennedy <span>- President of America</span></h5>
                                    </div>
                                    <!-- Quote Icon -->
                                    <div class="quote-icon"><img src="img/core-img/quote.png" alt=""></div>
                                </div>
                            </div>

                            <!-- Single Testimonial Slide -->
                            <div class="single-testimonial-slide d-flex align-items-center">
                                <!-- Testimonial Thumbnail -->
                                <div class="testimonial-thumbnail">
                                    <img src="img\bg-img\Screenshot 2024-10-08 163927.png" alt="">
                                </div>
                                <!-- Testimonial Content -->
                                <div class="testimonial-content">
                                    <h4>“Our farmers are pride of our nation.”</h4>
                                    <!-- Ratings -->
                                    <div class="ratings">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                    </div>
                                    <!-- Author Info -->
                                    <div class="author-info">
                                        <h5>Narendra Modi <span>- President Of India</span></h5>
                                    </div>
                                    <!-- Quote Icon -->
                                    <div class="quote-icon"><img src="img/core-img/quote.png" alt=""></div>
                                </div>
                            </div>

                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="container">
            <div class="border-line"></div>
        </div>

        
   




    <?php include ('footer.php'); ?>
</body>

</html>