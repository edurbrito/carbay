@php
$myProfile = Auth::check() && (Auth::user()->username == $user->username);
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
    <h3 class="font-weight-bold dark-grey-text my-4 text-primary">
      @if(!$myProfile)
      <span id="favourite-seller" style="cursor: pointer;" data-seller="{{ $user->username }}">
        <i class="@if(Auth::check() && Auth::user()->hasFavouriteSeller($user->id)) fas @else far @endif fa-star"></i></span>
      @endif
      {{ $user->name }}
      @if(Auth::check() && !$myProfile)
      <i style="font-size: 0.8rem; color: red;" class="far fa-flag ml-2" data-bs-toggle="modal" data-bs-target="#report-user" role="button"></i>
      @endif
    </h3>
    @if($myProfile)
    <h5 class="text-lowercase grey-text mb-3 text-muted"><strong>{{ $user->email }}</strong></h5>
    @else
    <h5 class="text-lowercase grey-text mb-3 text-muted"><strong>{{ $user->username }}</strong></h5>
    @endif
    <div class="dark-grey-text my-4 text-primary">
      <h5 class="font-weight-bold dark-grey-text my-4 text-primary">Rating:
        @for ($i = 1; $i <= 5; $i++) @if ($i <=round($user->rating_value()))
          <i class="fas fa-star"></i>
          @else
          <i class="far fa-star"></i>
          @endif
          @endfor
          ({{ $user->num_ratings() }} votes)</h5>
    </div>
    @if($myProfile)
    <div class="btn-group ml-auto mt-auto" role="group" aria-label="Edit and Delete Profile Buttons">
      <a href="/users/{{ $user->username }}/edit" class="mr-2"><button class="btn btn-dark">Edit Profile</button></a>
      <button class="btn btn-dark" type="button" data-bs-toggle="modal" data-bs-target="#delete" role="button">Delete Profile</button>
    </div>
    @endif
    @if ($errors->has('error'))
    <div onclick="this.hidden = true" style="width: fit-content;" class="alert alert-danger alert-dismissible fade show my-3 p-1 px-2" role="alert">
      {{ $errors->first('error') }}
    </div>
    @elseif(session('success'))
    <div onclick="this.hidden = true" style="width: fit-content;" class="alert alert-success alert-dismissible fade show my-3 p-1 px-2" role="alert">
      {{ session('success')[0] }}
    </div>
    @endif
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
          <p class="card-text text-primary text-center display-6">{{ $user->money_spent() }}</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Auctions Won</h5>
          <p class="card-text text-primary text-center display-6">{{ $user->auctions_won() }}</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Bids Made</h5>
          <p class="card-text text-primary text-center display-6">{{ $user->bids->count() }}</p>
        </div>
      </div>
    </div>
  </div>

  <div class="row justify-content-center mt-0 mt-sm-4">
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Money Earned</h5>
          <p class="card-text text-primary text-center display-6">{{ $user->money_earned() }}</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4 mb-3 mb-sm-0">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Models Sold</h5>
          <p class="card-text text-primary text-center display-6">{{ $user->models_sold() }}</p>
        </div>
      </div>
    </div>
    <div class="col-12 col-sm-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title text-primary text-center">Users Rated</h5>
          <p class="card-text text-primary text-center display-6">{{ $user->users_rated() }}</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Modal -->
<div class="modal fade" id="report-user" tabindex="-1" aria-labelledby="report-user" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">What is the issue?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="/users/{{$user->username}}/report" class="modal-body text-primary">
        {{ csrf_field() }}
        <input type="number" hidden name="id" required value="1"></input>
        <input type="number" hidden name="location" required value="1"></input>
        <label class="form-check-label mt-2 text-primary" for="flexCheckChecked">
          Message:
        </label>
        <textarea class="form-control" name="reason" id="reason" rows="3" placeholder="Write here your reasons..." required></textarea>
        <div class="d-flex justify-content-end mt-3">
          <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
          <button type="submit" class="btn btn-success">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>