<nav class="navbar @if(!Request::is('/')) fixed-top @endif navbar-expand-lg navbar-primary bg-primary text-light border-bottom border-dark" style="background-color:rgba(0, 0, 0, 0.9) !important;">
    <div class="container-fluid">
        <a class="navbar-brand text-light scale-objects-xs" href="/">
            <img alt="CarBay" src="/images/icon.png" style="max-height: 36px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav d-flex justify-content-end align-items-center w-100">
                <li class="nav-item mr-0 mr-lg-4 navbar-brand scale-objects">
                    <a title="Search" href="/auctions/search" class="text-decoration-none text-reset"><i class="fas fa-search"></i><span class="d-lg-none .d-xl-block"> Search</span></a>
                </li>
                @if(Auth::check())
                @if(Auth::user()->admin)
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects"><a title="Admin Panel" href="/admin" class="text-decoration-none text-reset"><i class="fas fa-user-shield"></i><span class="d-lg-none .d-xl-block"> Admin Panel</span></a></li>
                @else
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects"><a title="Create an Auction" href="/auctions/create" class="text-decoration-none text-reset"><i class="fas fa-plus"></i><span class="d-lg-none .d-xl-block"> Create Auction</span></li>
                @endif
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects d-md-none"><a title="Notifications" data-bs-toggle="modal" data-bs-target="#notifications" class="text-decoration-none text-reset notify-wrapper" style="cursor: pointer;"><i class="fas fa-bell"></i><span class="notify-badge" hidden>0</span><span class="d-lg-none .d-xl-block"> Notifications</span></a></li>
                <div class="dropdown d-none d-md-block">
                    <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects dropdown-toggle" style="right: 0; left: auto;" type="button" id="dropdown-notifications" data-bs-toggle="dropdown" aria-expanded="false">
                        <a title="Notifications" class="text-decoration-none text-reset notify-wrapper" style="cursor: pointer;">
                            <i class="fas fa-bell"></i>
                            <span class="notify-badge" hidden>•</span>
                            <span class="d-lg-none .d-xl-block"> Notifications</span>
                        </a>
                    </li>
                    <ol class="dropdown-menu hide-scroll p-0 rounded-0" style="right: 0; left: auto;" aria-labelledby="dropdown-notifications">
                        <div class="notifications-list hide-scroll" style="overflow-y: scroll; max-height: 200px;">
                            <li><button class="dropdown-item px-6" type="button">Nothing here for you...</button></li>
                        </div>
                        <button class="btn-sm btn-primary border-0 py-1 fs-6 w-100 clear-all">Clear all</button>
                    </ol>
                </div>
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects-sm"><a href="/users/{{ Auth::user()->username }}" class="text-decoration-none text-reset"><i class="fas fa-user-circle"></i> {{ Auth::user()->username }}</a></li>
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects"><a href="/logout" class="text-decoration-none text-reset"><i class="fas fa-sign-out-alt"></i><span class="d-lg-none .d-xl-block"> Log Out</span></a></li>
                @else
                <li class="nav-item navbar-brand mr-0 mr-lg-4">
                    <a class="text-light" href="/login">
                        Log In
                    </a>
                </li>
                <li class="nav-item navbar-brand mr-0 mr-lg-4">
                    <a class="text-light" href="/signup">
                        Sign Up
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@if(Auth::check())
<!-- Modal -->
<div class="modal fade" id="notifications" tabindex="-1" aria-labelledby="notifications" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifications">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-1">
                <ol class="list-group rounded-0 border-0 py-2 hide-scroll">
                    <div class="notifications-list hide-scroll" style="overflow-y: scroll; max-height: 300px;">
                        <li><button class="dropdown-item px-6" type="button">Nothing here for you...</button></li>
                    </div>
                    <button class="btn-sm btn-secondary border-0 py-1 fs-6 w-100 clear-all">Clear all</button>
                </ol>
            </div>
        </div>
    </div>
</div>
@endif