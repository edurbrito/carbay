<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/all.min.js" defer></script>
    <title>CarBay</title>
</head>

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
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><i class="fas fa-bell"></i><span class="d-lg-none .d-xl-block"> Notifications</span></li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><i class="fas fa-user-circle"></i> John Doe</li>
                    <li class="nav-item navbar-brand mr-0 mr-lg-4"><i class="fas fa-sign-out-alt"></i><span class="d-lg-none .d-xl-block"> Log Out</span></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-lg text-light overflow-auto my-5" style="margin-top: 8rem !important;">

        <?php

        function breadcrum()
        {
            $uri = $_SERVER['REQUEST_URI'];

            if (strcmp($uri, "/") > 0) {

                $uri = str_replace(".php", "", $uri);

                $uri = explode("/", $uri);

        ?>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb text-uppercase p-0">
                        <li class="breadcrumb-item"><a href="/" class="text-light">Home</a></li>
                        <?php
                        for ($i = 1; $i < sizeof($uri) - 1; $i++) {
                            $u = $uri[$i];
                            echo "<li class=\"breadcrumb-item\"><a href=\"/" . $u . "\" class=\"text-light\">" . $u . "</a></li>";
                        }
                        ?>
                        <li class="breadcrumb-item active" aria-current="page"><?= $uri[sizeof($uri) - 1] ?></li>
                        <?php ?>
                    </ol>
                </nav>
        <?php
            }
        }

        ?>