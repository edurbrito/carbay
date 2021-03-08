<?php
include_once(__DIR__ . "/templates/header-logged-in.php");
breadcrum();
?>

<style scoped>
  button.active {
    border-left: 6px solid white !important;
    font-weight: bold;
    border-radius: 0 !important;
  }

  @media (max-width: 576px) {
    .flex-vertical {
      flex-direction: column !important;
    }

    .flex-horizontal {
      flex-direction: row !important;
      margin: auto !important;
      justify-content: center;
      border: 0 !important;
      padding: 0 !important;
      margin-bottom: 2rem !important;
    }

    button.mb-3 {
      margin-bottom: 0 !important;
    }
  }
</style>

<!-- Section: Nav tabs -->
<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#colNav">
  <span class="navbar-toggler-icon"></span>
</button>

<div class="d-flex align-items-start flex-vertical mt-sm-5" id="#colNav">
  <div class="nav flex-column nav-pills me-3 border-right p-3 flex-horizontal d-none d-sm-flex" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active text-light" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</button>
    <button class="nav-link text-light" id="v-pills-bid-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bid-history" type="button" role="tab" aria-controls="v-pills-bid-history" aria-selected="false">Bid History</button>
    <button class="nav-link text-light" id="v-pills-auctions-created-tab" data-bs-toggle="pill" data-bs-target="#v-pills-auctions-created" type="button" role="tab" aria-controls="v-pills-auctions-created" aria-selected="false">Auctions Created</button>
    <button class="nav-link text-light" id="v-pills-favourite-auctions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-favourite-auctions" type="button" role="tab" aria-controls="v-pills-favourite-auctions" aria-selected="false">Favourite Auctions</button>
    <button class="nav-link text-light" id="v-pills-favourite-sellers-tab" data-bs-toggle="pill" data-bs-target="#v-pills-favourite-sellers" type="button" role="tab" aria-controls="v-pills-favourite-sellers" aria-selected="false">Favourite Sellers</button>
    <button class="nav-link text-light" id="v-pills-users-ratings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-users-ratings" type="button" role="tab" aria-controls="v-pills-users-ratings" aria-selected="false">Users Ratings</button>
  </div>
  <div class="tab-content w-100" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
      <?php include_once(__DIR__ . "/profile/profile.php"); ?>
    </div>
    <div class="tab-pane fade" id="v-pills-bid-history" role="tabpanel" aria-labelledby="v-pills-bid-history-tab">
      <?php include_once(__DIR__ . "/profile/bid-history.php"); ?>
    </div>
    <div class="tab-pane fade" id="v-pills-auctions-created" role="tabpanel" aria-labelledby="v-pills-auctions-created-tab">
      <?php include_once(__DIR__ . "/profile/auctions-created.php"); ?>
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
  </div>
</div>

<?php
include_once(__DIR__ . "/templates/footer.php");
?>