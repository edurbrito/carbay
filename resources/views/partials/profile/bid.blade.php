<li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
    <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/auctions/{{$bid->bidAuction->id}}">
        <img src="{{ $bid->bidAuction->first_image()->url }}" width="36px">
        <span class="text-primary ml-3 fs-4">{{ $bid->bidAuction->title }}</span>
    </a>
    <div class="btn-group ml-sm-auto" role="group" aria-label="User Management Buttons">
        <p class="text-primary fs-4 mb-0">Value: {{$bid->value}}$</p>
    </div>
</li>