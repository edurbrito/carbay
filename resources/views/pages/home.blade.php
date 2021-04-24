@extends('layouts.app')

@section('body_tag')

<body class="bg-primary" style="height: 100vh; background-image: url({{ asset('images/cover.png') }}); background-repeat: no-repeat; background-size: cover; background-position: center; background-image: linear-gradient(to bottom, rgba(0,0,0,0.45) 0%,rgba(0,0,0,0.45) 100%), url({{ asset('images/cover.png') }});">
    @endsection

    @section('header')
    @include('layouts.header')
    @endsection

    @section('content')
    <div id="carousel" class="carousel slide p-3 p-sm-5" style="width: fit-content !important;" data-bs-ride="carousel" data-bs-interval="5000">

        <h4 class="text-light">Featured Auctions</h4>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <a class="border-left p-3 d-flex flex-column text-decoration-none scale-objects-sm" href="/auction">
                    <h5 class="text-light">Ferrari 458 Italia</h5>
                    <div class="text-light">
                        <i class="far fa-clock"></i>
                        2d 7h 59m 22s
                    </div>
                    <div class="text-light">
                        <i class="fas fa-money-bill-wave-alt"></i>
                        Last Bid: 500€
                    </div>
                    <div class="text-light">
                        <i class="fas fa-wallet"></i>
                        Buy Now: 2000€
                    </div>
                </a>
            </div>
            <div class="carousel-item">
                <a class="border-left p-3 d-flex flex-column text-decoration-none scale-objects-sm" href="/auction">
                    <h5 class="text-light">Citroen do Paulo</h5>
                    <div class="text-light">
                        <i class="far fa-clock"></i>
                        2d 7h 59m 22s
                    </div>
                    <div class="text-light">
                        <i class="fas fa-money-bill-wave-alt"></i>
                        Last Bid: 500€
                    </div>
                    <div class="text-light">
                        <i class="fas fa-wallet"></i>
                        Buy Now: 2000€
                    </div>
                </a>
            </div>
            <div class="carousel-item">
                <a class="border-left p-3 d-flex flex-column text-decoration-none scale-objects-sm" href="/auction">
                    <h5 class="text-light">Lamborghini Tractor</h5>
                    <div class="text-light">
                        <i class="far fa-clock"></i>
                        2d 7h 59m 22s
                    </div>
                    <div class="text-light">
                        <i class="fas fa-money-bill-wave-alt"></i>
                        Last Bid: 500€
                    </div>
                    <div class="text-light">
                        <i class="fas fa-wallet"></i>
                        Buy Now: 2000€
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endsection

    @section('footer')
    <div class="force-fixed-bottom">
        <div class="d-flex flex-column justify-content-center p-3 p-sm-5" style="background: linear-gradient(transparent, black);">
            <h1 class="text-light text-center mb-2 title-font-size">START BIDDING NOW</h1>
            <h5 class="text-light text-center mb-3 subtitle-font-size">We have all you need to complete your car collections</h5>
            <a class="btn btn-dark mx-auto" style="width: fit-content;" href="/search">View All Auctions</a>
        </div>
        <nav class="navbar navbar-primary border-top border-dark" style="background-color: #000;">
            <div class="container-fluid d-flex justify-content-center">
                <a class="navbar-brand text-light mr-4 ml-0" href="/about">About Us</a>
                <a class="navbar-brand text-light mr-0 ml-4" href="/faqs">FAQs</a>
            </div>
        </nav>
    </div>
    @endsection