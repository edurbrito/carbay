<?php
include_once(__DIR__ . "/templates/header-logged-in.php");
breadcrum();
?>

<h1 class="text-center">New Auction</h1>

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
        <div class="input-group mb-3 mt-3">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="images" value="Upload Image" style="cursor: pointer;">
                <label class="custom-file-label" for="images" style="cursor: pointer;">Upload Image</label>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
        <ul class="nav nav-pills mb-3 justify-content-start" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active btn-auction" id="pills-general-info-tab" data-bs-toggle="pill" data-bs-target="#pills-general-info" type="button" role="tab" aria-controls="pills-general-info" aria-selected="true">General Info</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-auction" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="false">Description</button>
            </li>
        </ul>
        <form class="tab-content text-primary d-flex flex-column" id="pills-tabContent" action="/auction.php">
            <div class="tab-pane show active" id="pills-general-info" role="tabpanel" aria-labelledby="pills-general-info-tab">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-0" id="inputGroup-sizing-default">Title</span>
                    </div>
                    <input type="text" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Car Model A" required>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend rounded-0">
                                <span class="input-group-text rounded-0" id="start-bid">Starting Bid</span>
                            </div>
                            <input type="number" min="0.01" max="100000" class="form-control" aria-label="Small" aria-describedby="start-bid" value="0.01" required>
                            <div class="input-group-append rounded-0">
                                <span class="input-group-text rounded-0">€</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend rounded-0">
                                <span class="input-group-text rounded-0" id="start-date">Starting Date</span>
                            </div>
                            <input type="date" class="form-control rounded-0" aria-label="Small" aria-describedby="start-date" width="fit-content" value="09/03/2021" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="duration">Duration</span>
                            </div>
                            <input type="number" min="1" max="15" class="form-control" aria-label="Small" aria-describedby="duration" value="1" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="inputGroup-sizing-sm">Days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 row flex-row mb-3 pr-0">
                        <div class="col-6">
                        <input type="checkbox" id="buy-now" onchange="document.getElementById('buy-now-input-group').hidden = !this.checked;">
                        <label for="buy-now">
                            Buy Now
                        </label>
                        </div>
                        <div class="input-group input-group-sm col-6 p-0" id="buy-now-input-group" hidden>
                            <input type="number" min="1" max="100" class="form-control rounded-0" aria-label="Small" aria-describedby="buy-now" id="buy-now-value">
                            <div class="input-group-append">
                                <span class="input-group-text rounded-0" id="inputGroup-sizing-sm">€</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">

                <select class="form-select rounded-0" aria-label="color" required>
                    <option selected>Color</option>
                    <option value="1">Yellow</option>
                    <option value="2">Red</option>
                    <option value="3">Green</option>
                </select>
                <select class="form-select mt-2 rounded-0" aria-label="brand" required>
                    <option selected>Brand</option>
                    <option value="1">Ferrari</option>
                    <option value="2">Lamborghini</option>
                    <option value="3">Citroen</option>
                </select>
                <select class="form-select mt-2 rounded-0" aria-label="scale" required>
                    <option selected>Scale</option>
                    <option value="1">1:18</option>
                    <option value="2">1:64</option>
                    <option value="3">1:125</option>
                </select>

                <div class="form-group mt-3">
                    <textarea class="form-control" id="description" rows="3" placeholder="Write here the product description..." required></textarea>
                </div>
            </div>
            <div class="btn-group ml-auto mt-auto" role="group" aria-label="Create Auction Buttons">
                <button type="button" class="btn btn-dark mr-1">Discard</button>
                <button type="submit" class="btn btn-success">Publish</button>
            </div>
        </form>
    </div>
</div>

<?php
include_once(__DIR__ . "/templates/footer-logged-in.php");
?>