<?php
include_once(__DIR__ . "/templates/header-logged-in.php");
breadcrum();
?>

<h1 class="fs-2 text-primary text-center">
  <i class="far fa-star"></i>
  Ferrari 812 Superfast
</h1>

<div class="row mt-5">
  <div class="col-12 col-sm-6">
    <div id="carouselIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
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
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
  <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-primary text-center text-sm-left">
    <p class="fs-2">
      <i class="far fa-clock"></i>
      2d 7h 59m 22s
    </p>
    <p class="fs-4">
      <i class="far fa-money-bill-alt"></i>
      Last Bid: 135€
    </p>
    <p class="fs-4 mt-4">
      <i class="far fa-credit-card"></i>
      Buy Now: 2000€
    </p>
    <p>
      <strong>Color:</strong>
      Rosso Scuderia
      <br>
      <strong>Brand:</strong>
      Ferrari
      <br>
      <strong>Scale:</strong>
      1:18
      <br>
      <strong>Seller:</strong><a href="/profile.php" class="ml-2">rickwheels</a>
    </p>
    <button class="btn btn-dark text-light text-center btn" data-bs-toggle="modal" data-bs-target="#buy-now" role="button">Buy Now</button>
    <button class="btn btn-success text-light text-center btn" data-bs-toggle="modal" data-bs-target="#place-bid" role="button">Place Bid</button>

  </div>

  <p class="text-center text-primary mt-4">
    The most powerful and performing Ferrari ever made: this is the Ferrari 812 Superfast, the new masterpiece from the house of the Prancing Horse that was be unveiled at Geneva Motor Show 2017. A V12 engine with 800 HP will give to this supercar the incredible speed of 340 km/h.
  </p>
</div>

<ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
  <li class="nav-item mr-0" role="presentation">
    <button class="nav-link active btn-auction" id="pills-chat-tab" data-bs-toggle="pill" data-bs-target="#pills-chat" type="button" role="tab" aria-controls="pills-chat" aria-selected="false">Chat</button>
  </li>
  <li class="nav-item mr-0" role="presentation">
    <button class="nav-link btn-auction" id="pills-bid-history-tab" data-bs-toggle="pill" data-bs-target="#pills-bid-history" type="button" role="tab" aria-controls="pills-bid-history" aria-selected="true">Bid History</button>
  </li>
</ul>
<div class="tab-content" id="pills-tabContent">
  <div class="tab-pane" id="pills-bid-history" role="tabpanel" aria-labelledby="pills-bid-history-tab">
    <ol class="list-group rounded-0 hide-scroll" style="overflow-y: scroll; max-height: 40vh;">
      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
        <p class="text-primary fs-6 mb-0">27-03-2020 17:30</p>
        <p class="text-primary fs-5 mb-0 ml-sm-auto">135€</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
        <p class="text-primary fs-6 mb-0">27-03-2020 17:22</p>
        <p class="text-primary fs-5 mb-0 ml-sm-auto">127€</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
        <p class="text-primary fs-6 mb-0">27-03-2020 12:10</p>
        <p class="text-primary fs-5 mb-0 ml-sm-auto">105€</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
        <p class="text-primary fs-6 mb-0">26-03-2020 23:54</p>
        <p class="text-primary fs-5 mb-0 ml-sm-auto">69€</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
        <p class="text-primary fs-6 mb-0">26-03-2020 23:12</p>
        <p class="text-primary fs-5 mb-0 ml-sm-auto">33€</p>
      </li>
    </ol>
  </div>
  <div class="tab-pane show active" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
    <ol class="list-group rounded-0 hide-scroll" style="overflow-y: scroll; max-height: 40vh;">
      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">johndoe123:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:30</p>
        </div>
        <p class="w-100 text-primary mb-0">Bullish</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">edurbrito:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:27</p>
        </div>
        <p class="w-100 text-primary mb-0">Lost Interest! It seems a huge scam :/</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">pjbomxd:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:22</p>
        </div>
        <p class="w-100 text-primary mb-0">I will try again later</p>
      </li>
      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">johndoe123:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:30</p>
        </div>
        <p class="w-100 text-primary mb-0">Bullish</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">edurbrito:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:27</p>
        </div>
        <p class="w-100 text-primary mb-0">Lost Interest! It seems a huge scam :/</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">pjbomxd:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:22</p>
        </div>
        <p class="w-100 text-primary mb-0">I will try again later</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">johndoe123:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:30</p>
        </div>
        <p class="w-100 text-primary mb-0">Bullish</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">edurbrito:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:27</p>
        </div>
        <p class="w-100 text-primary mb-0">Lost Interest! It seems a huge scam :/</p>
      </li>

      <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-column">
        <div class="d-flex w-100 mb-1">
          <p class="text-primary fs-5 mb-0 mr-auto float-left">pjbomxd:</p>
          <p class="text-primary fs-6 mb-0 text-right float-right">27-03-2020 17:22</p>
        </div>
        <p class="w-100 text-primary mb-0">I will try again later</p>
      </li>
    </ol>
    <div class="d-flex bg-white align-content-center mt-1">
      <form class="w-100" action="/auction.php">
        <label for="send-question" class="form-label text-primary">Message:</label>
        <textarea class="form-control" id="send-question" rows="1" required=""></textarea>
        <button type="submit" class="btn btn-primary mt-3 float-right">Send</button>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="buy-now" tabindex="-1" aria-labelledby="buy-now" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-primary">
        Value: 2000 €
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal" aria-label="Dismiss">Buy Now</button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="place-bid" tabindex="-1" aria-labelledby="place-bid" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-primary">

        <label class="form-check-label mt-2 text-primary" for="flexCheckChecked">
            Bid Value:
        </label>
        <input type="number" min="10" max="100" placeholder="10">
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="button" class="btn btn-success" data-bs-dismiss="modal" aria-label="Dismiss">Place Bid</button>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
include_once(__DIR__ . "/templates/footer-logged-in.php");
?>