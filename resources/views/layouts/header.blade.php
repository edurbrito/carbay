<nav class="navbar @if(!Request::is('/')) fixed-top @endif navbar-expand-lg navbar-primary bg-primary text-light border-bottom border-dark" style="background-color:rgba(0, 0, 0, 0.9) !important;">
    <div class="container-fluid">
        <a class="navbar-brand text-light scale-objects-xs" href="/">
            <img src="/images/icon.png" style="max-height: 36px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="navbar-nav d-flex justify-content-end align-items-center w-100">
                <li class="nav-item mr-0 mr-lg-4 navbar-brand scale-objects">
                    <a href="/auctions/search" class="text-decoration-none text-reset"><i class="fas fa-search"></i><span class="d-lg-none .d-xl-block"> Search</span></a>
                </li>
                @if(Auth::check())
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects"><a href="/auctions/create" class="text-decoration-none text-reset"><i class="fas fa-plus"></i><span class="d-lg-none .d-xl-block"> Create Auction</span></li>
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects"><a data-bs-toggle="modal" data-bs-target="#notifications" class="text-decoration-none text-reset" style="cursor: pointer;"><i class="fas fa-bell"></i><span class="d-lg-none .d-xl-block"> Notifications</span></a></li>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notifications">Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol class="list-group rounded-0 pr-sm-3 border-0">
                    <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical border-0 border-bottom">
                        <p class="text-primary fs-6 mb-0">Auction Ferrari 802 is almost at the end</p>
                    </li>
                    <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical border-0 border-bottom">
                        <p class="text-primary fs-6 mb-0">Your bid in Auction Ferrari 802 was surpassed</p>
                    </li>
                    <li class="list-group-item d-flex align-items-center justify-content-start rounded-0 flex-vertical border-0 border-bottom">
                        <p class="text-primary fs-6 mb-0">anthonyman created a new Auction</p>
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
@endif