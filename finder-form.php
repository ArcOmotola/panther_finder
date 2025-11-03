<?php
session_start();
require_once 'include/config/path.php';
require_once ROOT_PATH . 'include/header.php';
require_once ROOT_PATH . 'include/function.php';
$db = new Database();

$categories = 'SELECT name, id FROM categories';
$result_categories = $db->fetchAll($categories);
// var_dump($result_countries);
if (empty($result_categories)) {
    $sql_category = "INSERT INTO categories (name) VALUES('Electronic')";
    $db->execute($sql_category);
}


$colors = 'SELECT name, id FROM colors';
$result_colors = $db->fetchAll($colors);

if (empty($result_colors)) {
    $sql_category = "INSERT INTO colors (name) VALUES ('Black')";
    $db->execute($sql_category);
}
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
                    <h1 class="text-center mb-5">Finder Item Information</h1>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <div class="wow fadeInUp" data-wow-delay="0.3s">
                            <p class="text-center mb-4">Please enter item detail here</p>
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
                            <?php } ?>


                            <form action="backend/finder-form.php" method="post" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="category_id" id="category_id" class="form-control">
                                                <option value="">Item Category</option>
                                                <?php foreach ($result_categories as $categories) { ?> <option value="<?= $categories['id'] ?>"><?= $categories['name'] ?></option> <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select name="color_id" id="color_id" class="form-control">
                                                <option value="">Color</option>
                                                <?php foreach ($result_colors as $colors) { ?> <option value="<?= $colors['id'] ?>"><?= $colors['name'] ?></option> <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" name="item_name" placeholder="Enter your Full name" required>
                                            <label for="name">Item Name</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="address" name="item_address" placeholder="Enter your Address" required>
                                            <label for="name">Location Address</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="phone" name="item_phone" placeholder="Enter your Phone" required>
                                            <label for="name">Phone Number</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="datetime-local" class="form-control" id="time_found" name="time_found" required>
                                            <label for="name">Time found</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <textarea name="description" class="form-control" id=""></textarea>
                                            <label for="name">Description About the Item </label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="file" class="form-control" id="image" name="images[]" accept="image/*" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <!-- <label for="name">Country</label> -->
                                            <select name="visibility" id="visibility" class="form-control" required>
                                                <option value="">Visibility Status</option>
                                                <option value="private">Visible</option>
                                                <option value="public">Anonymous</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3" type="submit" name="submit">Submit</button>
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