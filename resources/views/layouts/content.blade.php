@extends('layouts.app')

@section('header')
@include('layouts.header')
@endsection

@section('content')

<div class="container-lg text-primary overflow-auto my-5 fixed-footer" style="margin-top: 8rem !important;">

    @yield('div_content')

</div>

@endsection

@section('footer')
@include('layouts.footer')
@endsection