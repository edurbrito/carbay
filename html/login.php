<?php
include_once(__DIR__ . "/templates/header.php");
breadcrum();
?>

<div class="container h-100">
    <div class="d-flex justify-content-center h-100">
        <div class="user_card">
            <div class="d-flex justify-content-center form_container">
                <form>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="text" name="" class="form-control input_user" value="" placeholder="example@email.com">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="" class="form-control input_pass" value="" placeholder="password">
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button class="btn btn-dark text-light text-center" type="button" name="button" class="btn login_btn">Login</button>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button class="btn btn-dark text-light text-center" type="button" name="button" class="btn login_btn">Log In with Google</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-4">
                <div class="d-flex justify-content-center links">
                    Don't have an account? <a href="signup.php" class="ml-2 text-danger">Sign Up</a>
                </div>
                <div class="d-flex justify-content-center links">
                    <a href="#" class="ml-2 text-light">Forgot your password?</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . "/templates/footer.php");
?>