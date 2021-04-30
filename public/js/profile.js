// ----- Bid History -----

username = document.querySelector("#username")
bid_history_tab = document.querySelector("#v-pills-bid-history-tab")

bid_history_tab.addEventListener('click', bids)

function bids(e) {
    e.preventDefault()

    sendAjaxRequest('GET',`/api/users/${username.value}/bids`, {}, bid_list, [{name: 'Accept', value: 'text/html'}])
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

    sendAjaxRequest('GET',`/api/users/${username.value}/auctions`, {}, auction_list, [{name: 'Accept', value: 'text/html'}])
}

function auction_list() {
    created_auctions = document.querySelector("#created-auctions-list")

    console.log(this.response)

    created_auctions.innerHTML = this.response;
}

// ----- Favourite Auctions -----

favourite_auctions_tab = document.querySelector("#v-pills-favourite-auctions-tab")

favourite_auctions_tab.addEventListener('click', fav_auctions)

function fav_auctions(e) {
    e.preventDefault()

    sendAjaxRequest('GET',`/api/users/${username.value}/fav_auctions`, {}, fav_auction_list, [{name: 'Accept', value: 'text/html'}])
}

function fav_auction_list() {
    favourite_auctions = document.querySelector("#favourite-auctions-list")

    console.log(this.response)

    favourite_auctions.innerHTML = this.response;
}

// ----- Favourite Sellers -----

favourite_sellers_tab = document.querySelector("#v-pills-favourite-sellers-tab")

favourite_sellers_tab.addEventListener('click', fav_sellers)

function fav_sellers(e) {
    e.preventDefault()

    sendAjaxRequest('GET',`/api/users/${username.value}/fav_sellers`, {}, fav_seller_list, [{name: 'Accept', value: 'text/html'}])
}

function fav_seller_list() {
    favourite_sellers = document.querySelector("#favourite-sellers-list")

    console.log(this.response)

    favourite_sellers.innerHTML = this.response;
}