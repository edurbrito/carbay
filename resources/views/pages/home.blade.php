@extends('layouts.app')

@push('scripts')
<script src="{{ asset('js/app.js') }}" defer></script>
@endpush

@section('body_tag')

<body class="bg-primary" style="height: 100vh; background-image: url({{ asset('images/cover.png') }}); background-repeat: no-repeat; background-size: cover; background-position: center; background-image: linear-gradient(to bottom, rgba(0,0,0,0.45) 0%,rgba(0,0,0,0.45) 100%), url({{ asset('images/cover.png') }});">
    @endsection

    @section('header')
    @include('layouts.header')
    @endsection

    @section('content')
    <div id="carousel" class="carousel slide p-3 p-sm-5" style="width: fit-content !important;" data-bs-ride="carousel" data-bs-interval="5000">
        <h4 class="text-light">Featured Auctions</h4>
        <div class="carousel-inner" id="featured-auctions">
        </div>
    </div>
    @endsection

    @section('footer')
    <div class="force-fixed-bottom">
        <div class="d-flex flex-column justify-content-center p-3 p-sm-5" style="background: linear-gradient(transparent, black);">
            <h1 class="text-light text-center mb-2 title-font-size">START BIDDING NOW</h1>
            <h5 class="text-light text-center mb-3 subtitle-font-size">We have all you need to complete your car collections</h5>
            <h6 class="text-light text-center mb-3 subtitle-font-size">Hand-made resin models from 1:8 to 1:64</h6>
            <a class="btn btn-dark mx-auto" style="width: fit-content;" href="/auctions/search">View All Auctions</a>
        </div>
        <nav class="navbar navbar-primary border-top border-dark" style="background-color: #000;">
            <div class="container-fluid d-flex justify-content-center">
                <a class="navbar-brand text-light mr-4 ml-0" href="/about">About Us</a>
                <a class="navbar-brand text-light mr-0 ml-4" href="/faqs">FAQs</a>
            </div>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    @endsection