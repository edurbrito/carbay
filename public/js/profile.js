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

    favourite_sellers.innerHTML = this.response;
}

// ----- Users Ratings -----

users_ratings_tab = document.querySelector("#v-pills-users-ratings-tab")

users_ratings_tab.addEventListener('click', ratings)

function ratings(e) {
    e.preventDefault()

    sendAjaxRequest('GET',`/api/users/${username.value}/ratings`, {}, rating_list, [{name: 'Accept', value: 'text/html'}])
}

function rating_list() {
    users_ratings = document.querySelector("#users-ratings-list")

    users_ratings.innerHTML = this.response;
}

// ----- Users Rated -----

users_rated_tab = document.querySelector("#v-pills-users-rated-tab")

users_rated_tab.addEventListener('click', rated)

function rated(e) {
    e.preventDefault()

    sendAjaxRequest('GET',`/api/users/${username.value}/rated`, {}, rated_list, [{name: 'Accept', value: 'text/html'}])
}

function rated_list() {
    users_rated = document.querySelector("#users-rated-list")

    users_rated.innerHTML = this.response;
}