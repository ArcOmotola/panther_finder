<?php
session_start();
require_once 'include/config/path.php';
require_once ROOT_PATH . 'include/header.php';
require_once ROOT_PATH . 'include/function.php';
$db = new Database();

$countries = 'SELECT name, id FROM countries';
$result_countries = $db->fetchAll($countries);
// var_dump($result_countries);

if (isset($_GET['error'])) {
    $error_message = $_GET['error'];
}
if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
}
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


        <!-- Contact Start -->
        <div class="container-xxl py-5">
            <div class="container py-5 px-lg-5">
                <div class="wow fadeInUp" data-wow-delay="0.1s">
                    <!-- <p class="section-title text-secondary justify-content-center"><span></span>Contact Us<span></span></p> -->
                    <h1 class="text-center mb-5">Register</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <p class="text-center mb-4">Please enter your detail here</p>
                            <?php
                            if (isset($error_message)) { ?>

                                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                                    <strong>Error!</strong> <?= $error_message ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } elseif (isset($success_message)) { ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">

                                    <strong>Success!</strong><?= $success_message ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php } else { ?>

                                <p class="text-center mb-4">Please enter your detail here</p>


                            <?php } ?>

                            <form action="backend/register.php" method="post">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Full name" required>
                                            <label for="name">FullName</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" required>
                                            <label for="name">Email</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter your Address" required>
                                            <label for="name">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your Phone" required>
                                            <label for="name">Phone</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="country" id="country" class="form-control">
                                                <option value="">Select Country</option>
                                                <?php foreach ($result_countries as $country) { ?> <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option> <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <!-- <label for="name">Country</label> -->
                                            <select name="state" id="state" class="form-control">
                                                <option value="">Select State</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                                            <label for="password">Your Password</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <!-- <label for="name">Country</label> -->
                                            <select name="role" id="role" class="form-control" required>
                                                <option value="" disabled selected>Account Type</option>
                                                <option value="finder">Finder</option>
                                                <option value="loser">Looser</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit" name="submit">Register</button>
                                    </div>
                                    <div class="col-12 text-center">
                                        <a class="btn btn-link" href="register.php">Don't have an account? Register Now</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Contact End -->


        <!-- Footer Start -->
        <?php include 'include/footer.php'; ?>

        <!-- Footer End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-secondary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <?php include 'include/script.php'; ?>
    <!-- <script>
        $(function() {
            // alert("hello")
            $('#country').on('change', function() {
                // alert('hello')
                let country = $(this).find(":selected").val();
                console.log(country);
                if (country == "") {
                    alert('Please select a country')
                } else {
                    let State = $("#state").html(
                        "<option disabled selected> Select a State </option>"
                    );
                    $.ajax({
                        type: "GET",
                        url: "backend/state.php?country_id=" + country,
                        dataType: "JSON",
                        success: function(data) {
                            console.log(data.data);
                            let states = data.data;
                            let state = states.map((items) => {
                                console.log(items);
                                return $("<option></option>")
                                    .val(items.id)
                                    .html(items.name);
                            });
                            State.append(state);
                        },
                        error: function(err) {
                            console.log(err.message);
                        }
                    });
                }

            })
        })
    </script> -->
</body>

</html>