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
                    <a href="/search" class="text-decoration-none text-reset"><i class="fas fa-search"></i><span class="d-lg-none .d-xl-block"> Search</span></a>
                </li>
                @if(Auth::check())
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects"><a href="/create-auction" class="text-decoration-none text-reset"><i class="fas fa-plus"></i><span class="d-lg-none .d-xl-block"> Create Auction</span></li>
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects"><a data-bs-toggle="modal" data-bs-target="#notifications" class="text-decoration-none text-reset" style="cursor: pointer;"><i class="fas fa-bell"></i><span class="d-lg-none .d-xl-block"> Notifications</span></a></li>
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects-sm"><a href="/profile" class="text-decoration-none text-reset"><i class="fas fa-user-circle"></i> John Doe</a></li>
                <li class="nav-item navbar-brand mr-0 mr-lg-4 scale-objects"><a href="/index" class="text-decoration-none text-reset"><i class="fas fa-sign-out-alt"></i><span class="d-lg-none .d-xl-block"> Log Out</span></a></li>
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