<?php
include_once(__DIR__ .  "/templates/header-logged-in.php");
breadcrum();
?>
<h1 class="text-center text-light">Your Questions</h1>
<div class="d-flex my-5 flex-shrink-1 flex-column" style="max-height: 50vh; overflow-y: auto; padding: 1rem;">
<style scoped>

@media (max-width: 600px) {
    .limited-width {
       max-width: 85%;
    }
}

@media (min-width: 600px) {
    .limited-width {
       max-width: 65%;
    }
}
</style>
    <div class="card rounded-0 w-auto align-self-start my-3 limited-width">
        <div class="card-body">
            <blockquote class="blockquote mb-0 text-dark">
                <p>Hello, I need some help with my account settings. I want to change the password but I don't know how to do it.</p>
                <footer class="blockquote-footer">You, 2021/03/01</footer>
            </blockquote>
        </div>
    </div>

    <div class="card rounded-0 w-auto align-self-end my-3 limited-width">
        <div class="card-body">
            <blockquote class="blockquote mb-0 text-dark">
                <p>Hello Mr. John, thank you for contacting us. I will guide you with that and help you change your password. Firstly, you need to go to your profile. Then, click on the "Edit" button, the one with a pencil icon. After that, a page with all the fields to change your password will appear and you only need to fill them and click "Save".<br>Any doubts, just ask. We are here to help :)</p>
                <footer class="blockquote-footer">Admin1, 2021/03/02</footer>
            </blockquote>
        </div>
    </div>

    <div class="card rounded-0 w-auto align-self-start my-3 limited-width">
        <div class="card-body">
            <blockquote class="blockquote mb-0 text-dark">
                <p>Thank you so much! I made it!</p>
                <footer class="blockquote-footer">You, 2021/03/02</footer>
            </blockquote>
        </div>
    </div>

    <div class="card rounded-0 w-auto align-self-start my-3 limited-width">
        <div class="card-body">
            <blockquote class="blockquote mb-0 text-dark">
                <p>Thank you so much! I made it!</p>
                <footer class="blockquote-footer">You, 2021/03/02</footer>
            </blockquote>
        </div>
    </div>
</div>

<div>
    <label for="exampleFormControlTextarea1" class="form-label">Message:</label>
    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
    <button type="button" class="btn btn-dark mt-3 float-right">Send</button>
</div>

<?php
include_once(__DIR__ . "/templates/footer-logged-in.php");
?>