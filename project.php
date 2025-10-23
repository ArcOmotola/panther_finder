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


        <!-- Projects Start -->

        <div class=" container-xxl py-5">
            <div class="container py-5 px-lg-5">

                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <h4>Do you have find something?</h4>
                    <a href="report.php" class="btn btn-primary" type="button">Report Lost Item</a>
                    <p class="section-title text-secondary justify-content-center"><span></span>My Peports<span></span></p>
                    <h1 class="text-center mb-5">Recently Reported Items</h1>
                </div>

                <div class="row g-4 portfolio-container">
                    <div class="col-lg-4 col-md-6 portfolio-item  wow fadeInUp" data-wow-delay="0.1s">
                        <div class="rounded overflow-hidden">
                            <div class="position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="img/portfolio-1.jpg" alt="">
                                <div class="portfolio-overlay">
                                    <a class="btn btn-square btn-outline-light mx-1" href="assets/img/portfolio-1.jpg" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
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


        <!-- Footer Start -->
        <!-- Footer Start -->
        <?php include 'include/footer.php'; ?>
        <!-- Footer End -->
        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <?php include 'include/script.php'; ?>

</body>

</html>