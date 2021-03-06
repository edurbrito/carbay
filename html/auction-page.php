<?php
include_once(__DIR__ . "/templates/header.php");
breadcrum();
?>


<form class="row align-items-start">
  <p class="fs-2">
    <i class="far fa-star"></i>
    Ferrari Portofino 1:18
  </p>
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
          <img src="https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_01.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_07.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_04.jpg" class="d-block w-100" alt="...">
        </div>
        <div class="carousel-item">
          <img src="https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_05.jpg" class="d-block w-100" alt="...">
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
      <button class="btn btn-dark text-light text-center btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#" role="button">Place Bid</button>
    </p>
    <p class="fs-4">
      <i class="fas fa-wallet"></i>
      Buy Now: 2000€
      <button class="btn btn-dark text-light text-center btn-sm" href="#" role="button">Buy Now</button>
    </p>
    <p>
      <strong>Color:</strong>
      &nbsp;Giallo Modena
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
  <div class="row py-5">
    <div class="col-lg-12 mx-auto">
      <ul class="nav nav-tabs btn-dark border border-danger" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active btn-danger" id="bidhistory-tab" data-bs-toggle="tab" data-bs-target="#bidhistory" type="button" role="tab" aria-controls="bidhistory" aria-selected="true">Bid History</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link btn-danger" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="false">Description</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link btn-danger" id="chat-tab" data-bs-toggle="tab" data-bs-target="#chat" type="button" role="tab" aria-controls="chat" aria-selected="false">Chat</button>
        </li>
      </ul>
      <div class="tab-content btn-dark border border-danger" id="myTabContent">
        <div class="tab-pane fade show active" id="bidhistory" role="tabpanel" aria-labelledby="bidhistory-tab">
          <div class="row py-1 gx-5">
            <p>
              27/03/2021 - 17:30 500€
            </p>
          </div>
          <div class="row py-1 gx-5">
            <p>
              27/03/2021 - 17:27 499€
            </p>
          </div>
          <div class="row py-1 gx-5">
            <p>
              26/03/2021 - 12:03 300€
            </p>
          </div>
        </div>
        <div class="tab-pane fade row py-1 gx-5" id="description" role="tabpanel" aria-labelledby="description-tab">
          <br>
          <p>
            Shown for the first time at Frankfurt Motor Show 2017, the Ferrari Portofino is the new V8 dream from the house of the Prancing Horse. Dedicated to one of the most exclusive and beautiful places in Italy – the small town of Portofino, in Liguria – the new born from Ferrari is a perfect mix of comfort, elegance and high performances.
          </p>
          <p>
            A versatile car that is the perfect choice for people who loves to drive in open air with a 600 CV engine. Heir of the celebrated Ferrari California T, Portofino boast also a brand new color called Rosso Portofino.
          </p>
        </div>
        <div class="tab-pane fade" id="chat" role="tabpanel" aria-labelledby="chat-tab">
          <div class="row py-1 gx-5">
            <p>
              johndoe123 : Bullish 26/03/2021 - 12:50
            </p>
          </div>
          <div class="row py-1 gx-5">
            <p>
              pjbomxd : Have Interest 26/03/2021 - 12:47
            </p>
          </div>
          <div class="row py-1 gx-5">
            <p>
              edurbrito : Bad Day 26/03/2021 - 12:45
            </p>
          </div>
        </div>
      </div>
    </div>
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