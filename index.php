<?php
session_start();
require_once 'include/config/path.php';
require_once ROOT_PATH . 'include/header.php';
require_once ROOT_PATH . 'include/function.php';
$db = new Database();
//Check if admin have data
$admin = 'SELECT * FROM admins';
$result_admin = $db->fetchAll($admin);

if (empty($result_admin)) {
    $sql = "INSERT INTO admins (email, password) VALUES ('admin@test.com', '" . md5('0987654321') . "')";
    $db->execute($sql);
}

$colors = 'SELECT name, id FROM colors';
$result_colors = $db->fetchAll($colors);

if (empty($result_colors)) {
    $colors = [
        [
            'name' => 'Black',
        ],
        [
            'name' => 'Blue',
        ],
        [
            'name' => 'Green',
        ],
        [
            'name' => 'Orange',
        ],
        [
            'name' => 'Brown',
        ],
        [
            'name' => 'Red',
        ],
        [
            'name' => 'Pink',
        ],
        [
            'name' => 'Purple',
        ],
        [
            'name' => 'White',
        ],
        [
            'name' => 'Yelloe',
        ],
        [
            'name' => 'Gray',
        ],
        [
            'name' => 'Cyan',
        ],
    ];
    foreach ($colors as $color) {
        $sql_category = "INSERT INTO colors (name) VALUES (:name)";
        $params = [
            'name' => $color['name'],
        ];
        $db->execute($sql_category, $params);
    }
}


$categories = [
    [
        'name' => 'Phone',
    ],
    [
        'name' => 'Bag',
    ],
    [
        'name' => 'Pen',
    ],
    [
        'name' => 'Laptop',
    ],
    [
        'name' => 'AirPod',
    ],
    [
        'name' => 'Ring',
    ],
    [
        'name' => 'Book',
    ],
    [
        'name' => 'Camera',
    ],
    [
        'name' => 'Clothes',
    ],
    [
        'name' => 'Shoes',
    ],
    [
        'name' => 'Pants',
    ],
    [
        'name' => 'Other',
    ],
];
$category = 'SELECT name, id FROM categories';
$result_categories = $db->fetchAll($category);
if (empty($result_categories)) {

    foreach ($categories as $category) {
        $sql_category = "INSERT INTO categories (name) VALUES(:name)";
        $params = [
            'name' => $category['name'],
        ];
        $db->execute($sql_category, $params);
    }
}


$finder_reports = "SELECT categories.name as category_name, colors.name as color_name, users.name as user_name, finder_reports.* FROM finder_reports 
	JOIN categories ON categories.id = finder_reports.category_id
	JOIN colors ON colors.id = finder_reports.color_id
	JOIN users ON users.id = finder_reports.user_id
    WHERE finder_reports.status = 'pending' order by created_at desc";
$result_finder_reports = $db->fetchAll($finder_reports);

//Search result
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $finder_reports = "SELECT categories.name as category_name, colors.name as color_name, users.name as user_name, finder_reports.* FROM finder_reports 
    JOIN categories ON categories.id = finder_reports.category_id
    JOIN colors ON colors.id = finder_reports.color_id
    JOIN users ON users.id = finder_reports.user_id WHERE title LIKE '%$search%' OR finder_reports.description LIKE '%$search%' order by created_at desc";
    $result_finder_reports = $db->fetchAll($finder_reports);
}
?>

