<label for="search" class="form-label text-primary">Search:</label>
<input type="text" class="form-control w-100" id="search" placeholder="Type Something">
<div class="container-fluid px-0 my-3">
    <ol class="list-group rounded-0">
        <li class="list-group-item text-primary">
            <div class="d-flex align-items-center justify-content-start rounded-0 flex-vertical">
                <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/profile.php">
                    <img src="https://images.theconversation.com/files/304864/original/file-20191203-67028-qfiw3k.jpeg?ixlib=rb-1.1.0&rect=638%2C2%2C795%2C745&q=45&auto=format&w=496&fit=clip" width="36px">
                    <span class="text-primary ml-3">John Doe</span>
                </a>
                <i class="fas fa-exclamation-circle mx-2"></i>Unread
                <div class="ml-sm-auto">
                <a type="button" class="btn btn-secondary mr-2" href="/help.php">Full History</a>
                <button class="btn btn-primary" data-bs-toggle="collapse" href="#Question1" role="button" aria-expanded="true" aria-controls="Question1">Actions</button>
                </div>
            </div>
            <p class="mt-3 text-primary text-justify">I've just won an auction, it's my first time on this website. What should I do now? Will I be contacted by the website or should I reach the seller by his email?</p>
            <form class="row collapse hide" id="Question1">
                <div class="col">
                    <label for="send-message" class="form-label text-primary">Your Message:</label>
                    <textarea class="form-control p-1 p-sm-3" id="send-message" rows="6" required></textarea>
                </div>

                <div class="col-auto d-flex flex-column mt-2 justify-content-end">
                    <button type="button" class="btn btn-primary mt-3 mb-0 float-right">Mark as Read</button>
                    <button type="submit" class="btn btn-success mt-3 float-right">Send</button>
                </div>
            </form>
        </li>

        <li class="list-group-item text-primary">
            <div class="d-flex align-items-center justify-content-start rounded-0 flex-vertical">
                <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/profile.php">
                    <img src="https://static.wikia.nocookie.net/mrbean/images/4/4b/Mr_beans_holiday_ver2.jpg" width="36px">
                    <span class="text-primary ml-3">Mary Rose</span>
                </a>
                <i class="fas fa-exclamation-circle mx-2"></i>Unread
                <div class="ml-sm-auto">
                <a type="button" class="btn btn-secondary mr-2" href="/help.php">Full History</a>
                <button class="btn btn-primary" data-bs-toggle="collapse" href="#Question2" role="button" aria-expanded="true" aria-controls="Question2">Actions</button>
                </div>
            </div>
            <p class="mt-3 text-primary text-justify">There's an inappropriate comment on my profile page, some user left there a link that looks suspicious! What could I do to get it checked by some admin?</p>
            <form class="row collapse hide" id="Question2">
                <div class="col">
                    <label for="send-message" class="form-label text-primary">Your Message:</label>
                    <textarea class="form-control p-1 p-sm-3" id="send-message" rows="6" required></textarea>
                </div>

                <div class="col-auto d-flex flex-column mt-2 justify-content-end">
                    <button type="button" class="btn btn-primary mt-3 mb-0 float-right">Mark as Read</button>
                    <button type="submit" class="btn btn-success mt-3 float-right">Send</button>
                </div>
            </form>
        </li>

        <li class="list-group-item text-primary">
            <div class="d-flex align-items-center justify-content-start rounded-0 flex-vertical">
                <a class="d-flex align-items-center justify-content-start mb-3 mb-sm-0" href="/profile.php">
                    <img src="https://downloadwap.com/thumbs4/ringtones/covers/s/mrbean5.jpg" width="36px">
                    <span class="text-primary ml-3">Anthony Taylor</span>
                </a>
                <i class="fas fa-check mx-2"></i>Read
                <div class="ml-sm-auto">
                <a type="button" class="btn btn-secondary mr-2" href="/help.php">Full History</a>
                <button class="btn btn-primary" data-bs-toggle="collapse" href="#Question3" role="button" aria-expanded="true" aria-controls="Question3">Actions</button>
                </div>
            </div>
            <p class="mt-3 text-primary text-justify">What does the favorite auctions functionality do? Will I be notified of its main events?</p>
            <form class="row collapse hide" id="Question3">
                <div class="col">
                    <label for="send-message" class="form-label text-primary">Your Message:</label>
                    <textarea class="form-control p-1 p-sm-3" id="send-message" rows="6" required></textarea>
                </div>

                <div class="col-auto d-flex flex-column mt-2 justify-content-end">
                    <button type="submit" class="btn btn-success mt-3 float-right">Send</button>
                </div>
            </form>
        </li>
    </ol>
</div>