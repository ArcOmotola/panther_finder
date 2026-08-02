<?php
session_start();
require_once 'include/config/path.php';
require_once ROOT_PATH . 'include/header.php';
require_once ROOT_PATH . 'include/function.php';
$db = new Database();

$user = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}
if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}

$projects = 'SELECT pickup_locations.name as pickup_name, claimant_reports.* FROM claimant_reports 
JOIN pickup_locations ON pickup_locations.id = claimant_reports.pick_up_id WHERE user_id = :user_id
ORDER BY created_at DESC';
$result_projects = $db->fetchAll($projects, ['user_id' => $user]);
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
                    <h4>Did you lose something?</h4>
                    <a href="index.php" class="btn btn-primary" type="button">Check Lost Item report</a>
                    <p class="section-title text-secondary justify-content-center"><span></span>My Claims<span></span></p>
                    <h1 class="text-center mb-5">Recently Claimed Items</h1>
                </div>

                <div class="row g-4 portfolio-container">
                    <?php if (empty($result_projects)) {
                        echo "No Data";
                    } else {
                        foreach ($result_projects as $project) { ?>
                            <br>
                            <div class="col-lg-4 col-md-6 portfolio-item  wow fadeInUp" data-wow-delay="0.1s">
                                <div class="rounded overflow-hidden">
                                    <div class="position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="<?= $project['image'] ?>" alt="">
                                        <div class="portfolio-overlay">
                                            <a class="btn btn-square btn-outline-light mx-1" href="<?= $project['image'] ?>" data-lightbox="portfolio"><i class="fa fa-eye"></i></a>
                                            <!-- <a class="btn btn-square btn-outline-light mx-1" href=""><i class="fa fa-link"></i></a> -->
                                        </div>
                                    </div>
                                    <div class="bg-light p-4">
                                        <p class="text-primary fw-medium mb-2"><?= $project['title'] ?></p>
                                        <h5 class="lh-base mb-0"><?= $project['description'] ?></a>
                                        </h5>
                                        <a type="button" class="btn <?= $project['role'] == "delivered" ? "btn-success" : "btn-warning" ?> btn-lg" href="finder-form.php?id=<?= $project['id'] ?>">
                                            <?= $project['role'] == "delivered" ? "Claimed" : $project['role'] ?>
                                        </a>
                                        <?php
                                        // var_dump($project);
                                        if ($project['role'] == "delivered") {
                                            //check Claimant code
                                            $finder_claimant = "SELECT * FROM finder_claimants WHERE claimant_report_id = :id LIMIT 1";
                                            $result_finder_claimant = $db->fetch($finder_claimant, ['id' => $project['id']]);
                                            if (!empty($result_finder_claimant)) {
                                                $claimant_code = $result_finder_claimant['smart_pin'];
                                                $match_percentage = $result_finder_claimant['match_percentage'];
                                                echo "<p class='text-primary fw-medium mb-2'>Claimant Code: " . $claimant_code . "</p>";
                                                echo "<p class='text-primary fw-medium mb-2'>Match Percentage: " . $match_percentage . "%</p>";
                                                echo "<p class='text-primary fw-medium mb-2'>Pickup Location: " . $project['pickup_name'] . "</p>";
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                </div>
            </div>
        </div>
        <br>
        <br>
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