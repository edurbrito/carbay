@extends('layouts.app')

@section('header')
@extends('layouts.header')
@endsection

@section('content')

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

<div class="container-lg text-primary overflow-auto my-5 fixed-footer" style="margin-top: 8rem !important;">

    @yield('div_content')

</div>

@endsection

@section('footer')
@extends('layouts.footer')
@endsection