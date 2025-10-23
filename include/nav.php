<div class="container-xxl position-relative p-0">
    <nav class="navbar navbar-expand-lg navbar-light px-4 px-lg-5 py-3 py-lg-0">
        <a href="" class="navbar-brand p-0">
            <h1 class="m-0">Panther Finder</h1>
            <!-- <img src="img/logo.png" alt="Logo"> -->
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav mx-auto py-0">
                <a href="index.php" class="nav-item nav-link active">Home</a>
                <?php
                if (isset($_SESSION['last_login_time'])) { ?>
                    <a href="project.php" class="nav-item nav-link">My report</a>
                    <!-- <a href="report.php" class="nav-item nav-link">Reports</a> -->
                <?php }
                ?>
                <!-- <a href="#" class="nav-item nav-link">Project</a> -->
                <a href="#" class="nav-item nav-link">Our Team</a>
                <a href="#" class="nav-item nav-link">Testimonial</a>
                <a href="#" class="nav-item nav-link">Contact</a>
            </div>
            <?php
            if (isset($_SESSION['last_login_time'])) { ?>
                <a href="logout.php" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Logout</a>

            <?php } else { ?>
                <a href="login.php" class="btn rounded-pill py-2 px-4 ms-3 d-none d-lg-block">Get Started</a>
            <?php }
            ?>
        </div>
    </nav>


</div>