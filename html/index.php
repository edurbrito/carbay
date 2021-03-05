<?php
include_once(__DIR__ . "/templates/header.php");
?>

<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-12">
      <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="https://mrcollection.com/wp-content/uploads/2020/08/bugatti-chiron-pur-sport_01.jpg" class="img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <div class="float-xl-left">
                <p class="fs-4" style="text-shadow: 2px 2px 0px #ff0000;">
                  <i class="far fa-clock"></i>
                  2d 7h 59m 22s
                </p>
                <p class="fs-4" style="text-shadow: 2px 2px 0px #ff0000;">
                  <i class="fas fa-money-bill-wave-alt"></i>
                  Last Bid: 500€
                </p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://mrcollection.com/wp-content/uploads/2020/11/lamborghini-aventador-svj-xago-edition.jpg" class="img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <div class="float-xl-left">
                <p class="fs-4" style="text-shadow: 2px 2px 0px #ff0000;">
                  <i class="far fa-clock"></i>
                  2d 7h 59m 22s
                </p>
                <p class="fs-4" style="text-shadow: 2px 2px 0px #ff0000;">
                  <i class="fas fa-money-bill-wave-alt"></i>
                  Last Bid: 500€
                </p>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <img src="https://mrcollection.com/wp-content/uploads/2020/08/Lambo_V12_Vision_GT_02.jpg" class="img-fluid" alt="...">
            <div class="carousel-caption d-none d-md-block">
              <div class="float-xl-left">
                <p class="fs-4" style="text-shadow: 2px 2px 0px #ff0000;">
                  <i class="far fa-clock"></i>
                  2d 7h 59m 22s
                </p>
                <p class="fs-4" style="text-shadow: 2px 2px 0px #ff0000;">
                  <i class="fas fa-money-bill-wave-alt"></i>
                  Last Bid: 500€
                </p>
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
      </div>
    </div>
  </div>
  <div class="row mt-4">
    <a class="d-grid gap-2 col-8 mx-auto" href="search.php">
      <button class="btn btn-outline-danger" type="button">View all live auctions</button>
    </a>
  </div>
</div>


<?php
include_once(__DIR__ . "/templates/footer.php");
?>