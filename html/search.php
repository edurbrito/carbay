<?php
include_once(__DIR__ . "/templates/header-logged-in.php");
breadcrum();
?>

<form class="row align-items-end" action="/search.php">
    <div class="col-12 col-sm-10">
        <label for="search" class="form-label text-primary">Search</label>
        <input type="text" class="form-control" id="search" placeholder="Type Something">
    </div>
    <div class="col-12 col-sm-2 h-100 d-flex align-items-end">
        <button class="btn btn-primary w-100 mt-4 mt-sm-0" type="submit">Search</button>
    </div>
</form>
<div class="row mt-4">
    <div class="col-md-auto">
        <h6 class="w-100 text-center p-4 d-none d-lg-block">Advanced Search</h6>
        <button class="btn btn-dark w-100 text-center p-4 d-lg-none .d-xl-block" data-bs-toggle="collapse" href="#collapseSearch" role="button" aria-expanded="true" aria-controls="collapseSearch">Advanced Search</button>
        <form class="collapse hide d-md-block mt-4" id="collapseSearch" action="/search.php">
            <label for="sort-by" class="form-label text-primary">Sort By</label>
            <select class="form-select rounded-0" id="sort-by" aria-label="Search By">
                <option selected>Time Remaining</option>
                <option value="1">Last Bid</option>
                <option value="2">Buy Now</option>
            </select>
            <div class="form-check mt-4 text-primary">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                <label class="form-check-label" for="flexRadioDefault1">
                    Ascending
                </label>
            </div>
            <div class="form-check text-primary">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                <label class="form-check-label" for="flexRadioDefault2">
                    Descending
                </label>
            </div>
            <div class="form-check mt-4 text-primary">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" checked>
                <label class="form-check-label" for="flexCheckDefault">
                    Buy Now option
                </label>
            </div>
            <div class="form-check text-primary">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                <label class="form-check-label" for="flexCheckChecked">
                    Show ended auctions
                </label>
            </div>
            <label for="sort-by" class="form-label mt-4 text-primary">Filter By</label>
            <select class="form-select rounded-0" aria-label="Default select example">
                <option selected>Color</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <select class="form-select mt-2 rounded-0" aria-label="Default select example">
                <option selected>Brand</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <select class="form-select mt-2 rounded-0" aria-label="Default select example">
                <option selected>Scale</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <select class="form-select mt-2 rounded-0" aria-label="Default select example">
                <option selected>Seller</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>

            <label class="form-check-label mt-4 text-primary" for="flexCheckChecked">
                Last Bid between
            </label>
            <br>
            <input type="number" min="10" max="100" placeholder="10"> to
            <input type="number" min="10" max="100" placeholder="100">
            <br>

            <label class="form-check-label mt-2 text-primary" for="flexCheckChecked">
                Buy Now between
            </label>
            <br>
            <input type="number" min="10" max="100" placeholder="10"> to
            <input type="number" min="10" max="100" placeholder="100">
            <br>
            <button class="btn btn-primary w-100 mt-4" type="submit">Apply</button>
        </form>
    </div>
    <div class="col container-fluid">
        <h6 class="w-100 text-primary text-center p-4">12 Auctions found</h6>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2018/07/ferrari-portofino-giallo_01.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Ferrari Portofino</h5>
                            <div class="card-text mb-0">
                            <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2016/08/bugatti-chiron-black_01.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Bugatti Chiron</h5>
                            <div class="card-text mb-0">
                            <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2020/09/lamborghini-veneno_02-600x400.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Lamborghini Veneno</h5>
                            <div class="card-text mb-0">
                            <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2017/10/bentley-new-continental-gt-01-768x510.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Bentley Continental</h5>
                            <div class="card-text mb-0">
                            <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2017/02/pagani-huayra-roadster_01-768x512.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Pagani Huayra Roadster</h5>
                            <div class="card-text mb-0">
                            <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-aventador-s-roadster-white_01.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Lamborghini Aventador S Roadster</h5>
                            <div class="card-text mb-0">
                            <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2017/09/ferrari-812-superfast-rosso-scuderia_01.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Ferrari 812 Superfast</h5>
                            <div class="card-text mb-0">
                            <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2016/10/ferrari-laferrari-aperta-gray01.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Ferrari LaFerrari Aperta</h5>
                            <div class="card-text mb-0">
                                <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2016/06/ferrari-f12tdf-blu_01.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Ferrari F12 tdf</h5>
                            <div class="card-text mb-0">
                                <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2015/11/ferrari_488_spider_scale_1_18_fe017-1.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Ferrari 458 Speciale A</h5>
                            <div class="card-text mb-0">
                                <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2017/10/bugatti-chiron-zero-400-zero_01-768x512.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Bugatti Chiron ZERO - 400 - ZERO Rear Wing Up</h5>
                            <div class="card-text mb-0">
                                <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col scale-objects-xs">
                <a href="auction.php" class="text-decoration-none">
                    <div class="card h-100 rounded-0">
                        <img src="https://mrcollection.com/wp-content/uploads/2018/01/lamborghini-centenario-roadster-black_01.jpg" class="card-img-top">
                        <div class="card-body text-primary">
                            <h5 class="card-title text-center">Lamborghini Centenario Roadster</h5>
                            <div class="card-text mb-0">
                                <p title="Time Remaining" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> 2:35:17</p>
                                <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> 500$</p>
                                <p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> 2000$</p>
                                <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile.php"><i class="far fa-user"></i> johndoe (<i class="far fa-star"></i> 4.8)</a>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . "/templates/footer-logged-in.php");
?>