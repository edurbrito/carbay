<li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
    <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/auctions/{{$auction->id}}">
        <img src="{{ $auction->first_image()->url }}" width="36px">
        <span class="text-primary ml-3">{{ $auction->title }}</span>
    </a>
    <div class="btn-group ml-sm-auto" role="group" aria-label="Auction Management Buttons">
        @if(!$auction->suspend) 
        <button type="button" data-id="{{ $auction->id }}" data-auction="{{ $auction->title }}" class="btn btn-danger mr-1 suspend-button" style="min-width: 130px;" data-bs-toggle="modal" data-bs-target="#suspend" role="button">Suspend</button>
        @else
        <button type="button" data-id="{{ $auction->id }}" data-auction="{{ $auction->title }}" class="btn btn-success mr-1 suspend-button" style="min-width: 130px;" data-bs-toggle="modal" data-bs-target="#suspend" role="button">Unsuspend</button>
        @endif
        <button type="button" data-id="{{ $auction->id }}" data-auction="{{ $auction->title }}" data-finaldate="{{ $auction->finaldate }}" class="btn btn-secondary reschedule-button" data-bs-toggle="modal" data-bs-target="#reschedule" role="button" >Postpone</button>
    </div>
</li>