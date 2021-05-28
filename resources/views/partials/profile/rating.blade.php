<li class="list-group-item">
    <div class="d-flex align-items-center justify-content-start rounded-0 flex-vertical">
      @if(!is_null($user))
      <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/users/{{ $user->username }}">
        <img src="{{ $user->image }}" width="36px">
        <span class="text-primary ml-3">{{ $user->username }}</span>
      </a>
      @else
      <img src="/images/banned.png" width="36px">
      <span class="text-primary ml-3">[deleted]</span>
      @endif
      <div class="btn-group ml-sm-auto" role="group" aria-label="User Management Buttons">
        <h5 class="font-weight-bold text-primary my-auto">Rated:
        @for ($i = 1; $i <= 5; $i++)
          @if ($i <= round($rating->value))
            <i class="fas fa-star"></i>
          @else
            <i class="far fa-star"></i>
          @endif
        @endfor</h5>
      </div>
    </div>
    <p class="mt-3 text-primary text-justify">{{ $rating->comment }}</p>
  </li>