	<?php
	session_start();
	require_once('../include/config/path.php');
	require_once('includes/head.php');
	require_once(ROOT_PATH . 'include/function.php');
	$db = new Database();

	//items

	$finder_reports = "SELECT categories.name as category_name, colors.name as color_name, users.name as user_name, claimant_reports.* FROM claimant_reports 
	JOIN categories ON categories.id = claimant_reports.category_id
	JOIN colors ON colors.id = claimant_reports.color_id
	JOIN users ON users.id = claimant_reports.user_id
	order by created_at desc";
	$result_finder_reports = $db->fetchAll($finder_reports);
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
								<h3 class="page-title">Claimant Report</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Lists</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->
					<div class="row">
						<div class="col-md-12">

							<!-- Recent Orders -->
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>S/N</th>
													<th>User</th>
													<th>Title</th>
													<th>Description</th>
													<th>Image</th>
													<th class="">Phone Number</th>
													<th class="">Category</th>
													<th class="">Color</th>
													<th>Submited Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$num = 0;
												foreach ($result_finder_reports as $items) {
													$num++;
												?>
													<tr>
														<td><?= $num ?></td>
														<td>
															<h2 class="table-avatar">
																<a href="#"><?= $items['user_name'] ?></a>
															</h2>
														</td>
														<td><?= $items['title'] ?></td>
														<td><?= strlen($items['description']) > 50 ? substr($items['description'], 0, 50) . '...' : $items['description'] ?></td>

														<td><img src="../<?= $items['image'] ?>" width="50px" height="50px" alt="" class="rounded" srcset=""></td>

														<td><?= $items['phone'] ?></td>
														<td><?= $items['category_name'] ?></td>
														<td class="text-right">
															<?= $items['color_name'] ?>
														</td>
														<td class="text-right">
															<?= $items['created_at'] ?>
														</td>
														<td class="text-right">
															<div class="actions">
																<a class="btn btn-sm bg-info-light" href="#">
																	<i class="fe fe-eye"></i> View
																</a>

																<a href="../backend/admin/delete_claimant_report.php?id=<?= $items['id'] ?>" class="btn btn-sm bg-danger-light">
																	<i class="fe fe-trash"></i> Delete
																</a>
															</div>
														</td>
													</tr>
												<?php } ?>

											</tbody>
										</table>
									</div>
								</div>
							</div>
							<!-- /Recent Orders -->

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