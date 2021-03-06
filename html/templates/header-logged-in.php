<?php include_once(__DIR__ . "/head.php"); ?>

<body class="bg-primary">
    <nav class="navbar fixed-top navbar-expand-lg navbar-primary bg-primary text-light border-bottom border-danger" style="background-color:rgba(0, 0, 0, 0.8) !important;">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="/">
                <i class="fas fa-car"></i>
                CarBay
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
                </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav d-flex justify-content-end align-items-center w-100">
                    <li class="nav-item mr-0 mr-lg-4 navbar-brand ">
                        <a href="/search.php" class="text-decoration-none text-reset"><i class="fas fa-search"></i><span class="d-lg-none .d-xl-block"> Search</span></a>
                    </li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><a href="/create_auction.php" class="text-decoration-none text-reset"><i class="fas fa-plus"></i><span class="d-lg-none .d-xl-block"> Create Auction</span></li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><a href="/notifications.php" class="text-decoration-none text-reset"><i class="fas fa-bell"></i><span class="d-lg-none .d-xl-block"> Notifications</span></a></li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><a href="/profile.php" class="text-decoration-none text-reset"><i class="fas fa-user-circle"></i> John Doe</a></li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><a href="/logout.php" class="text-decoration-none text-reset"><i class="fas fa-sign-out-alt"></i><span class="d-lg-none .d-xl-block"> Log Out</span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-lg text-light overflow-auto my-5" style="margin-top: 8rem !important;">

    <?php  include_once(__DIR__ . "/breadcrumb.php"); ?>