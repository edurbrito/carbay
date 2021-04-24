@extends('layouts.content')

@section('div_content')

<form class="row align-items-end" action="/search">
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
        <form class="collapse hide d-md-block mt-4" id="collapseSearch" action="/search">
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
        @for ($i = 0; $i < 10; $i++)
            @each('partials.auction',[1],'auction')
        @endfor
        </div>
    </div>
</div>

@endsection