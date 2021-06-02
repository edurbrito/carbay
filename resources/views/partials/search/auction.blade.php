<div class="col scale-objects-xs">
    <a href="/auctions/{{ $auction->id }}" class="text-decoration-none">
        <div class="card h-100 rounded-0" id="auction-{{ $auction->id }}">
            @if(!is_null($auction->first_image()))<div class="card-img-top"
            style="border: none; height: 150px; background-image: url('{{$auction->first_image()->url}}'); background-size: cover; background-repeat: no-repeat; background-position: 50% 50%;"></div>@endif
            <div class="card-body text-primary">
                <h5 class="card-title text-center">{{ $auction->title }}</h5>
                <div class="card-text mb-0">
                <p title="Time Remaining" class="time-remaining" data-time="{{$auction->finaldate}}" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> <span class="time-remaining-value">{{ $auction->time_remaining() }}</span></p>
                    <p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> @if(!is_null($auction->highest_bid())){{ $auction->highest_bid_value() }}@else None @endif</p>
                    @if(!is_null($auction->buynow))<p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> {{ $auction->buy_now() }}</p>@endif
                    @if(!is_null($auction->seller))<a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/users/{{ $auction->seller_username() }}"><i class="far fa-user"></i> {{ $auction->seller_username() }} @if($auction->seller->rating_value() > 0 )(<i class="far fa-star"></i> {{ $auction->seller->rating_value() }})@endif</a>
                    @else
                    <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-user"></i> [deleted] </a>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>