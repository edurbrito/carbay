@extends('layouts.head')

@section('body')

@if(View::hasSection('body_tag'))
  @yield('body_tag')
@else
<body class="bg-light">
@endif
  @yield('header')
  @yield('content')
  @yield('footer')
</body>

@endsection