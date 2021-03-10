<?php
include_once(__DIR__ .  "/templates/header-logged-in.php");
breadcrum();
?>
<h1 class="text-center">Your Questions</h1>
<div class="d-flex my-5 flex-shrink-1 flex-column hide-scroll" style="max-height: 35vh; overflow-y: auto; padding: 1rem;">
    <div class="card rounded-0 w-auto align-self-start my-3 limited-width">
        <div class="card-body">
            <blockquote class="blockquote mb-0 text-primary">
                <p>Hello, I need some help with my account settings. I want to change the password but I don't know how to do it.</p>
                <footer class="blockquote-footer">You, 2021/03/01</footer>
            </blockquote>
        </div>
    </div>

    <div class="card rounded-0 w-auto align-self-end my-3 limited-width">
        <div class="card-body">
            <blockquote class="blockquote mb-0 text-primary">
                <p>Hello Mr. John, thank you for contacting us. I will guide you with that and help you change your password. Firstly, you need to go to your profile. Then, click on the "Edit" button, the one with a pencil icon. After that, a page with all the fields to change your password will appear and you only need to fill them and click "Save".<br>Any doubts, just ask. We are here to help :)</p>
                <footer class="blockquote-footer">Admin1, 2021/03/02</footer>
            </blockquote>
        </div>
    </div>

    <div class="card rounded-0 w-auto align-self-start my-3 limited-width">
        <div class="card-body">
            <blockquote class="blockquote mb-0 text-primary">
                <p>Thank you so much! I made it!</p>
                <footer class="blockquote-footer">You, 2021/03/02</footer>
            </blockquote>
        </div>
    </div>

    <div class="card rounded-0 w-auto align-self-start my-3 limited-width">
        <div class="card-body">
            <blockquote class="blockquote mb-0 text-primary">
                <p>Thank you so much! I made it!</p>
                <footer class="blockquote-footer">You, 2021/03/02</footer>
            </blockquote>
        </div>
    </div>
</div>

<form action="/help.php">
    <label for="send-question" class="form-label text-primary">Message:</label>
    <textarea class="form-control" id="send-question" rows="3" required></textarea>
    <button type="submit" class="btn btn-success mt-3 float-right">Send</button>
</form>

<?php
include_once(__DIR__ . "/templates/footer-logged-in.php");
?>