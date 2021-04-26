
function update_time_remaining() {
    let auctions = document.querySelectorAll("#time-remaining")

    for (const auction of auctions) {
        let final_date = auction.getAttribute("data-time");
        let date2 = new Date(final_date);
        let date1 = new Date();
        var diff = new Date(date2.getTime() - date1.getTime());
        var new_time = `${Math.floor(diff.getTime() / (1000 * 3600 * 24))}d ${diff.getHours()}h ${diff.getMinutes()}m ${diff.getSeconds()}s`;

        auction.querySelector("#time-remaining-value").innerHTML = new_time;
    }
}

setInterval(update_time_remaining, 1000)