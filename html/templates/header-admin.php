<?php include_once(__DIR__ . "/head.php"); ?>

<body class="bg-primary">
    <nav class="navbar fixed-top navbar-expand-lg navbar-primary bg-primary text-light border-bottom border-dark" style="background-color:rgba(0, 0, 0, 0.8) !important;">
        <div class="container-fluid">
            <a class="navbar-brand text-light" href="/">
                <img src="/images/icon.png" style="max-height: 36px;">
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
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><a href="/admin.php" class="text-decoration-none text-reset"><i class="fas fa-cog"></i></i><span class="d-lg-none .d-xl-block"> Admin Panel</span></a></li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><a data-bs-toggle="modal" data-bs-target="#notifications" class="text-decoration-none text-reset" style="cursor: pointer;"><i class="fas fa-bell"></i><span class="d-lg-none .d-xl-block"> Notifications</span></a></li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><a href="/profile.php" class="text-decoration-none text-reset"><i class="fas fa-user-circle"></i> Admin1</a></li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><a href="/index.php" class="text-decoration-none text-reset"><i class="fas fa-sign-out-alt"></i><span class="d-lg-none .d-xl-block"> Log Out</span></a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal -->
    <div class="modal fade" id="notifications" tabindex="-1" aria-labelledby="notifications" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notifications">Notifications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ol class="list-group rounded-0 pr-sm-3 border-0">
                        <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical border-0 border-bottom">
                            <p class="text-primary fs-6 mb-0">User davidgolias was reported</p>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical border-0 border-bottom">
                            <p class="text-primary fs-6 mb-0">User johndoe sent a message</p>
                        </li>
                        <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical border-0 border-bottom">
                            <p class="text-primary fs-6 mb-0">User pjbomxd sent a message</p>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-lg text-light overflow-auto my-5 fixed-footer" style="margin-top: 8rem !important;">
        
    <?php  include_once(__DIR__ . "/breadcrumb.php"); ?>