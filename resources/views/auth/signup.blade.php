@extends('layouts.content')

@section('div_content')
<h1 class="text-center text-primary mb-5">Sign Up</h1>

<div class="container">
    <form class="d-flex justify-content-center flex-column w-100 responsive-form m-auto" method="POST" action="{{ route('signup') }}">
        {{ csrf_field() }}
        <div class="input-group mb-3">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-id-card"></i></span>
            </div>
            <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Name" required autofocus>
            @if ($errors->has('name'))
              <span class="error">
                  {{ $errors->first('name') }}
              </span>
            @endif
        </div>

        <div class="input-group mb-3">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-user"></i></span>
            </div>
            <input id="username" type="text" name="username" class="form-control" value="{{ old('username') }}" placeholder="Username" required>
            @if ($errors->has('username'))
              <span class="error">
                  {{ $errors->first('username') }}
              </span>
            @endif
        </div>

        <div class="input-group mb-3">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-at"></i></span>
            </div>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="example@email.com" required>
            @if ($errors->has('email'))
              <span class="error">
                  {{ $errors->first('email') }}
              </span>
            @endif
        </div>


        <div class="input-group mb-3">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
            </div>
            <input id="password" type="password" name="password" class="form-control" value="" placeholder="Password" required>
            @if ($errors->has('password'))
              <span class="error">
                  {{ $errors->first('password') }}
              </span>
            @endif
        </div>

        <div class="input-group mb-3">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
            </div>
            <input id="password-confirm" type="password" name="password-confirm" class="form-control" value="" placeholder="Repeat Password" required>
            @if ($errors->has('password-confirm'))
              <span class="error">
                  {{ $errors->first('password-confirm') }}
              </span>
            @endif
        </div>

        <button class="btn btn-primary align-self-center w-75" type="submit" name="button" class="btn">Sign Up</button>
        <span class="text-center mt-2">or Sign Up with </span>
        <button class="btn btn-dark align-self-center mt-2 w-75" type="button" name="button" class="btn">Google</button>

        <span class="text-center mt-3">Already have an account? <a href="{{ route('login') }}" class="ml-2 text-danger">Log In</a></span>
        <!-- <a href="#" class="text-light text-center">Forgot your password?</a> -->
    </form>
</div>
@endsection