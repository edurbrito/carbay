@extends('layouts.content')

@push('scripts')
<script src="{{ asset('js/auction.js') }}" defer></script>
@endpush

@php

$ended = $auction->time_remaining() == "Ended";
$winner = false;
$seller = false;
$winnerUser = false;

if(!is_null($auction->highest_bid()) && Auth::check()){
  $winner = $auction->highest_bid()->authorid == Auth::user()->id;
}
if($ended){
  $winnerUser = App\Models\User::find($auction->highest_bid()->authorid);
}
if(Auth::check()){
  $seller = $auction->sellerid == Auth::user()->id;
}

$not_rated = is_null($auction->rating());

$show_rate = $ended && $winner && $not_rated;

$nr_bids = $auction->bids->count();

@endphp

@section('div_content')

<h1 class="fs-2 text-primary text-center" data-id="{{$auction->id}}" id="auction-head">
  <span id="favourite-auction" style="cursor: pointer;" data-auction="{{ $auction->id }}"><i class="@if(Auth::check() && Auth::user()->hasFavouriteAuction($auction->id)) fas @else far @endif fa-star scale-objects-sm"></i></span>
  {{ $auction->title }}
</h1>

<div class="row mt-5">
  <div class="col-12 col-sm-6">
    <div id="carouselIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
      <div class="carousel-indicators">
        @php
        $images = $auction->display_images()
        @endphp
        @for ($i = 0; $i < count($images); $i++) @if ($i==0) <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          @else
          <button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="{{$i}}" aria-label="Slide {{$i+1}}"></button>
          @endif
          @endfor
      </div>
      <div class="carousel-inner">
        @for ($i = 0; $i < count($images); $i++) @if ($i==0) <div class="carousel-item active">
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
    @if($auction->suspend)
    <i class="fas fa-ban align-self-center mr-2" style="color: red;"></i>
    <span style="color: red !important;">Suspended</span>
    @else
    @if(Auth::check() && $ended && $winner)YOU WON THIS AUCTION!@elseif(Auth::check() && $ended && $seller && $nr_bids == 0)THIS AUCTION ENDED WITH NO BIDS!@elseif(Auth::check() && $ended && $seller && $winnerUser==null)[deleted] WON THIS AUCTION!@elseif(Auth::check() && $ended && $seller)<a href="/users/{{ $winnerUser->username }}">{{ $winnerUser->username }}</a> WON THIS AUCTION!@else<a tabindex="0" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="Time Remaining" id="time-remaining" data-time="{{$auction->finaldate}}"><i class="far fa-clock"></i> <span id="time-remaining-value">{{$auction->time_remaining()}}</span></a>@endif
    @endif
  </p>
  <p class="fs-4">
    <i class="far fa-money-bill-alt"></i>
    Last Bid: <span id="last-bid-value">{{ $auction->highest_bid_value() }}</span>
  </p>
  @if(!is_null($auction->buynow))
  <p class="fs-4 mt-4">
    <i class="far fa-credit-card"></i>
    Buy Now: {{ $auction->buy_now() }}
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
    {{ $auction->scaletype }}
    <br>
    @php
      $seller_username = "[deleted]";
      if(!is_null($auction->seller))
        $seller_username=$auction->seller_username();
    @endphp
    <strong>Seller:</strong><a href="/users/{{ $seller_username }}" class="ml-2">{{ $seller_username }}</a>
    @if(Auth::check() && Auth::user()->id != $auction->seller->id && !is_null($auction->seller))
    <span class="report-button ml-2" data-id="{{$auction->id}}" data-location="2" data-username="{{ $auction->seller_username() }}" data-bs-toggle="modal" data-bs-target="#report-user" role="button">
      <i style="font-size: 0.8rem; color: red;" class="far fa-flag"></i>
    </span>
    @endif
  </p>
    @if (Auth::check() && !Auth::user()->admin && !($auction->finaldate <= NOW())) 
        @if(!is_null($auction->buynow))
        <button class="btn btn-dark text-light text-center btn" data-bs-toggle="modal" data-bs-target="#buy-now" role="button">Buy Now</button>
        @endif
        <button class="btn btn-success text-light text-center btn" data-bs-toggle="modal" data-bs-target="#place-bid" role="button">Place Bid</button>
    @elseif(Auth::check() && $show_rate)
      <button class="btn btn-success text-light text-center btn" data-bs-toggle="modal" data-bs-target="#show-rate" role="button" id="rating-button">Leave Rating</button>
    @endif
    @if ($errors->has('value'))
    <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show my-3 p-1 px-2" style="width: fit-content;" role="alert">
      {{ $errors->first('value') }}
    </div>
    @elseif(session('success'))
    <div onclick="this.hidden = true" class="alert alert-success alert-dismissible fade show my-3 p-1 px-2" style="width: fit-content;" role="alert">
      {{ session('success')[0] }}
    </div>
    @endif
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
    <ol id="bids-list" class="list-group rounded-0 hide-scroll" style="overflow-y: scroll; max-height: 40vh; border-top: 1px solid rgba(0,0,0,.125); border-bottom: 1px solid rgba(0,0,0,.125);">
      @each('partials.auction.bid', $auction->bids ,'bid')
    </ol>
  </div>
  <div class="tab-pane show active" id="pills-chat" role="tabpanel" aria-labelledby="pills-chat-tab">
    <ol id="comments-list" class="list-group rounded-0 hide-scroll" style="overflow-y: scroll; max-height: 40vh; border-top: 1px solid rgba(0,0,0,.125); border-bottom: 1px solid rgba(0,0,0,.125);">
      @each('partials.auction.comment', $auction->comments ,'comment')
    </ol>
    <div class="d-flex bg-white align-content-center mt-1">
      <form class="w-100" id="send-comment-form">
        <label for="send-comment" class="form-label text-primary">Message:</label>
        <textarea class="form-control" id="send-comment" name="comment" rows="1" minlength="1" maxlength="300" required></textarea>
        <button type="submit" class="btn btn-primary mt-3 float-right">Send</button>
        <div id="comment-errors" onclick="this.hidden = !this.hidden" class="alert alert-danger alert-dismissible fade show my-3 p-1 px-2 mr-2 float-left" role="alert" hidden>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="buy-now" tabindex="-1" aria-labelledby="buy-now" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="/auctions/{{$auction->id}}/bids" class="modal-body text-primary">
        {{ csrf_field() }}
        <input hidden type="text" name="bid_type" value="buy-now">
        <input type="number" hidden name="id" id="buy-now-form-auction-id" value="{{ $auction->id }}">
        Value: {{ $auction->buynow }} $
        <div class="d-flex justify-content-end">
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="submit" class="btn btn-dark">Buy Now</button>
        </div>
        <input hidden type="number" name="value" id="buy-now-form-value" value="{{ $auction->buynow }}">
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="place-bid" tabindex="-1" aria-labelledby="place-bid" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="/auctions/{{$auction->id}}/bids" class="modal-body text-primary">
        {{ csrf_field() }}
        <input hidden type="text" name="bid_type" value="bid">
        <input type="number" hidden name="id" id="bid-form-auction-id" value="{{ $auction->id }}">
        <div class="d-flex flex-column">
        <div>
        <label class="form-check-label mt-2 text-primary">
          Bid Value:
        </label>
        <?php
        $highest_bid = $auction->highest_bid();
        $value = !is_null($highest_bid) ? $highest_bid->value + 0.01 : $auction->startingprice;
        ?>
        <input type="number" id="bid-value" min="{{ $value }}" placeholder="100" step="0.01" name="value" id="bid-form-value" required value="{{ $value }}">
        </div>
        @if(!is_null($auction->buynow))
        <span id="buy-now-warning" class="mt-2" style="color: grey;" data-buynow="{{$auction->buynow}}" hidden>
        Your bid is greater than the Buy Now value. This will end the auction immediately with a final bid value equal to {{$auction->buynow}}$.
        </span>
        @endif
        </div>
        <div class="d-flex justify-content-end mt-3">
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="submit" class="btn btn-success">Place Bid</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="report-user" tabindex="-1" aria-labelledby="report-user" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">What is the issue?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="modal-form" method="POST" @if(!is_null($auction->seller))action="/users/{{ $auction->seller_username() }}/report"@endif class="modal-body text-primary">
      <p>You are about to report this user. State your the reasons below.</p>
        {{ csrf_field() }}
        <input type="number" hidden id="location-input" name="location" required value="2"></input>
        <input type="number" hidden id="id-input" name="id" required value="{{ $auction->id }}"></input>
        <label class="form-check-label mt-2 text-primary" for="reason">
          Message:
        </label>
        <textarea class="form-control" name="reason" id="reason" rows="3" placeholder="Write here your reasons..." required></textarea>
        <div class="d-flex justify-content-end mt-3">
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

