@php
$myProfile = Auth::user()->username == $user->username;
@endphp
<h1 class="w-100 text-primary pb-4 text-center">
@if($myProfile) My
@else User
@endif
 Profile</h1>
@if($myProfile && Auth::user()->banned)
<div class="alert alert-danger alert-dismissible fade show mb-5 mx-auto p-1 px-2" style="width: fit-content;" role="alert">
  This account is banned. For more information contact the website administration.
</div>
@endif
<!-- Section: Info -->
<section class="row text-center">
    <div class="col-0 col-sm-6 align-self-center text-sm-right">
      <img src="{{ $user->image }}" class="rounded z-depth-1-half img-fluid" alt="Sample avatar" style="min-height:200px;height:200px;min-width:200px;width:200">
    </div>
    <div class="col-0 col-sm-6 text-sm-left">
      <h3 class="font-weight-bold dark-grey-text my-4 text-primary">{{ $user->name }}</h3>
      <h5 class="text-lowercase grey-text mb-3 text-muted"><strong>{{ $user->email }}</strong></h5>
      <div class="dark-grey-text my-4 text-primary">
        <h5 class="font-weight-bold dark-grey-text my-4 text-primary">Rating:
        @for ($i = 1; $i <= 5; $i++)
          @if ($i <= round($user->rating_value()))
            <i class="fas fa-star"></i>
          @else
            <i class="far fa-star"></i>
          @endif
        @endfor
        ({{ $user->num_ratings() }} votes)</h5>
      </div>
      <a href="/users/{{$user->username}}/edit" class="mr-sm-5"><button class="btn btn-dark">Edit Profile</button></a>
    </div>
</section>
<!-- Section: Statistics -->
<section class="container mt-5">
  <h2 class="w-100 text-primary mb-4 text-center">Statistics</h2>
  <div class="row justify-content-center">
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Money Spent</h5>
          <p class="card-text text-primary text-center display-6">427€</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Auctions Won</h5>
          <p class="card-text text-primary text-center display-6">4</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Bids Made</h5>
          <p class="card-text text-primary text-center display-6">23</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mt-0 mt-sm-4">
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Money Earned</h5>
          <p class="card-text text-primary text-center display-6">243€</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Models Sold</h5>
          <p class="card-text text-primary text-center display-6">2</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Users Rated</h5>
          <p class="card-text text-primary text-center display-6">14</p>
        </div>
      </div>
    </div>
  </div>
</section>