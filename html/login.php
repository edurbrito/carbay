<?php
include_once(__DIR__ . "/templates/header.php");
breadcrum();
?>
<h1 class="text-center mb-5">Log In</h1>

<div class="container">
    <form class="d-flex justify-content-center flex-column w-100 responsive-form m-auto" action="/search.php">
        <div class="input-group mb-3 rounded-0">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-at"></i></span>
            </div>
            <input type="email" name="" class="form-control input_user" value="" placeholder="example@email.com" required>
        </div>
        <div class="input-group mb-3">
            <div class="input-group-append rounded-0">
                <span class="input-group-text rounded-0"><i class="fas fa-key"></i></span>
            </div>
            <input type="password" name="" class="form-control input_pass" value="" placeholder="password" required>
        </div>
        <button class="btn btn-primary align-self-center w-75" type="submit" name="button" class="btn">Log In</button>
        <span class="text-center mt-2">or Log In with </span>
        <button class="btn btn-dark align-self-center mt-2 w-75" type="button" name="button" class="btn">Google</button>

        <span class="text-center mt-3">Don't have an account? <a href="signup.php" class="ml-2 text-danger">Sign Up</a></span>
        <!-- <a href="#" class="text-light text-center">Forgot your password?</a> -->
    </form>
</div>

<?php
include_once(__DIR__ . "/templates/footer.php");
?>