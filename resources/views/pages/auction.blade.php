@extends('layouts.content')

@section('div_content')


<h1 class="fs-2 text-primary text-center">
  <i class="far fa-star"></i>
  {{ $auction->title }}
</h1>

<div class="row mt-5">
  <div class="col-12 col-sm-6">
    <div id="carouselIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <div class="carousel-indicators">
        @php 
        $images = $auction->display_images()
        @endphp
        @for ($i = 0; $i < count($images); $i++)
          @if ($i == 0)
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          @else
            <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i+1}}"></button>
          @endif
        @endfor
      </div>
      <div class="carousel-inner">
        @for ($i = 0; $i < count($images); $i++)
          @if ($i == 0)
            <div class="carousel-item active">
              <img src="{{$images[$i]->url}}" class="d-block w-100" alt="...">
            </div>
          @else
            <div class="carousel-item">
              <img src="{{$images[$i]->url}}" class="d-block w-100" alt="...">
            </div>
          @endif
        @endfor
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
      {{ $auction->time_remaining() }}
    </p>
    <p class="fs-4">
      <i class="far fa-money-bill-alt"></i>
      Last Bid: {{ $auction->highest_bid_value() }}€ 
    </p>
    @if(isset($auction->buynow))
    <p class="fs-4 mt-4">
      <i class="far fa-credit-card"></i>
      Buy Now: {{ $auction->buy_now() }}€
    </p>
    @endif
    <p>
      <strong>Colour:</strong>
      {{ $auction->colour_name() }}
      <br>
      <strong>Brand:</strong>
      {{ $auction->brand_name() }}
      <br>
      <strong>Scale:</strong>
      1:18
      <br>
      @php
      $seller_name=$auction->seller_name()
      @endphp
      <strong>Seller:</strong><a href="{{ $seller_name }}/profile.php" class="ml-2">{{ $seller_name }}</a>
    </p>
    <button class="btn btn-dark text-light text-center btn" data-bs-toggle="modal" data-bs-target="#buy-now" role="button">Buy Now</button>
    <button class="btn btn-success text-light text-center btn" data-bs-toggle="modal" data-bs-target="#place-bid" role="button">Place Bid</button>

  </div>

  <p class="text-center text-primary mt-4">
    {{ $auction->description() }}
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
      @for ($i = count($auction->bids)-1; $i >= 0 ; $i--)
        <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
          <p class="text-primary fs-6 mb-0">{{substr($auction->bids[$i]->datehour, 0, -6)}}</p>
          <p class="text-primary fs-5 mb-0 ml-sm-auto">{{$auction->bids[$i]->value}}€</p>
        </li>
      @endfor
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


@endsection