function update_bids() {

    div_bids = document.querySelector("#bids-list")

    last_bid_value = document.querySelector("#last-bid-value")

    div_bids.innerHTML = this.response;

    try {
        last_bid_value.innerHTML = div_bids.querySelector("li > p:last-child").innerHTML
    } catch (error) {
        
    }

}

function update_comments() {

    div_comments = document.querySelector("#comments-list")


    div_comments.innerHTML = this.response;

}

auction_id = document.querySelector("#auction-head").getAttribute("data-id")

function update_content() {
    let times = document.querySelectorAll("#time-remaining")

    for (const time of times) {
        let final_date = time.getAttribute("data-time");
        let date2 = new Date(final_date);
        let date1 = new Date();
        let diff = new Date(date2.getTime() - date1.getTime() - 1000*60*60);
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

function comment(e){
    e.preventDefault()

    sendAjaxRequest('POST', `/api/auctions/${auction_id}/comments`, {"comment" : text.value }, handle_comment, [])
}

function handle_comment(){
    text.value = ""
    result = JSON.parse(this.response).result
    
    errors = comment_form.querySelector("#comment-errors")

    if(result == "error"){
        window.location.replace("/login");
    }
    else if(result != "success")
    {
        errors.hidden = false
        errors.innerHTML = Object.values(result)[0]
    }
    else{
        errors.hidden = true
        errors.innerHTML = ""
    }
}