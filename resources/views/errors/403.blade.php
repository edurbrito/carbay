@extends('layouts.content')

@section('div_content')

<body class="bg-primary" style="height: 100vh; background-image: url(https://pics.imcdb.org/2/ff7_003109_c44.jpg); background-repeat: no-repeat; background-size: cover; background-position: center; background-image: linear-gradient(to bottom, rgba(0,0,0,0.45) 0%,rgba(0,0,0,0.45) 100%), url(https://pics.imcdb.org/2/ff7_003109_c44.jpg);">

<h2 class="text-light">ERROR #403 - THIS ACTION IS UNAUTHORIZED</h2>
<h4 class="text-light">Did your brakes stop working?</h4>

<div class="force-fixed-bottom">
    <div class="d-flex flex-column justify-content-center p-5" style="background: linear-gradient(transparent, black);">
      <a class="btn btn-dark mx-auto" style="width: fit-content;" href="/auctions/search">Go Back to Search</a>
    </div>
    <nav class="navbar navbar-primary border-top border-dark" style="background-color: #000;">
      <div class="container-fluid d-flex justify-content-center">
        <a class="navbar-brand text-light" href="/about">About Us</a>
        <a class="navbar-brand text-light" href="/faqs">FAQs</a>
      </div>
    </nav>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

@endsection