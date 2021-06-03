<div class="carousel-item @if($active) active @endif">
    <a class="border-left p-3 d-flex flex-column text-decoration-none scale-objects-sm" href="/auctions/{{$auction->id}}">
        <h5 class="text-light">{{ $auction->title }}</h5>
        <div class="text-light" id="time-remaining" data-time="{{ $auction->finaldate }}">
            <i class="far fa-clock"></i>
            <span id="time-remaining-value">{{ $auction->time_remaining() }}</span>
        </div>
        <div class="text-light">
            <i class="fas fa-money-bill-wave-alt"></i>
            Last Bid: @if(!is_null($auction->highest_bid())){{ $auction->highest_bid_value() }}@else None @endif
        </div>
        @if(!is_null($auction->buynow))
        <div class="text-light">
            <i class="fas fa-wallet"></i>
            Buy Now: {{ $auction->buy_now() }}
        </div>
        @endif
    </a>
</div>