<body>
    <style>
        .blur-image {
            filter: blur(60px);
            /* Applies a 5-pixel Gaussian blur */
            -webkit-filter: blur(60px);
            /* For compatibility with older WebKit browsers */
        }
    </style>
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
                        <?php
                        if (isset($_SESSION['role'])) {
                            if ($_SESSION['role'] == 'finder') {
                                echo '<a href="project.php" class="btn btn-secondary py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Report Lost Item</a>';
                            } else {
                                echo '<a href="index.php" class="btn btn-secondary py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Claim Item</a>';
                            }
                        } else {
                            echo '<a href="login.php" class="btn btn-secondary py-sm-3 px-sm-5 rounded-pill me-3 animated slideInLeft">Get Started</a>';
                        }
                        ?>
                    </div>
                    <?php
                    if (isset($_SESSION['id']) && isset($_SESSION['role'])) {

                        if ($_SESSION['role'] == 'finder') {
                            # code...
                            echo '<div class="col-lg-6 text-center text-lg-start">
                                            <img class="img-fluid animated zoomIn" src="assets/img/lost-report.png" alt="">
                                        </div>';
                        } else {
                            echo '<div class="col-lg-6 text-center text-lg-start">
                                            <img class="img-fluid animated zoomIn" src="assets/img/claim.png" alt="">
                                        </div>';
                        }
                    } else {
                        echo '<div class="col-lg-6 text-center text-lg-start">
                                        <img class="img-fluid animated zoomIn" src="assets/img/hero.png" alt="">
                                    </div>';
                    }
                    ?>
                    <!-- <div class="col-lg-6 text-center text-lg-start">
                        <img class="img-fluid animated zoomIn" src="assets/img/hero.png" alt="">
                    </div> -->
                </div>
            </div>
        </div>
        <!-- Feature Start -->

        <?php
        if (isset($_SESSION['id']) && isset($_SESSION['role']) && $_SESSION['role'] == "claimant") { ?>
            <div class="container-xxl py-5">
                <div class="container py-5 px-lg-5">
                    <p class="section-title text-secondary justify-content-center">Lost Item reports</p>
                    <br>
                    <div class="row g-4">
                        <form action="index.php" method="get">
                            <input type="text" name="search" placeholder="Search" class="form-control">
                        </form>
                    </div>
                    <br>
                    <br>
                    <div class="row g-4">
                        <?php
                        if (!empty($result_finder_reports)) {
                            foreach ($result_finder_reports as $result) { ?>

                                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                                    <div class="feature-item bg-light rounded text-center p-4">
                                        <a href="claimant-form.php?id=<?= $result['id']  ?>">
                                            <img class="img-fluid w-100 blur-image" src="<?= $result['image']  ?>" alt="" width="300px" height="400px">
                                        </a>
                                        <!-- <i class="fa fa-3x fa-mail-bulk text-primary mb-4"></i> -->
                                        <h5 class="mb-3"><?= $result['title']  ?></h5>
                                        <a href=" claimant-form.php?id=<?= $result['id'] ?>" class=" btn btn-secondary py-sm-3 px-sm-5 rounded-pill me-3">View details</a>
                                    </div>
                                </div>
                            <?php }  ?>
                        <?php }
                        ?>

                    </div>
                </div>
            </div>
        <?php }
        ?>

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


        <!-- Facts End -->






        <!-- Testimonial Start -->
        <div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="container py-5 px-lg-5">
                <p class="section-title text-secondary justify-content-center"><span></span>Success Stories<span></span></p>
                <h1 class="text-center mb-5">Real experiences from users who’ve been reunited with their lost items.</h1>
                <div class="owl-carousel testimonial-carousel">
                    <div class="testimonial-item bg-light rounded my-4">
                        <p class="fs-5"><i class="fa fa-quote-left fa-4x text-primary mt-n4 me-3"></i>I found my AirPods within 24 hours of posting! Thanks, Panther Finder.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="assets/img/salv.jpeg" style="width: 65px; height: 65px;">
                            <div class="ps-4">
                                <h5 class="mb-1">David A</h5>
                                <span>Student</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-item bg-light rounded my-4">
                        <p class="fs-5"><i class="fa fa-quote-left fa-4x text-primary mt-n4 me-3"></i>Someone returned my lost wallet after seeing my report. Amazing platform.</p>
                        <div class="d-flex align-items-center">
                            <img class="img-fluid flex-shrink-0 rounded-circle" src="assets/img/omoto.jpeg" style="width: 65px; height: 65px;">
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
                                <img class="img-fluid rounded-circle mb-4" src="assets/img/salv.jpeg" alt="">
                                <h5>Silva .S</h5>
                                <span>Locker Admin</span>
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
                                <img class="img-fluid rounded-circle mb-4" src="assets/img/omotoal.jpeg" alt="">
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
                                <img class="img-fluid rounded-circle mb-4" src="assets/img/omoto.jpeg" alt="">
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
        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="text-center mb-5">🔎 Finder Flow (You found an item)</h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-search fa-2x"></i>
                            </div>
                            <h5 class="mb-3">SIGN UP / LOG IN</h5>
                            <p class="m-0">Create an account or log in to get started.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-laptop-code fa-2x"></i>
                            </div>
                            <h5 class="mb-3">SUBMIT LOST ITEM</h5>
                            <p class="m-0">Complete the *Lost Item Form* with key details and photos.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fab fa-facebook-f fa-2x"></i>
                            </div>
                            <h5 class="mb-3">RECEIVE SUBMISSION UPDATE</h5>
                            <p class="m-0">Get notified as claims come in and when the admin updates the case.
                                If a claim is approved after review, the *Finder* sees the final status.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->
        <!-- Service Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="text-center mb-5"> Claimant Flow (You lost an item)</h1>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-search fa-2x"></i>
                            </div>
                            <h5 class="mb-3">SIGN UP / LOG IN</h5>
                            <p class="m-0">Create an account or log in to continue.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fa fa-laptop-code fa-2x"></i>
                            </div>
                            <h5 class="mb-3">SUBMIT LOST ITEM</h5>
                            <p class="m-0">Complete the *Lost Item Form* with key details and photos.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item d-flex flex-column text-center rounded">
                            <div class="service-icon flex-shrink-0">
                                <i class="fab fa-facebook-f fa-2x"></i>
                            </div>
                            <h5 class="mb-3">RECEIVE SUBMISSION UPDATE</h5>
                            <p class="m-0">Get notified as claims come in and when the admin updates the case.
                                If a claim is approved after review, the *Finder* sees the final status.</p>
                            <a class="btn btn-square" href=""><i class="fa fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->

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