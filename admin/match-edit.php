	<?php
	session_start();
	require_once('../include/config/path.php');
	require_once('includes/head.php');
	require_once(ROOT_PATH . 'include/function.php');
	$db = new Database();

	//items
	$macth_report = "SELECT * 
	FROM finder_claimants
	 WHERE finder_claimants.id = :id LIMIT 1";
	$result_reports = $db->fetch($macth_report, ['id' => $_GET['id']]);


	$sql_pickup = "SELECT * FROM pickup_locations";
	$pickup_locations = $db->fetchAll($sql_pickup);
	// var_dump($result_reports);
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
								<h3 class="page-title">Match Items</h3>
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
									<form action="../backend/admin/update-match.php?id=<?= $_GET['id'] ?>" method="post" enctype="multipart/form-data">

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

												<h4 class="card-title">Finder Report</h4>
											<?php } ?>
											<div class="row">

												<?php
												$sql_finder = "SELECT * FROM finder_reports WHERE id = :id LIMIT 1";
												$finder_result = $db->fetch($sql_finder, ['id' => $result_reports['finder_report_id']]);
												?>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Category</label>
														<select name="country" id="country" class="form-control" required>
															<option value="<?= $finder_result['category_id'] ?>">Select Country</option>

														</select>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Color</label>
														<select name="country" id="country" class="form-control" required>
															<option value="<?= $finder_result['color_id'] ?>">Select Country</option>

														</select>
													</div>
												</div>

												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Title</label>
														<input class="form-control" name="title" type="text" value="<?= $finder_result['title'] ?>" required>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Description</label>
														<textarea class="form-control" name="description" type="text"><?= $finder_result['description']  ?> </textarea>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Date found</label>
														<input class="form-control" type="date" required name="date_found" value="<?= $finder_result['date_found'] ?>">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Time Found</label>
														<input class="form-control" type="time" required name="time_found" value="<?= $finder_result['time_found'] ?>">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Status :</label>
														<a href="#" class="btn btn-lg bg-info-light">
															<i class=""></i> <?= ucfirst($finder_result['status']) ?>
														</a>
													</div>

												</div>

											</div>

											<h4 class="card-title">Claimant Report</h4>
											<div class="row">
												<?php
												$sql_claimant = "SELECT * FROM claimant_reports WHERE id = :id LIMIT 1";
												$claimant_result = $db->fetch($sql_claimant, ['id' => $result_reports['claimant_report_id']]);
												?>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Category</label>
														<select name="country" id="country" class="form-control" required>
															<option value="<?= $claimant_result['category_id'] ?>">Select Country</option>

														</select>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Color</label>
														<select name="country" id="country" class="form-control" required>
															<option value="<?= $claimant_result['color_id'] ?>">Select Country</option>

														</select>
													</div>
												</div>

												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Title</label>
														<input class="form-control" name="title" type="text" value="<?= $claimant_result['title'] ?>" required>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Description</label>
														<textarea class="form-control" name="description" type="text"><?= $claimant_result['description']  ?> </textarea>
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Date found</label>
														<input class="form-control" type="date" required name="date_found" value="<?= $claimant_result['lost_date'] ?>">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Time Found</label>
														<input class="form-control" type="time" required name="time_found" value="<?= $claimant_result['lost_time'] ?>">
													</div>
												</div>
												<div class="col-md-6 col-sm-12">
													<div class="form-group card-label">
														<label>Status :</label>
														<a href="#" class="btn btn-lg bg-info-light">
															<i class=""></i> <?= ucfirst($claimant_result['role']) ?>
														</a>
													</div>

												</div>


											</div>
										</div>

										<!-- /Personal Information -->

										<div class="payment-widget">

											<!-- Terms Accept -->
											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Match Status</label>
													<select name="match_status" id="match_status" class="form-control" required>
														<option value="<?= $result_reports['match_status'] ?>"><?= ucfirst($result_reports['match_status']) ?></option>
														<option value="pending">Pending</option>
														<option value="approved">Approved</option>
														<option value="declined">Declined</option>
													</select>
												</div>
											</div>

											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Pick Up Locations</label>
													<select name="pick_up_locations" id="pick_up_locations" class="form-control" required>
														<option value="" selected>Select a Pick Up Location</option>
														<?php
														foreach ($pickup_locations as $location) {
															echo '<option value="' . $location['id'] . '">' . $location['name'] . '</option>';
														}
														?>

													</select>
												</div>
											</div>

											<div class="col-md-6 col-sm-12">
												<div class="form-group card-label">
													<label>Admin Comment</label>
													<textarea class="form-control" name="admin_comment" type="text"><?= $result_reports['admin_comment']  ?> </textarea>
												</div>
											</div>
											<!-- /Terms Accept -->

											<!-- Submit Section -->
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