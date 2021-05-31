@extends('layouts.content')

@push('scripts')
<script src="{{ asset('js/profile.js') }}" defer></script>
@endpush

@section('div_content')
@php
$myProfile = Auth::check() && (Auth::user()->username == $user->username);
@endphp
<!-- Section: Nav tabs -->
<input type="text" hidden id="username" name="username" value={{ $user->username }}>
<div class="d-flex align-items-start flex-vertical mt-sm-5" id="#colNav">
  <div class="nav flex-column nav-pills me-3 border-right p-3 flex-horizontal-profile d-sm-flex" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <button class="nav-link active text-primary btn-profile" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-created-auctions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-created-auctions" type="button" role="tab" aria-controls="v-pills-auctions-created" aria-selected="false">Auctions Created</button>
    @if($myProfile)
    <button class="nav-link text-primary btn-profile" id="v-pills-bid-history-tab" data-bs-toggle="pill" data-bs-target="#v-pills-bid-history" type="button" role="tab" aria-controls="v-pills-bid-history" aria-selected="false">Bid History</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-favourite-auctions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-favourite-auctions" type="button" role="tab" aria-controls="v-pills-favourite-auctions" aria-selected="false">Favourite Auctions</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-favourite-sellers-tab" data-bs-toggle="pill" data-bs-target="#v-pills-favourite-sellers" type="button" role="tab" aria-controls="v-pills-favourite-sellers" aria-selected="false">Favourite Sellers</button>
    @endif
    <button class="nav-link text-primary btn-profile" id="v-pills-users-ratings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-users-ratings" type="button" role="tab" aria-controls="v-pills-users-ratings" aria-selected="false">Users Ratings</button>
    <button class="nav-link text-primary btn-profile" id="v-pills-users-rated-tab" data-bs-toggle="pill" data-bs-target="#v-pills-users-rated" type="button" role="tab" aria-controls="v-pills-users-rated" aria-selected="false">Users Rated</button>
  </div>
  <div class="tab-content w-100" id="v-pills-tabContent">
    <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
      @include('pages.profile.profile-info')
    </div>
    <div class="tab-pane fade" id="v-pills-created-auctions" role="tabpanel" aria-labelledby="v-pills-created-auctions-tab">
      @include('pages.profile.created-auctions')
    </div>
    @if($myProfile)
    <div class="tab-pane fade" id="v-pills-bid-history" role="tabpanel" aria-labelledby="v-pills-bid-history-tab">
      @include('pages.profile.bid-history')
    </div>
    <div class="tab-pane fade" id="v-pills-favourite-auctions" role="tabpanel" aria-labelledby="v-pills-favourite-auctions-tab">
      @include('pages.profile.favourite-auctions')
    </div>
    <div class="tab-pane fade" id="v-pills-favourite-sellers" role="tabpanel" aria-labelledby="v-pills-favourite-sellers-tab">
      @include('pages.profile.favourite-sellers')
    </div>
    @endif
    <div class="tab-pane fade" id="v-pills-users-ratings" role="tabpanel" aria-labelledby="v-pills-users-ratings-tab">
      @include('pages.profile.users-ratings')
    </div>
    <div class="tab-pane fade" id="v-pills-users-rated" role="tabpanel" aria-labelledby="v-pills-users-rated-tab">
      @include('pages.profile.users-rated')
    </div>
  </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="delete" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">Are you sure?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-primary">
        <h6 class="text-danger fs-7 text-center">This action cannot be reversed.</h6>
        <br>
        <span>You can only delete your account if you do not have any ongoing auction or highest bids.</span>
        <br>
        <br>
        <span>Insert your password to complete the action:</span>

        <form action="/users/{{ $user->username }}/delete" method="POST">
          {{ csrf_field() }}
          {{ method_field('DELETE') }}
          <input id="password" type="password" name="password" class="form-control input_pass w-100 mb-2" placeholder="password" required>
          <div class="d-flex justify-content-end pt-2">
            <button type="button" class="btn btn-primary mr-2" data-bs-dismiss="modal" aria-label="Dismiss">Dismiss</button>
            <button class="btn btn-danger" type="submit" data-bs-dismiss="modal" aria-label="Dismiss" data-bs-toggle="modal" data-bs-target="#delete" role="button">Confirm</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection