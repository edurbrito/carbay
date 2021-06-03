@extends('layouts.content')

@section('div_content')
<h1 class="text-center text-primary mb-5">Sign Up</h1>

<div class="container">
    <form class="d-flex justify-content-center flex-column w-100 responsive-form m-auto" method="POST" action="{{ route('signup') }}">
        {{ csrf_field() }}
        <div class="input-group mb-3" title="Name">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-id-card"></i></span>
            </div>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name" required autofocus>
        </div>
        @if ($errors->has('name'))
            <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
            {{ $errors->first('name') }}
            </div>
        @endif
        <div class="input-group mb-3" title="Username">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-user"></i></span>
            </div>
            <input id="username" type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Username" required>
        </div>
        @if ($errors->has('username'))
        <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
            {{ $errors->first('username') }}
            </div>
        @endif

        <div class="input-group mb-3" title="Email">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-at"></i></span>
            </div>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="example@email.com" required>
        </div>
        @if ($errors->has('email'))
        <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
            {{ $errors->first('email') }}
            </div>
        @endif

        <div class="input-group mb-3" title="Password">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
            </div>
            <input id="password" type="password" name="password" class="form-control" value="" placeholder="Password" required>
        </div>
        @if ($errors->has('password'))
        <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
            {{ $errors->first('password') }}
            </div>
        @endif

        <div class="input-group mb-3" title="Confirm Password">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
            </div>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" value="" placeholder="Repeat Password" required>
        </div>
        @if ($errors->has('password_confirmation'))
        <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
            {{ $errors->first('password_confirmation') }}
            </div>
        @endif

        <button class="btn btn-primary align-self-center w-75 mt-3" type="submit" name="button" class="btn">Sign Up</button>

        <span class="text-center mt-3">Already have an account? <a href="{{ route('login') }}" class="ml-2 text-danger">Log In</a></span>
    </form>
<div class="row-sm-12 col-md-12 mt-0 text-center">
    <img src="/images/logo.png" class="m-auto" style="max-height: 200px;">
</div>
</div>
@endsection