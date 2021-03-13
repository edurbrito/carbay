<?php
include_once(__DIR__ . "/templates/head.php");
?>

<body class="bg-primary" style="height: 100vh; background-image: url(/images/cover.png); background-repeat: no-repeat; background-size: cover; background-position: center; background-image: linear-gradient(to bottom, rgba(0,0,0,0.45) 0%,rgba(0,0,0,0.45) 100%), url(/images/cover.png);">
  <nav class="navbar navbar-expand-lg navbar-primary bg-primary text-light border-bottom border-dark" style="background-color:rgba(0, 0, 0, 0.8) !important;">
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

  <div id="carousel" class="carousel slide p-3 p-sm-5" style="width: fit-content !important;" data-bs-ride="carousel" data-bs-interval="5000">

  <h4 class="text-light">Featured Auctions</h4>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <a class="border-left p-3 d-flex flex-column text-decoration-none scale-objects-sm" href="/auction.php">
          <h5 class="text-light">Ferrari 458 Italia</h5>
          <div class="text-light">
            <i class="far fa-clock"></i>
            2d 7h 59m 22s
          </div>
          <div class="text-light">
            <i class="fas fa-money-bill-wave-alt"></i>
            Last Bid: 500€
          </div>
          <div class="text-light">
            <i class="fas fa-wallet"></i>
            Buy Now: 2000€
          </div>
        </a>
      </div>
      <div class="carousel-item">
        <a class="border-left p-3 d-flex flex-column text-decoration-none scale-objects-sm" href="/auction.php">
          <h5 class="text-light">Citroen do Paulo</h5>
          <div class="text-light">
            <i class="far fa-clock"></i>
            2d 7h 59m 22s
          </div>
          <div class="text-light">
            <i class="fas fa-money-bill-wave-alt"></i>
            Last Bid: 500€
          </div>
          <div class="text-light">
            <i class="fas fa-wallet"></i>
            Buy Now: 2000€
          </div>
        </a>
      </div>
      <div class="carousel-item">
        <a class="border-left p-3 d-flex flex-column text-decoration-none scale-objects-sm" href="/auction.php">
          <h5 class="text-light">Lamborghini Tractor</h5>
          <div class="text-light">
            <i class="far fa-clock"></i>
            2d 7h 59m 22s
          </div>
          <div class="text-light">
            <i class="fas fa-money-bill-wave-alt"></i>
            Last Bid: 500€
          </div>
          <div class="text-light">
            <i class="fas fa-wallet"></i>
            Buy Now: 2000€
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="force-fixed-bottom">
    <div class="d-flex flex-column justify-content-center p-3 p-sm-5" style="background: linear-gradient(transparent, black);">
      <h1 class="text-light text-center mb-2 title-font-size">START BIDDING NOW</h1>
      <h5 class="text-light text-center mb-3 subtitle-font-size">We have all you need to complete your car collections</h5>
      <a class="btn btn-dark mx-auto" style="width: fit-content;" href="/search.php">View All Auctions</a>
    </div>
    <nav class="navbar navbar-primary border-top border-dark" style="background-color: #000;">
      <div class="container-fluid d-flex justify-content-center">
        <a class="navbar-brand text-light mr-4 ml-0" href="/about.php">About Us</a>
        <a class="navbar-brand text-light mr-0 ml-4" href="/faqs.php">FAQs</a>
      </div>
    </nav>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>