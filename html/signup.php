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
                            <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        </div>
                        <input type="text" name="" class="form-control input_user" value="" placeholder="Name">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name="" class="form-control input_user" value="" placeholder="Username">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-at"></i></span>
                        </div>
                        <input type="text" name="" class="form-control input_user" value="" placeholder="Email">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="" class="form-control input_pass" value="" placeholder="Password">
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="text" name="" class="form-control input_user" value="" placeholder="Repeat Password">
                    </div>
                    <div class="d-flex justify-content-center mt-3 login_container">
                        <button class="btn btn-dark text-light text-center" type="button" name="button" class="btn login_btn">Sign Up</button>
                    </div>
                    <div class="mt-2">
                        <div class="d-flex justify-content-center mt-3 login_container">
                            <button class="btn btn-dark text-light text-center" type="button" name="button" class="btn login_btn">Sign Up with Google</button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="mt-2">
                <div class="d-flex justify-content-center links">
                    Already have an account? <a href="login.php" class="ml-2 text-danger">Log In</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include_once(__DIR__ . "/templates/footer.php");
?>