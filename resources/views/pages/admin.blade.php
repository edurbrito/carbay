@extends('layouts.content')

@push('scripts')
<script src="{{ asset('js/admin.js') }}" defer></script>
@endpush

@section('div_content')

<h1 class="text-center">Admin Panel</h1>
<div class="d-flex align-items-start flex-vertical mt-sm-5">
    <div class="nav flex-column nav-pills me-3 border-right p-3 flex-horizontal" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <button class="nav-link text-primary rounded-0 mb-3 active btn-admin" id="v-pills-users-tab" data-bs-toggle="pill" data-bs-target="#v-pills-users" type="button" role="tab" aria-controls="v-pills-users" aria-selected="true">Users<span class="d-none d-sm-block"> Management</span></button>
        <button class="nav-link text-primary rounded-0 mb-3 btn-admin" id="v-pills-auctions-tab" data-bs-toggle="pill" data-bs-target="#v-pills-auctions" type="button" role="tab" aria-controls="v-pills-auctions" aria-selected="false">Auctions<span class="d-none d-sm-block"> Management</span></button>
        <button class="nav-link text-primary rounded-0 mb-3 btn-admin" id="v-pills-reports-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reports" type="button" role="tab" aria-controls="v-pills-reports" aria-selected="false">Reports</button>
    </div>
    <div class="tab-content w-100" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-users" role="tabpanel" aria-labelledby="v-pills-users-tab">
            @include('pages.admin.user-management')
        </div>
        <div class="tab-pane fade" id="v-pills-auctions" role="tabpanel" aria-labelledby="v-pills-auctions-tab">
            @include('pages.admin.auction-management')
        </div>
        <div class="tab-pane fade" id="v-pills-reports" role="tabpanel" aria-labelledby="v-pills-reports-tab">
            @include('pages.admin.reports')
        </div>
    </div>
</div>

@endsection