<?php
include_once(__DIR__ . "/templates/header.php");
breadcrum();
?>

<h1 class="text-primary text-center">FAQs</h1>

<div class="row-sm-12 col-md-12 mt-2  text-right mt-5">
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" class="btn btn-secondary btn-sm mr-2" data-bs-toggle="collapse" href="#Question1,#Question2,#Question3,#Question4">Expand All</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="collapse" href="#Question1,#Question2,#Question3,#Question4">Collapse All</button>
    </div>
</div>

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
            To register in the website simply click the top right button saying "SIGN UP". From there fill in the fields with your information or click the bottom option if you want to sign up with google services.
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
<div class="row-sm-12 col-md-12 mt-0 text-center">
    <img src="/images/logo.png" class="m-auto" style="max-height: 200px;">
    <!-- <h4 class="mt-3 text-primary">Thank You!</h4> -->
</div>

<?php
include_once(__DIR__ . "/templates/footer.php");
?>