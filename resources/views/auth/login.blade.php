@extends('layouts.content')

@section('div_content')
<h1 class="text-center mb-5">Log In</h1>

<div class="container">
    <form class="d-flex justify-content-center flex-column w-100 responsive-form m-auto" method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}
        <div class="input-group mb-3 rounded-0">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-at"></i></span>
            </div>
            <input id="email" type="email" name="email" class="form-control input_user" value="{{ old('email') }}" placeholder="example@email.com" required autofocus>

        </div>
        @if ($errors->has('email'))
            <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
            {{ $errors->first('email') }}
            </div>
        @endif
        <div class="input-group mb-3">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
            </div>
            <input id="password" type="password" name="password" class="form-control input_pass" placeholder="password" required>
        </div>
        @if ($errors->has('password'))
            <div onclick="this.hidden = true" class="alert alert-danger alert-dismissible fade show mb-3 p-1 px-2" role="alert">
            {{ $errors->first('password') }}
            </div>
        @endif
        <label class="d-flex w-100 align-items-center">
            <input type="checkbox" class="mr-1" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
            <a href="{{ route('password.forgot') }}" class="text-center ml-auto">Forgot your password?</a>
        </label>
        <button class="btn btn-primary align-self-center w-75" type="submit" name="button" class="btn">Log In</button>
        <span class="text-center mt-2">or Log In with </span>
        <button class="btn btn-dark align-self-center mt-2 w-75" type="button" name="button" class="btn">Google</button>

        <span class="text-center mt-3">Don't have an account? <a href="{{ route('signup') }}" class="ml-2 text-danger">Sign Up</a></span>
    </form>
</div>
@endsection