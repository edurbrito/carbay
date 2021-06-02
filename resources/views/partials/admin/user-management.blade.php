<li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical">
    <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/users/{{ $user->username }}">
        <img src="{{ $user->image }}" width="36px">
        <span class="text-primary ml-3">{{ $user->name }}</span>
    </a>
    <div class="btn-group ml-sm-auto" role="group" aria-label="User Management Buttons">
    @if(!$user->admin)
        @if(!$user->banned)<button type="button" data-username="{{ $user->username }}" data-name="{{ $user->name }}" style="min-width: 100px;" class="btn btn-danger mr-1 ban-button" data-bs-toggle="modal" data-bs-target="#ban-user" role="button">Ban</button>
        @else<button type="button" data-username="{{ $user->username }}" data-name="{{ $user->name }}" style="min-width: 100px;" class="btn btn-success mr-1 ban-button" data-bs-toggle="modal" data-bs-target="#ban-user" role="button">Unban</button>
        @endif
    @endif
        @if(!$user->admin)<button type="button" data-username="{{ $user->username }}" data-name="{{ $user->name }}" style="min-width: 150px;" class="btn btn-secondary mr-1 make-admin-button" data-bs-toggle="modal" data-bs-target="#make-admin" role="button">Make Admin</button>
        @else<button type="button" data-username="{{ $user->username }}" data-name="{{ $user->name }}" style="min-width: 150px;" class="btn btn-primary mr-1 make-admin-button" data-bs-toggle="modal" data-bs-target="#make-admin" role="button">Revoke Admin</button>
        @endif
    </div>
</li>