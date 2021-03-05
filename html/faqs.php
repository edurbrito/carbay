<?php
include_once(__DIR__ . "/templates/header.php");
breadcrum();
?>

<h1 class="text-light text-center">FAQs</h1>

<div class="row-sm-12 col-md-12 mt-2  text-right mt-5">
    <div class="btn-group" role="group" aria-label="Basic example">
        <button type="button" style="background-color:#FFF" onMouseOut="this.style.background='#FFF'" onMouseOver="this.style.background='#d9544f'" class="btn btn-outline-danger btn-sm" data-bs-toggle="collapse" href="#Question1,#Question2,#Question3,#Question4">Expand All</button>
        <button type="button" style="background-color:#FFF" onMouseOut="this.style.background='#FFF'" onMouseOver="this.style.background='#d9544f'" class="btn btn-outline-danger btn-sm" data-bs-toggle="collapse" href="#Question1,#Question2,#Question3,#Question4">Collapse All</button>
    </div>
</div>

<div class="row-sm-12 col-md-12 mt-3">
    <p>
        <a class="btn btn-secondary font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question1" role="button" aria-expanded="false" aria-controls="Question1">
            What is the FAQ page?
        </a>
    </p>
    <div class="collapse" id="Question1">
        <div class="card card-body text-dark font-weight-bold">
            The FAQ (Frequently Asked Questions) is a page where we include the questions we believe to be more relevant if you are familiarized with our services.
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-2">
    <p>
        <a class="btn btn-secondary font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question2" role="button" aria-expanded="false" aria-controls="Question2">
            How do I register in the website?
        </a>
    </p>
    <div class="collapse" id="Question2">
        <div class="card card-body text-dark font-weight-bold">
            To register in the website simply click the top right button saying "SIGN UP". From there fill in the fields with your information or click the bottom option if you want to sign up with google services.
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-2">
    <p>
        <a class="btn btn-secondary font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question3" role="button" aria-expanded="false" aria-controls="Question3">
            Do I need to pay to create an account?
        </a>
    </p>
    <div class="collapse" id="Question3">
        <div class="card card-body text-dark font-weight-bold">
            No! You can create an account completely free!
        </div>
    </div>
</div>
<div class="row-sm-12 col-md-12 mt-2">
    <p>
        <a class="btn btn-secondary font-weight-bold col-md-12 text-left" data-bs-toggle="collapse" href="#Question4" role="button" aria-expanded="false" aria-controls="Question4">
            Why can't I make a bid?
        </a>
    </p>
    <div class="collapse" id="Question4">
        <div class="card card-body text-dark font-weight-bold">
            You can only participate in auctions if you are logged in! If you do not own an account click "SIGN UP" on right top corner of this page and make your registration.
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . "/templates/footer.php");
?>