@if(Auth::check() && $show_rate)
<!-- Modal -->
<div class="modal fade show" id="show-rate" tabindex="-1" aria-labelledby="show-rate">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">RATE THIS AUCTION</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="/auctions/{{$auction->id}}/rate" class="modal-body text-primary">
        {{ csrf_field() }}
        <span>Congratulations!<br>You were the winner of this auction.</span>
        <br>
        <span>Give it a rating:</span>
        <div class="rating">
          <input type="radio" name="rating" value="5" id="5" required>
          <label for="5">☆</label> 
          <input type="radio" name="rating" value="4" id="4" required>
          <label for="4">☆</label> 
          <input type="radio" name="rating" value="3" id="3" required>
          <label for="3">☆</label> 
          <input type="radio" name="rating" value="2" id="2" required>
          <label for="2">☆</label> 
          <input type="radio" name="rating" value="1" id="1" required>
          <label for="1">☆</label>
        </div>
        <label class="form-check-label mt-2 text-primary" for="comment">
          Comment:
        </label>
        <textarea class="form-control" name="comment" id="comment" rows="3" min="1" required></textarea>
          <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
            <button type="submit" class="btn btn-success">Leave Rating</button>
          </div>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" defer>
  button = document.querySelector("#rating-button")

  if (button) {
    setTimeout(() => {
      button.click();
    }, 2000)
  }
</script>
@endif


@endsection