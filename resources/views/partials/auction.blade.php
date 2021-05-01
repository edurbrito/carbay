<div class="col scale-objects-xs">
    <a href="/auctions/{{ $auction->id }}" class="text-decoration-none">
        <div class="card h-100 rounded-0" id="auction-{{ $auction->id }}">
            @if(!is_null($auction->first_image()))<img src="{{$auction->first_image()->url}}" class="card-img-top">@endif
            <div class="card-body text-primary">
                <h5 class="card-title text-center">{{ $auction->title }}</h5>
                <div class="card-text mb-0">
                <p title="Time Remaining" id="time-remaining" data-time="{{$auction->finaldate}}" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> <span id="time-remaining-value">{{ $auction->time_remaining() }}</span></p>
                    <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> @if(!is_null($auction->highest_bid())){{ $auction->highest_bid_value() }}@else None @endif</p>
                    @if(!is_null($auction->buynow))<p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> {{ $auction->buy_now() }}</p>@endif
                    <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/users/{{ $auction->seller_name() }}"><i class="far fa-user"></i> {{ $auction->seller->username }} @if($auction->seller->rating_value() > 0 )(<i class="far fa-star"></i> {{ $auction->seller->rating_value() }})@endif</a>
                </div>
            </div>
        </div>
    </a>
</div>