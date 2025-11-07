	<?php
	session_start();
	require_once('../include/config/path.php');
	require_once('includes/head.php');
	require_once(ROOT_PATH . 'include/function.php');
	$db = new Database();

	//get foster info
	//Display random 8 foster homes from USA (country_id = 231)
	$lost_items = "SELECT * FROM finder_reports order by created_at LIMIT 6";
	$result_lost_items = $db->fetchAll($lost_items);

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
								<h3 class="page-title">Welcome Admin!</h3>
								<ul class="breadcrumb">
									<li class="breadcrumb-item active">Dashboard</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- /Page Header -->

					<div class="row">
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-primary border-primary">
											<i class="fe fe-users"></i>
										</span>
										<div class="dash-count">
											<h3>10</h3>
										</div>
									</div>
									<div class="dash-widget-info">
										<h6 class="text-muted">Users</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-primary w-50"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-success">
											<i class="fe fe-user"></i>
										</span>
										<div class="dash-count">
											<h3>6</h3>
										</div>
									</div>
									<div class="dash-widget-info">

										<h6 class="text-muted">Lost Items</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-success w-50"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-danger border-danger">
											<i class="fe fe-user"></i>
										</span>
										<div class="dash-count">
											<h3>5</h3>
										</div>
									</div>
									<div class="dash-widget-info">

										<h6 class="text-muted">Match Items</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-danger w-50"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-3 col-sm-6 col-12">
							<div class="card">
								<div class="card-body">
									<div class="dash-widget-header">
										<span class="dash-widget-icon text-warning border-warning">
											<i class="fe fe-user"></i>
										</span>
										<div class="dash-count">
											<h3>5</h3>
										</div>
									</div>
									<div class="dash-widget-info">

										<h6 class="text-muted">Unmatch Items</h6>
										<div class="progress progress-sm">
											<div class="progress-bar bg-warning w-50"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-lg-6">

							<!-- Sales Chart -->

							<!-- /Sales Chart -->

						</div>

					</div>
					<div class="row">
						<div class="col-md-12 d-flex">

							<!-- Recent Orders -->
							<div class="card card-table flex-fill">
								<div class="card-header">
									<h4 class="card-title">Recent Items</h4>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-hover table-center mb-0">
											<thead>
												<tr>
													<th>S/N</th>
													<th>User</th>
													<th>Title</th>
													<th>Category</th>
													<th>Color</th>
													<th>Status</th>
													<th>Date</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$num = 0;
												foreach ($result_lost_items as $home) {
													$num++;
												?>
													<tr>
														<td><?= $num ?></td>
														<td>
															<h2 class="table-avatar">
																<a href="#"><?= $home['user_id'] ?></a>
															</h2>
														</td>
														<td><?= $home['title'] ?></td>
														<td class="text-right"><?= $home['category_id'] ?></td>
														<td><?= $home['color_id'] ?></td>
														<td><?= $home['status'] ?></td>
														<td><?= $home['created_at'] ?></td>
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

		<?php require_once('includes/script.php') ?>
	</body>

	<!-- Mirrored from dreamguys.co.in/demo/doccure/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 30 Nov 2019 04:12:34 GMT -->

	</html>