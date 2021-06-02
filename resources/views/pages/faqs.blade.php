@extends('layouts.content')

@section('div_content')

<h1 class="text-primary text-center">FAQs</h1>

<div class="row-sm-12 col-md-12 mt-4">
    <p>
        <a class="btn btn-dark font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question1" role="button" aria-expanded="false" aria-controls="Question1">
            1. What is the FAQ page?
        </a>
    </p>
    <div class="collapse" id="Question1">
        <div class="card card-body text-primary font-weight-bold rounded-0">
            The FAQ (Frequently Asked Questions) is a page where we include the questions we believe to be more relevant if you are familiarized with our services.
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-4">
    <p>
        <a class="btn btn-dark font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question2" role="button" aria-expanded="false" aria-controls="Question2">
            2. How do I register in the website?
        </a>
    </p>
    <div class="collapse" id="Question2">
        <div class="card card-body text-primary font-weight-bold rounded-0">
            To register in the website simply click the top right button saying "SIGN UP". From there fill in the fields with your information.
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-4">
    <p>
        <a class="btn btn-dark font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question3" role="button" aria-expanded="false" aria-controls="Question3">
            3. Do I need to pay to create an account?
        </a>
    </p>
    <div class="collapse" id="Question3">
        <div class="card card-body text-primary font-weight-bold rounded-0">
            No! You can create an account completely free!
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-4">
    <p>
        <a class="btn btn-dark font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question4" role="button" aria-expanded="false" aria-controls="Question4">
            4. Why can't I make a bid?
        </a>
    </p>
    <div class="collapse mt-1" id="Question4">
        <div class="card card-body text-primary font-weight-bold rounded-0">
            You can only participate in auctions if you are logged in! If you do not own an account click "SIGN UP" on right top corner of this page and make your registration.
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-4">
    <p>
        <a class="btn btn-dark font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question5" role="button" aria-expanded="false" aria-controls="Question5">
            5. Are these real cars?
        </a>
    </p>
    <div class="collapse mt-1" id="Question5">
        <div class="card card-body text-primary font-weight-bold rounded-0">
            No. These are hand-made resin models of your favorite cars. The scale of these models vary from 1:8 to 1:64.
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-4">
    <p>
        <a class="btn btn-dark font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question6" role="button" aria-expanded="false" aria-controls="Question6">
            6. Can I delete my account
        </a>
    </p>
    <div class="collapse mt-1" id="Question6">
        <div class="card card-body text-primary font-weight-bold rounded-0">
            Yes. To delete your account go to My Profile and click the Delete Profile button. Be aware you will not be able to login anymore.
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-4">
    <p>
        <a class="btn btn-dark font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question7" role="button" aria-expanded="false" aria-controls="Question7">
            7. How can I create my own auctions?
        </a>
    </p>
    <div class="collapse mt-1" id="Question7">
        <div class="card card-body text-primary font-weight-bold rounded-0">
            You can only create new auctions if you are logged in! If you do not own an account click "SIGN UP" on right top corner of this page and make your registration. Then, click in the + (Plus) button from the navigation bar and proceed to create a new auction.
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-0 text-center">
    <img alt="CarBay" src="/images/logo.png" class="m-auto" style="max-height: 200px;">
</div>

@endsection