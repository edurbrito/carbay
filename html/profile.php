<?php
include_once(__DIR__ . "/templates/header-logged-in.php");
breadcrum();
?>

<!-- Section: Nav tabs -->
<div class="d-flex align-items-start flex-vertical mt-sm-5" id="#colNav">
  <div class="nav flex-column nav-pills me-3 border-right p-3 flex-horizontal-profile d-sm-flex" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active text-primary btn-profile" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-bid-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bid-history" type="button" role="tab" aria-controls="v-pills-bid-history" aria-selected="false">Bid History</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-created-auctions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-created-auctions" type="button" role="tab" aria-controls="v-pills-auctions-created" aria-selected="false">Auctions Created</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-favourite-auctions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-favourite-auctions" type="button" role="tab" aria-controls="v-pills-favourite-auctions" aria-selected="false">Favourite Auctions</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-favourite-sellers-tab" data-bs-toggle="pill" data-bs-target="#v-pills-favourite-sellers" type="button" role="tab" aria-controls="v-pills-favourite-sellers" aria-selected="false">Favourite Sellers</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-users-ratings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-users-ratings" type="button" role="tab" aria-controls="v-pills-users-ratings" aria-selected="false">Users Ratings</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-users-rated-tab" data-bs-toggle="pill" data-bs-target="#v-pills-users-rated" type="button" role="tab" aria-controls="v-pills-users-rated" aria-selected="false">Users Rated</button>
  </div>
  <div class="tab-content w-100" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
      <?php include_once(__DIR__ . "/profile/profile-info.php"); ?>
    </div>
    <div class="tab-pane fade" id="v-pills-bid-history" role="tabpanel" aria-labelledby="v-pills-bid-history-tab">
      <?php include_once(__DIR__ . "/profile/bid-history.php"); ?>
    </div>
    <div class="tab-pane fade" id="v-pills-created-auctions" role="tabpanel" aria-labelledby="v-pills-created-auctions-tab">
      <?php include_once(__DIR__ . "/profile/created-auctions.php"); ?>
    </div>
    <div class="tab-pane fade" id="v-pills-favourite-auctions" role="tabpanel" aria-labelledby="v-pills-favourite-auctions-tab">
      <?php include_once(__DIR__ . "/profile/favourite-auctions.php"); ?>
    </div>
    <div class="tab-pane fade" id="v-pills-favourite-sellers" role="tabpanel" aria-labelledby="v-pills-favourite-sellers-tab">
      <?php include_once(__DIR__ . "/profile/favourite-sellers.php"); ?>
    </div>
    <div class="tab-pane fade" id="v-pills-users-ratings" role="tabpanel" aria-labelledby="v-pills-users-ratings-tab">
      <?php include_once(__DIR__ . "/profile/users-ratings.php"); ?>
    </div>
    <div class="tab-pane fade" id="v-pills-users-rated" role="tabpanel" aria-labelledby="v-pills-users-rated-tab">
      <?php include_once(__DIR__ . "/profile/users-rated.php"); ?>
    </div>
  </div>
</div>

<?php
include_once(__DIR__ . "/templates/footer-logged-in.php");
?>