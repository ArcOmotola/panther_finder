<?php
session_start();
require_once 'include/config/path.php';
require_once ROOT_PATH . 'include/header.php';
require_once ROOT_PATH . 'include/function.php';
$db = new Database();
?>

<body>
    <div class="container-xxl bg-white p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-grow text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <?php include 'include/nav.php'; ?>
        <!-- Navbar & Hero End -->


        <div class="container-xxl bg-primary hero-header">
            <div class="container px-lg-5">
                <div class="row g-5 align-items-end">
                    <div class="col-lg-6 text-center text-lg-start">
                        <h1 class="text-white mb-4 animated slideInDown">Your Campus Lost & Found, Simplified.</h1>
                        <p class="text-white pb-3 animated slideInDown">
                            Panther Finder connects finders and owners through a smart matching system. Report, search, and reclaim your lost items with ease.
                        </p>
                        <a href="login.php" class="btn btn-secondary py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Report Lost Item</a>
                    </div>
                    <div class="col-lg-6 text-center text-lg-start">
                        <img class="img-fluid animated zoomIn" src="assets/img/hero.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <p class="section-title text-secondary justify-content-center">How to report Lost Item</p>
                <div class="row g-4">
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="feature-item bg-light rounded text-center p-4">
                            <i class="fa fa-3x fa-mail-bulk text-primary mb-4"></i>
                            <h5 class="mb-3">Signup</h5>
                            <p class="m-0">Register your account with Panther Finder.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="feature-item bg-light rounded text-center p-4">
                            <i class="fa fa-3x fa-search text-primary mb-4"></i>
                            <h5 class="mb-3">Report Lost Item</h5>
                            <p class="m-0">Login and choose to report your lost item.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="feature-item bg-light rounded text-center p-4">
                            <i class="fa fa-3x fa-thumbs-up text-primary mb-4"></i>
                            <h5 class="mb-3">Wait for report</h5>
                            <p class="m-0">Report to be verified and match with the owner.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->


        <!-- About Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="row g-5 align-items-center">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <p class="section-title text-secondary">About Panther Finder<span></span></p>
                        <h1 class="mb-5">#1 Lost & Found Platform</h1>
                        <p class="mb-4">
                            > Panther Finder is a community-driven lost and found platform that bridges the gap between those who’ve lost valuable items and those who’ve found them. <br>
                            > Our mission is to provide a secure and user-friendly platform for students to report lost items and connect with their lost item owners.
                        </p>
                        <div class="skill mb-4">
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Smart Matching Algorithm</p>
                                <p class="mb-2">85%</p>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill mb-4">
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Secure Report Verification</p>
                                <p class="mb-2">90%</p>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill mb-4">
                            <div class="d-flex justify-content-between">
                                <p class="mb-2">Location-Based Search</p>
                                <p class="mb-2">95%</p>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-dark" role="progressbar" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <a href="login.php" class="btn btn-primary py-sm-3 px-sm-5 rounded-pill mt-3">Read More</a>
                    </div>
                    <div class="col-lg-6">
                        <img class="img-fluid wow zoomIn" data-wow-delay="0.5s" src="assets/img/about.png">
                    </div>
                </div>
            </div>
        </div>
        <!-- About End -->


        <!-- Facts Start -->

        <p class="section-title text-secondary justify-content-center">Recently Reported Items</p>
        <div class="container-xxl bg-primary fact py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.1s">
                        <i class="fa fa-certificate fa-3x text-secondary mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">10</h1>
                        <p class="text-white mb-0">All Reports</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.3s">
                        <i class="fa fa-users-cog fa-3x text-secondary mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">10</h1>
                        <p class="text-white mb-0">Lost Items</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.5s">
                        <i class="fa fa-check fa-3x text-secondary mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">8</h1>
                        <p class="text-white mb-0">Match Reports</p>
                    </div>
                    <div class="col-md-6 col-lg-3 text-center wow fadeIn" data-wow-delay="0.7s">
                        <i class="fa fa-users fa-3x text-secondary mb-3"></i>
                        <h1 class="text-white mb-2" data-toggle="counter-up">2</h1>
                        <p class="text-white mb-0">Pending Reports</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Facts End -->




        <!-- Projects Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <!-- <p class="section-title text-secondary justify-content-center"><span></span>Our Projects<span></span></p> -->
                    <h1 class="text-center mb-5">Recently Reported Items</h1>
                </div>
                <div class="row mt-n2 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="col-12 text-center">

                    </div>
                </div>
                <div class="row g-4 portfolio-container">
                    <div class="col-lg-4 col-md-6 portfolio-item  wow fadeInUp" data-wow-delay="0.1s">
                        <div class="rounded overflow-hidden">
                            <div class="position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="assets/img/iphon3.jpeg" alt="" width="300px" height="400px">
                                <div class="portfolio-overlay">
                                    <a class="btn btn-square btn-outline-light mx-1" href="assets/img/iphon3.jpeg" width="500px" height="400px" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                                    <a class="btn btn-square btn-outline-light mx-1" href=""><i class="fa fa-link"></i></a>
                                </div>
                            </div>
                            <div class="bg-light p-4">
                                <p class="text-primary fw-medium mb-2">Iphone 7 Plus Found</p>
                                <h5 class="lh-base mb-0">Iphone 7 Plus Found at the location of 123, 456, New York, USA</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Projects End -->


        <!-- Testimonial Start -->
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <p class="section-title text-secondary justify-content-center"><span></span>Success Stories<span></span></p>
                <h1 class="text-center mb-5">Real experiences from users who’ve been reunited with their lost items.</h1>
                <div class="owl-carousel testimonial-carousel">
                    <div class="testimonial-item bg-light rounded my-4">
                        <p class="fs-5"><i class="fa fa-quote-left fa-4x text-primary mt-n4 me-3"></i>I found my AirPods within 24 hours of posting! Thanks, Panther Finder.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="assets/img/testimonial-1.jpg" style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">David A</h5>
                                <span>Student</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item bg-light rounded my-4">
                        <p class="fs-5"><i class="fa fa-quote-left fa-4x text-primary mt-n4 me-3"></i>Someone returned my lost wallet after seeing my report. Amazing platform.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="assets/img/testimonial-2.jpg" style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">Omotola A</h5>
                                <span>Student</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Testimonial End -->


        <!-- Team Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <p class="section-title text-secondary justify-content-center"><span></span>Meet the Team Behind Panther Finder<span></span></p>
                    <h1 class="text-center mb-5">Our team is dedicated to building trust, security, and convenience into the lost and found process.</h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="assets/img/team-1.jpg" alt="">
                                <h5>Silva .S</h5>
                                <span>Delivery Man</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="assets/img/team-2.jpg" alt="">
                                <h5>Omotola A</h5>
                                <span>Report Manager</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="team-item bg-light rounded">
                            <div class="text-center border-bottom p-4">
                                <img class="img-fluid rounded-circle mb-4" src="assets/img/team-3.jpg" alt="">
                                <h5>Omotunde</h5>
                                <span>Matching Manager</span>
                            </div>
                            <div class="d-flex justify-content-center p-4">
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Team End -->


        <!-- Footer Start -->
        <?php include 'include/footer.php'; ?>
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>
</body>

</html>