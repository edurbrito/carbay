// ----- Bid History -----

username = document.querySelector("#username")
bid_history_tab = document.querySelector("#v-pills-bid-history-tab")

bid_history_tab.addEventListener('click', bids)

function bids(e) {
    e.preventDefault()

    sendAjaxRequest('GET',`/api/users/${username.value}/bids`, {}, bid_list, ['Accept', 'text/html'])
}

function bid_list() {
    bid_history = document.querySelector("#bid-history-list")

    bid_history.innerHTML = this.response;
}

// ----- Created Auctions -----

created_auctions_tab = document.querySelector("#v-pills-created-auctions-tab")

created_auctions_tab.addEventListener('click', auctions)

function auctions(e) {
    e.preventDefault()

    sendAjaxRequest('GET',`/api/users/${username.value}/auctions`, {}, auction_list, ['Accept', 'text/html'])
}

function auction_list() {
    created_auctions = document.querySelector("#created-auctions-list")

    console.log(this.response)

    created_auctions.innerHTML = this.response;
}