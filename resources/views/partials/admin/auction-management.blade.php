<li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
    <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/auctions/{{$auction->id}}">
        <img src="{{ $auction->first_image()->url }}" width="36px">
        <span class="text-primary ml-3">{{ $auction->title }}</span>
    </a>
    <div class="btn-group ml-sm-auto" role="group" aria-label="Auction Management Buttons">
        <button type="button" data-id="{{ $auction->id }}" data-auction="{{ $auction->title }}" class="btn btn-danger mr-1 suspend-button" data-bs-toggle="modal" data-bs-target="#suspend" role="button">Suspend</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reschedule" role="button" data-bs-toggle="modal" data-bs-target="#reschedule" role="button">Reschedule</button>
    </div>
</li>