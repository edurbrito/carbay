<li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
    <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/auctions/{{$auction->id}}">
        <img src="{{ $auction->first_image()->url }}" width="36px">
        <span class="text-primary ml-3 fs-4 ">{{ $auction->title }}</span>

    </a>
    <div class="btn-group ml-sm-auto" role="group" aria-label="User Management Buttons">
        @if($auction->suspend)
        <i class="fas fa-ban align-self-center mr-2" style="color: red;"></i>
        <p class="text-primary fs-4 mb-0" style="color: red !important;">Suspended</p>
        @else
        <p class="text-primary fs-4 mb-0">Highest Bid: {{$auction->highest_bid_value()}}</p>
        @endif
    </div>
</li>