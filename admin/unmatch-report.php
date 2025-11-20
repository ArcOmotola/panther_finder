	<?php
	session_start();
	require_once('../include/config/path.php');
	require_once('includes/head.php');
	require_once(ROOT_PATH . 'include/function.php');
	$db = new Database();

	//items
	$macth_report = "SELECT finder_reports.id, finder_reports.title as finder_title, claimant_reports.id, claimant_reports.title as claimant_title, finder_claimants.* 
	FROM finder_claimants
	JOIN finder_reports ON finder_reports.id = finder_claimants.finder_report_id
	JOIN claimant_reports ON claimant_reports.id = finder_claimants.claimant_report_id
	WHERE match_status != 'approved' order by created_at desc";
	$result_reports = $db->fetchAll($macth_report);
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
						<div class="col-md-12">

							<!-- Recent Orders -->
							<div class="card">
								<div class="card-body">
									<div class="table-responsive">
										<table class="datatable table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>S/N</th>
													<th>Finder Report</th>
													<th>Claimant</th>
													<th>Match Percentage</th>
													<th>Admin Comment</th>
													<th class="">Pick Up Pin</th>
													<th>Status</th>
													<th>Submited Date</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$num = 0;
												foreach ($result_reports as $items) {
													$num++;
												?>
													<tr>
														<td><?= $num ?></td>
														<td>
															<h2 class="table-avatar">
																<a href="#"><?= $items['finder_title'] ?></a>
															</h2>
														</td>
														<td><?= $items['claimant_title'] ?></td>
														<td><?= $items['match_percentage'] ?></td>
														<td><?= $items['admin_comment'] ?? 'Nothing yet' ?></td>
														<td><?= $items['smart_pin'] ?></td>
														<td><?= $items['match_status'] ?></td>

														<td class="text-right">
															<?= $items['created_at'] ?>
														</td>
														<td class="text-right">
															<div class="actions">
																<a class="btn btn-sm bg-success-light" href="match-edit.php?id=<?= $items['id'] ?>">
																	<i class="fe fe-pencil"></i> Edit
																</a>
																<a href="../backend/admin/delete-items.php?id=<?= $items['id'] ?>" class="btn btn-sm bg-danger-light">
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