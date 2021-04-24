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
            <div class="input-group mb-3 text-danger">
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
            <div class="input-group mb-3 text-danger">
                {{ $errors->first('password') }}
            </div>
        @endif
        <label>
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
        </label>
        <button class="btn btn-primary align-self-center w-75" type="submit" name="button" class="btn">Log In</button>
        <span class="text-center mt-2">or Log In with </span>
        <button class="btn btn-dark align-self-center mt-2 w-75" type="button" name="button" class="btn">Google</button>

        <span class="text-center mt-3">Don't have an account? <a href="{{ route('signup') }}" class="ml-2 text-danger">Sign Up</a></span>
        <!-- <a href="#" class="text-light text-center">Forgot your password?</a> -->
    </form>
</div>
@endsection