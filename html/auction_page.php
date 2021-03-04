<?php
include_once(__DIR__ . "/templates/header.php");
breadcrum();
?>


<form class="row align-items-start">
    <div class="col-12 col-sm-5">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_01.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_07.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_02.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_05.jpg" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
    <div class="col-12 col-sm-2 h-100"></div>
    <div class="col-12 col-sm-5 h-100">
        <p class="fs-4">
            <i class="far fa-clock"></i>
            2d 7h 59m 22s
        </p>
        <p class="fs-4">
            <i class="fas fa-money-bill-wave-alt"></i>
            Last Bid: 500€
            <button class="btn btn-dark text-light text-center btn-sm" href="#" role="button">Place Bid</button>
        </p>
        <p class="fs-4">
            <i class="fas fa-wallet"></i>
            Buy Now: 2000€
            <button class="btn btn-dark text-light text-center btn-sm" href="#" role="button">Buy Now</button>
        </p>
        <p>
            <strong>Color:</strong>
            &nbsp;Red
            <br>
            <strong>Brand:</strong>
            &nbsp;Ferrari
            <br>
            <strong>Scale:</strong>
            &nbsp;1:18
            <br>
            <strong>Seller:</strong>
            &nbsp;<a href="#" class="ml-2 text-white">rickwheels</a>
            <i class="far fa-user-circle"></i>
        </p>
    </div>
</form>


<!-- <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_01.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_07.jpg" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_02.jpg" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"  data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"  data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div> -->

<?php
include_once(__DIR__ . "/templates/footer.php");
?>