@extends('layouts.content')

@push('scripts')
<script src="{{ asset('js/search.js') }}" defer></script>
@endpush

@section('div_content')

<form id="full-text-form" class="row align-items-end">
    {{ csrf_field() }}
    <div class="col-12 col-sm-10">
        <label for="full-text" class="form-label text-primary">Search</label>
        <input type="text" name="full-text" class="form-control" id="full-text" placeholder="Type Something">
    </div>
    <div class="col-12 col-sm-2 h-100 d-flex align-items-end">
        <button class="btn btn-primary w-100 mt-4 mt-sm-0" type="submit">Search</button>
    </div>
</form>
<div class="row mt-4">
    <div class="col-md-auto">
        <h6 class="w-100 text-center p-4 d-none d-lg-block">Advanced Search 
        <a tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="Change the parameters as you wish and press apply to modify your custom search."><i class="far fa-question-circle"></i></a>
        </h6>
        <button class="btn btn-dark w-100 text-center p-4 d-lg-none .d-xl-block" data-bs-toggle="collapse" href="#advanced-form" role="button" aria-expanded="true" aria-controls="advanced-form">Advanced Search</button>
        <form id="advanced-form" class="collapse hide d-md-block mt-4">
            <button class="btn-md btn-secondary w-100 mb-4" type="button" id="reset-button">Reset</button>
            <label for="sort-by" class="form-label text-primary">Sort By</label>
            <select name="sort-by" class="form-select rounded-0" id="sort-by" aria-label="Search By">
                <option selected value="0">Time Remaining</option>
                <option value="1">Last Bid</option>
                <option value="2">Buy Now</option>
            </select>
            <div class="form-check mt-4 text-primary">
                <input class="form-check-input" type="radio" name="order-by" id="ascending" checked value="0">
                <label class="form-check-label" for="ascending">
                    Ascending
                </label>
            </div>
            <div class="form-check text-primary">
                <input class="form-check-input" type="radio" name="order-by" id="descending" value="1">
                <label class="form-check-label" for="descending">
                    Descending
                </label>
            </div>
            <div class="form-check mt-4 text-primary">
                <input name="buy-now" class="form-check-input" type="checkbox" id="buy-now" checked>
                <label class="form-check-label" for="buy-now">
                    Buy Now option
                </label>
            </div>
            <div class="form-check text-primary">
                <input name="ended-auctions" class="form-check-input" type="checkbox" id="ended-auctions">
                <label class="form-check-label" for="ended-auctions">
                    Show ended auctions
                </label>
            </div>
            <label for="sort-by" class="form-label mt-4 text-primary">Filter By</label>
            
            <select class="form-select mt-2 rounded-0" aria-label="Available Scales" id="select-scale" name="scale">
                <option selected value="-1">Scale</option>
            </select>

            <input type="text" name="colour" list="select-colour" class="form-select rounded-0 mt-2" id="select-colour-input" placeholder="Colour">
            <datalist id="select-colour">
            </datalist>

            <input type="text" name="brand" list="select-brand" class="form-select rounded-0 mt-2" id="select-brand-input" placeholder="Brand">
            <datalist id="select-brand">
            </datalist>

            <input type="text" name="seller" list="select-seller" class="form-select rounded-0 mt-2" id="select-seller-input" placeholder="Seller">
            <datalist id="select-seller">
            </datalist>

            <label class="form-check-label mt-4 text-primary">
                Last Bid between
            </label>
            <br>
            <input id="min-bid" type="number" min="1" max="1000000" placeholder="10" name="min-bid"> to
            <input id="max-bid" type="number" min="1" max="1000000" placeholder="100" name="max-bid">
            <br>

            <label class="form-check-label mt-2 text-primary">
                Buy Now between
            </label>
            <br>
            <input id="min-buy-now" type="number" min="1" max="1000000" placeholder="10" name="min-buy-now"> to
            <input id="max-buy-now" type="number" min="1" max="1000000" placeholder="100" name="max-buy-now">
            <br>
            <button class="btn btn-primary w-100 mt-4" type="submit">Apply</button>
        </form>
    </div>
    <div class="col container-fluid mb-4">
        <h6 class="w-100 text-primary text-center p-4" id="total-search">
        </h6>

        <div class="row" id="auctions">
            <div class="spinner-border align-self-center m-auto" role="status"><span class="sr-only">Loading...</span></div>
        </div>
    </div>
</div>

<div id="pagination" data-page="1">
</div>
@endsection