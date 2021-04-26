<div class="col scale-objects-xs">
    <a href="/auction/{{ $auction->id }}" class="text-decoration-none">
        <div class="card h-100 rounded-0" id="auction-{{ $auction->id }}">
            @if($auction->first_image()!== null )<img src="{{$auction->first_image()->url}}" class="card-img-top">@endif
            <div class="card-body text-primary">
                <h5 class="card-title text-center">{{ $auction->title }}</h5>
                <div class="card-text mb-0">
                <p title="Time Remaining" id="time-remaining" data-time="{{$auction->finaldate}}" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-clock"></i> <span id="time-remaining-value">{{$auction->time_remaining()}}</span></p>
                    @if($auction->highest_bid()!== null )<p title="Last Bid" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-money-bill-alt"></i> {{ $auction->highest_bid()->value }}$</p>@endif
                    @if(isset($auction->buynow))<p title="Buy Now" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;"><i class="far fa-credit-card"></i> {{ $auction->buynow }}$</p>@endif
                    <a title="Seller" data-bs-toggle="tooltip" data-bs-placement="right" style="width: fit-content;" href="/profile"><i class="far fa-user"></i> {{ $auction->seller->username }} @if($auction->seller->rating() > 0 )(<i class="far fa-star"></i> {{ $auction->seller->rating() }})@endif</a>
                </div>
            </div>
        </div>
    </a>
</div>