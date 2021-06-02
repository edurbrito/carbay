@extends('layouts.content')

@push('scripts')
<script src="{{ asset('js/create.js') }}" defer></script>
@endpush

@section('div_content')

<h1 class="text-center">New Auction</h1>

<form class="row mt-5" method="POST" action="/auctions/create" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-12 col-sm-6">
        <div id="carouselIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators" id="carousel-indicators">
            </div>
            <div class="carousel-inner" id="carousel-inner">
            <div class="carousel-item active"><img src="/images/default.png" class="d-block w-100"></div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        <div class="input-group mb-3 mt-3">
            <div class="custom-file">
                <input type="file" accept="image/*" class="custom-file-input" id="auction-images" name="images[]" value="Upload Image" style="cursor: pointer;" multiple required>
                <label class="custom-file-label" for="images" style="cursor: pointer;">Upload Image</label>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 mt-4 mt-sm-0">
        <ul class="nav nav-pills mb-3 justify-content-start" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active btn-auction" id="pills-general-info-tab" data-bs-toggle="pill" data-bs-target="#pills-general-info" type="button" role="tab" aria-controls="pills-general-info" aria-selected="true">General Info</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link btn-auction" id="pills-description-tab" data-bs-toggle="pill" data-bs-target="#pills-description" type="button" role="tab" aria-controls="pills-description" aria-selected="false">Description</button>
            </li>
        </ul>
        <div class="tab-content text-primary d-flex flex-column" id="pills-tabContent">
            <div class="tab-pane show active" id="pills-general-info" role="tabpanel" aria-labelledby="pills-general-info-tab">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-0" id="inputGroup-sizing-default">Title</span>
                    </div>
                    <input value="{{ old('title') }}" type="text" name="title" class="form-control" aria-label="Default" aria-describedby="inputGroup-sizing-default" placeholder="Car Model A" required>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend rounded-0">
                                <span class="input-group-text rounded-0" id="start-bid">Starting Bid</span>
                            </div>
                            <input value=@if(!is_null(old('starting-price'))){{ old('starting-price') }}@else 1 @endif type="number" name="starting-price" min="1" max="100000" class="form-control" aria-label="Small" aria-describedby="start-bid" onchange="document.querySelector('#buy-now-value').value = parseInt(this.value) + 1" required>
                            <div class="input-group-append rounded-0">
                                <span class="input-group-text rounded-0">$</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="duration">Duration</span>
                            </div>
                            <input value=@if(!is_null(old('duration'))){{ old('duration') }}@else 1 @endif type="number" name="duration" min="1" max="15" class="form-control" aria-label="Small" aria-describedby="duration" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="inputGroup-sizing-sm">Days</span>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12 col-sm-6">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend rounded-0">
                                <span class="input-group-text rounded-0" id="start-date">Starting Date</span>
                            </div>
                            <input type="datetime-local" step="1" name="startDate" class="form-control rounded-0" aria-label="Small" aria-describedby="start-date" width="fit-content" min="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime(now())); ?>" value="<?php echo strftime('%Y-%m-%dT%H:%M:%S', strtotime(now()));  ?>" required>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <!-- <div class="col-12 col-sm-6">
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="duration">Duration</span>
                            </div>
                            <input type="number" name="duration" min="1" max="15" class="form-control" aria-label="Small" aria-describedby="duration" value="1" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text rounded-0" id="inputGroup-sizing-sm">Days</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-12 col-sm-6 row flex-row mb-3 pr-0">
                        <div class="col-6">
                        <input @if(!is_null(old('buy-now'))) checked @endif type="checkbox" id="buy-now" name="buy-now" onchange="document.getElementById('buy-now-input-group').hidden = !this.checked;">
                        <label for="buy-now">
                            Buy Now
                        </label>
                        </div>
                        <div class="input-group input-group-sm col-6 p-0" id="buy-now-input-group" @if(is_null(old('buy-now-value'))) hidden @endif>
                            <input value=@if(!is_null(old('buy-now-value'))){{ old('buy-now-value') }}@else 1 @endif type="number" name="buy-now-value" id="buy-now-value" min="1" max="1000000" class="form-control rounded-0" aria-label="Small" aria-describedby="buy-now" id="buy-now-value">
                            <div class="input-group-append">
                                <span class="input-group-text rounded-0" id="inputGroup-sizing-sm">$</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="pills-description" role="tabpanel" aria-labelledby="pills-description-tab">

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-0" id="inputGroup-sizing-default">Colour</span>
                    </div>
                    <input value="{{ old('colour') }}" type="text" name="colour" id="select-colour-input" list="select-colour" class="form-select rounded-0" required>
                    <datalist id="select-colour">
                    </datalist>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-0" id="inputGroup-sizing-default">Brand</span>
                    </div>
                    <input value="{{ old('brand') }}" type="text" name="brand" id="select-brand-input" list="select-brand" class="form-select rounded-0" required>
                    <datalist id="select-brand">
                    </datalist>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text rounded-0" id="inputGroup-sizing-default">Scale</span>
                    </div>
                    <select class="form-select rounded-0" aria-label="Available Scales" id="select-scale" name="scale">
                    </select>
                </div>
                
                <div class="form-group mt-3">
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="Write here the product description..." required>{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="btn-group ml-auto mt-auto" role="group" aria-label="Create Auction Buttons">
                <a role="button" class="btn btn-dark mr-1" href="/auctions/search">Discard</a>
                <button type="submit" class="btn btn-success">Publish</button>
            </div>            
            @if ($errors->any())
            <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show my-3 p-1 px-2" role="alert">
            {{ $errors->first() }}
            </div>
            @endif
        </form>
    </div>
</form>


@endsection