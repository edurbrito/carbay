function update_bids() {

    div_bids = document.querySelector("#bids-list")
    last_bid_value = document.querySelector("#last-bid-value")
    bid_value = document.querySelector("#bid-value")
    div_bids.innerHTML = JSON.parse(this.response).content;

    try {
        last_bid_value.innerHTML = div_bids.querySelector("li > p:last-child").innerHTML
        bid_value.innerHTML = div_bids.querySelector("li > p:last-child").innerHTML
    } catch (error) {
        
    }
}

function update_comments() {
    div_comments = document.querySelector("#comments-list")
    div_comments.innerHTML = JSON.parse(this.response).content;
    
    report_buttons = document.querySelectorAll(".report-button")
    for (let button of report_buttons) {
        button.addEventListener('click', report)
    }
}

auction_id = document.querySelector("#auction-head").getAttribute("data-id")

function update_content() {
    let times = document.querySelectorAll("#time-remaining")

    for (const time of times) {
        let final_date = time.getAttribute("data-time");
        let date2 = new Date(final_date);
        let date1 = new Date();
        let diff = new Date(date2.getTime() - date1.getTime());
        let new_time = `${Math.floor(diff.getTime() / (1000 * 3600 * 24))}d ${diff.getUTCHours()}h ${diff.getMinutes()}m ${diff.getSeconds()}s`;

        new_time = diff.getTime() < 0 ? "Ended" : new_time;
        
        time.querySelector("#time-remaining-value").innerHTML = new_time;
    }

    sendAjaxRequest('GET', `/api/auctions/${auction_id}/bids`, {}, update_bids, [{name: 'Accept', value: 'text/html'}])
    sendAjaxRequest('GET', `/api/auctions/${auction_id}/comments`, {}, update_comments, [{name: 'Accept', value: 'text/html'}])
}

setInterval(update_content, 1000)

comment_form = document.querySelector("#send-comment-form")
comment_form.addEventListener('submit', comment)
text = comment_form.querySelector("#send-comment")
bid_value = document.querySelector("#bid-value")
buy_now_warning = document.querySelector("#buy-now-warning")

if(buy_now_warning != null)
    bid_value.addEventListener("change", () => {
        buy_now = buy_now_warning.getAttribute("data-buynow")
        if(parseInt(bid_value.value) >= parseInt(buy_now))
            buy_now_warning.hidden = false
        else
            buy_now_warning.hidden = true
    })

function comment(e) {
    e.preventDefault()

    sendAjaxRequest('POST', `/api/auctions/${auction_id}/comments`, {"comment" : text.value }, handle_comment, [])
}

function handle_comment() {
    text.value = ""
    response = JSON.parse(this.response)
    result = response.result

    errors = comment_form.querySelector("#comment-errors")

    if(result == "login") {
        window.location.replace("/login");
    }
    else if(result != "success")
    {
        errors.hidden = false
        errors.innerHTML = Object.values(response.content)[0]
    }
    else{
        errors.hidden = true
        errors.innerHTML = ""
    }
}

// ----- Add/Remove Favourite -----

favourite_auction = document.querySelector("#favourite-auction")

if(favourite_auction) {
    favourite_auction.addEventListener('click', () => {
        auction_id = favourite_auction.getAttribute('data-auction')
        icon = favourite_auction.querySelector("svg")
        action = icon.getAttribute('data-prefix') == "fas" ? 'remove' : 'add'
    
        sendAjaxRequest('POST',`/api/users/fav_auctions/${action}`, {'auction': auction_id}, fav_auction, [])
    })
}

function fav_auction() {

    response = JSON.parse(this.response)
    result = response.result
    icon = favourite_auction.querySelector("svg")
    action = icon.getAttribute('data-prefix') == "fas" ? 'remove' : 'add'
    
    if(result == "success")
    {
        if(action == 'remove')
        {
            icon.setAttribute('data-prefix', "far")
        }
        else if(action == 'add')
        {
            icon.setAttribute('data-prefix', "fas")
        }
    }
    else if(result == "login")
    {
        window.location.replace("/login")
    }
    else
    {
        console.log(response.content);
    }
}

// ----- Report User -----

modal_form = document.querySelector("#modal-form")

function report(){
    id = this.getAttribute("data-id")
    loc = this.getAttribute("data-location")
    username = this.getAttribute("data-username")

    modal_form.action = `/users/${username}/report`
    id_input = modal_form.querySelector("#id-input")
    location_input = modal_form.querySelector("#location-input")

    id_input.setAttribute("value", id)
    location_input.setAttribute("value", loc)
}