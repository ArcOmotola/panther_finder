	<?php
    session_start();
    require_once('../include/config/path.php');
    require_once('includes/head.php');
    require_once(ROOT_PATH . 'include/function.php');
    $db = new Database();

    //items
    $user_sql = "SELECT * 
	FROM users
	 WHERE id = :id LIMIT 1";
    $user = $db->fetch($user_sql, ['id' => $_GET['id']]);

    ?>

	<body>

	    <!-- Main Wrapper -->
	    <div class="main-wrapper">


	        <?php require_once('includes/header.php') ?>

	        <!-- /Header -->

	        <!-- Sidebar -->
	        <?php require_once('includes/sidebar.php') ?>
	        <!-- /Sidebar -->

	        <!-- Page Wrapper -->
	        <div class="page-wrapper">
	            <div class="content container-fluid">

	                <!-- Page Header -->
	                <div class="page-header">
	                    <div class="row">
	                        <div class="col-sm-12">
	                            <h3 class="page-title">User detail</h3>
	                            <ul class="breadcrumb">
	                                <li class="breadcrumb-item active">Lists</li>
	                            </ul>
	                        </div>
	                    </div>
	                </div>
	                <!-- /Page Header -->
	                <div class="row">
	                    <div class="col-md-7 col-lg-8">
	                        <div class="card">
	                            <div class="card-body">

	                                <!-- Checkout Form -->
	                                <form action="../backend/admin/update-user.php?id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">

	                                    <!-- Personal Information -->
	                                    <div class="info-widget">
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

	                                            <h4 class="card-title">User information</h4>
	                                        <?php } ?>
	                                        <div class="row">


	                                            <div class="col-md-6 col-sm-12">
	                                                <div class="form-group card-label">
	                                                    <label>Role</label>
	                                                    <select name="role" id="role" class="form-control" required>
	                                                        <option value="<?= $user['role'] ?> ?>" selected><?= $user['role'] ?></option>
	                                                        <option value="finder">Finder</option>
	                                                        <option value="claimant">Claimant</option>
	                                                    </select>
	                                                </div>
	                                            </div>

	                                            <div class="col-md-6 col-sm-12">
	                                                <div class="form-group card-label">
	                                                    <label>Name</label>
	                                                    <input class="form-control" name="name" type="text" value="<?= $user['name'] ?>" required>
	                                                </div>
	                                            </div>
	                                            <div class="col-md-6 col-sm-12">
	                                                <div class="form-group card-label">
	                                                    <label>Email</label>
	                                                    <textarea class="form-control" name="email" type="text"><?= $user['email']  ?> </textarea>
	                                                </div>
	                                            </div>
	                                            <div class="col-md-6 col-sm-12">
	                                                <div class="form-group card-label">
	                                                    <label>Phone Number</label>
	                                                    <input class="form-control" type="text" required name="phone" value="<?= $user['phone'] ?>">
	                                                </div>
	                                            </div>
	                                            <div class="col-md-6 col-sm-12">
	                                                <div class="form-group card-label">
	                                                    <label>Address</label>
	                                                    <input class="form-control" type="text" required name="address" value="<?= $user['address'] ?>">
	                                                </div>
	                                            </div>
	                                            <div class="col-md-6 col-sm-12">
	                                                <div class="form-group card-label">
	                                                    <label>Status :</label>
	                                                    <a href="#" class="btn btn-lg bg-info-light">
	                                                        <i class=""></i> <?= $user['status'] == 1 ? "Active" : "Inactive" ?>
	                                                    </a>
	                                                </div>

	                                            </div>
	                                        </div>


	                                    </div>

	                                    <!-- /Personal Information -->

	                                    <div class="payment-widget">

	                                        <div class="submit-section mt-4">
	                                            <button type="submit" class="btn btn-primary submit-btn" name="submit">Update</button>
	                                        </div>
	                                        <!-- /Submit Section -->
	                                    </div>
	                                </form>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	        <!-- /Page Wrapper -->

	    </div>
	    <!-- /Main Wrapper -->

	    <!-- jQuery -->
	    <script src="assets/js/jquery-3.2.1.min.js"></script>

	    <!-- Bootstrap Core JS -->
	    <script src="assets/js/popper.min.js"></script>
	    <script src="assets/js/bootstrap.min.js"></script>

	    <!-- Slimscroll JS -->
	    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	    <!-- Datatables JS -->
	    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
	    <script src="assets/plugins/datatables/datatables.min.js"></script>

	    <!-- Custom JS -->
	    <script src="assets/js/script.js"></script>

	</body>

	<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/appointment-list.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:49 GMT -->

	</html>