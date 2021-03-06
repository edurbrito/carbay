<?php
  include_once(__DIR__ . "/templates/header-logged-in.php");
  breadcrum();
?>

<form class="row align-items-start">
    <div class="col-12 col-sm-9">
        <label for="search" class="form-label">Search</label>
        <input type="email" class="form-control" id="search" placeholder="Type Something">
    </div>
    <div class="col-12 col-sm-3 h-100">
        <label for="sort-by" class="form-label mt-1">Sort By</label>
        <select class="form-select rounded-0" id="sort-by" aria-label="Default select example">
            <option selected>Zero</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
        </select>
    </div>
</form>
<div class="row mt-4">
    <div class="col-md-auto">
        <h6 class="w-100 text-light text-center p-4 d-none d-lg-block">Advanced Search</h6>
        <button class="btn btn-dark w-100 text-light text-center p-4 d-lg-none .d-xl-block" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="true" aria-controls="collapseExample">Advanced Search</button>
        <form class="collapse hide d-md-block mt-4" id="collapseExample">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Ascending
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                    Descending
                </label>
            </div>
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                <label class="form-check-label" for="flexCheckDefault">
                    Buy Now option
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    Show ended auctions
                </label>
            </div>
            <select class="form-select mt-4 rounded-0" aria-label="Default select example">
                <option selected>Color:</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <select class="form-select mt-2 rounded-0" aria-label="Default select example">
                <option selected>Brand:</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <select class="form-select mt-2 rounded-0" aria-label="Default select example">
                <option selected>Scale:</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <select class="form-select mt-2 rounded-0" aria-label="Default select example">
                <option selected>Seller:</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>

            <label class="form-check-label mt-4" for="flexCheckChecked">
                Last Bid:
            </label>
            <br>
            <input type="number" min="10" max="100"> to
            <input type="number" min="10" max="100">
            <br>

            <label class="form-check-label mt-2" for="flexCheckChecked">
                Buy Now between:
            </label>
            <br>
            <input type="number" min="10" max="100"> to
            <input type="number" min="10" max="100">
        </form>
    </div>
    <div class="col container-fluid">
        <h6 class="w-100 text-light text-center p-4">64 Auctions found</h6>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php

            for ($i = 0; $i < 64; $i++) {
            ?>
                <div class="col">
                    <a href="auction_page.php" class="text-decoration-none">
                        <div class="card h-100 rounded-0">
                            <img src="https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_01.jpg" class="card-img-top">
                            <div class="card-body text-primary">
                                <h5 class="card-title text-center">Car Model <?= $i ?></h5>
                                <p class="card-text">
                                <p><i class="far fa-clock"></i> Time Remaining: 2:35:17</p>
                                <p><i class="far fa-money-bill-alt"></i> Last Bid: 500$</p>
                                <p><i class="far fa-credit-card"></i> Buy Now: 2000$</p>
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }

            ?>

        </div>
    </div>
</div>

<?php
  include_once(__DIR__ . "/templates/footer.php");
?>