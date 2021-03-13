<?php include_once(__DIR__ . "/head.php"); ?>

<body>
    <nav class="navbar fixed-top navbar-expand-lg navbar-primary bg-primary text-light border-bottom border-dark" style="background-color:rgba(0, 0, 0, 0.9) !important;">
        <div class="container-fluid">
            <a class="navbar-brand text-light scale-objects-xs" href="/">
                <img src="/images/icon.png" style="max-height: 36px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarToggler">
                <ul class="navbar-nav d-flex justify-content-end align-items-center w-100">
                    <li class="nav-item mr-0 mr-lg-4 navbar-brand scale-objects">
                        <a href="/search.php" class="text-decoration-none text-reset"><i class="fas fa-search"></i><span class="d-lg-none .d-xl-block"> Search</span></a>
                    </li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4">
                        <a class="text-light" href="/login.php">
                            Log In
                        </a>
                    </li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4">
                        <a class="text-light" href="/signup.php">
                            Sign Up
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-lg text-primary overflow-auto my-5 fixed-footer" style="margin-top: 8rem !important;">

        <?php include_once(__DIR__ . "/breadcrumb.php"); ?>