// ----- Bid History -----

username = document.querySelector("#username")
bid_history_tab = document.querySelector("#v-pills-bid-history-tab")
if(bid_history_tab)
    bid_history_tab.addEventListener('click', bids)

function bids(e) {
    e.preventDefault()

    sendAjaxRequest('GET', `/api/users/${username.value}/bids`, {}, bid_list, [{ name: 'Accept', value: 'text/html' }])
}

function bid_list() {
    bid_history = document.querySelector("#bid-history-list")

    bid_history.innerHTML = JSON.parse(this.response).content;
}

// ----- Created Auctions -----

created_auctions_tab = document.querySelector("#v-pills-created-auctions-tab")

created_auctions_tab.addEventListener('click', auctions)

function auctions(e) {
    e.preventDefault()

    sendAjaxRequest('GET', `/api/users/${username.value}/auctions`, {}, auction_list, [{ name: 'Accept', value: 'text/html' }])
}

function auction_list() {
    created_auctions = document.querySelector("#created-auctions-list")

    created_auctions.innerHTML = JSON.parse(this.response).content;
}

// ----- Favourite Auctions -----

favourite_auctions_tab = document.querySelector("#v-pills-favourite-auctions-tab")
if(favourite_auctions_tab)
    favourite_auctions_tab.addEventListener('click', fav_auctions)

function fav_auctions(e) {
    if(e != null)
        e.preventDefault()

    sendAjaxRequest('GET', `/api/users/${username.value}/fav_auctions`, {}, fav_auction_list, [{ name: 'Accept', value: 'text/html' }])
}

function fav_auction_list() {
    favourite_auctions = document.querySelector("#favourite-auctions-list")

    favourite_auctions.innerHTML = JSON.parse(this.response).content;

    remove_auction_buttons = document.querySelectorAll(".remove-auction")
    for (let button of remove_auction_buttons) {
        button.addEventListener('click', remove_favourite_auction)
    }
}

// ----- Favourite Sellers -----

favourite_sellers_tab = document.querySelector("#v-pills-favourite-sellers-tab")
if(favourite_sellers_tab)
    favourite_sellers_tab.addEventListener('click', fav_sellers)

function fav_sellers(e) {
    if(e != null)
        e.preventDefault()

    sendAjaxRequest('GET', `/api/users/${username.value}/fav_sellers`, {}, fav_seller_list, [{ name: 'Accept', value: 'text/html' }])
}

function fav_seller_list() {
    favourite_sellers = document.querySelector("#favourite-sellers-list")

    favourite_sellers.innerHTML = JSON.parse(this.response).content;

    remove_seller_buttons = document.querySelectorAll(".remove-seller")
    for (let button of remove_seller_buttons) {
        button.addEventListener('click', remove_favourite_seller)
    }
}

// ----- Users Ratings -----

users_ratings_tab = document.querySelector("#v-pills-users-ratings-tab")

users_ratings_tab.addEventListener('click', ratings)

function ratings(e) {
    e.preventDefault()

    sendAjaxRequest('GET', `/api/users/${username.value}/ratings`, {}, rating_list, [{ name: 'Accept', value: 'text/html' }])
}

function rating_list() {
    users_ratings = document.querySelector("#users-ratings-list")

    users_ratings.innerHTML = JSON.parse(this.response).content;
}

// ----- Users Rated -----

users_rated_tab = document.querySelector("#v-pills-users-rated-tab")

users_rated_tab.addEventListener('click', rated)

function rated(e) {
    e.preventDefault()

    sendAjaxRequest('GET', `/api/users/${username.value}/rated`, {}, rated_list, [{ name: 'Accept', value: 'text/html' }])
}

function rated_list() {
    users_rated = document.querySelector("#users-rated-list")

    users_rated.innerHTML = JSON.parse(this.response).content;
}

// ----- Add/Remove Favourite -----

favourite_seller = document.querySelector("#favourite-seller")

if(favourite_seller){
    favourite_seller.addEventListener('click', () => {
        username = favourite_seller.getAttribute('data-seller')
        icon = favourite_seller.querySelector("svg")
        action = icon.getAttribute('data-prefix') == "fas" ? 'remove' : 'add'
    
        sendAjaxRequest('POST',`/api/users/fav_sellers/${action}`, {'seller': username}, fav_seller, [])
    })
}


function fav_seller() {

    response = JSON.parse(this.response)
    result = response.result
    icon = favourite_seller.querySelector("svg")
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

function remove_favourite_seller(){
    seller = this.getAttribute("data-seller")
    sendAjaxRequest('POST',`/api/users/fav_sellers/remove`, {'seller': seller}, () => {
        sendAjaxRequest('GET',`/api/users/${username.value}/fav_sellers`, {}, fav_seller_list, [{name: 'Accept', value: 'text/html'}])
    }, [])
}

function remove_favourite_auction(){
    auction = this.getAttribute("data-auction")
    sendAjaxRequest('POST',`/api/users/fav_auctions/remove`, {'auction': auction}, () => {
        sendAjaxRequest('GET',`/api/users/${username.value}/fav_auctions`, {}, fav_auction_list, [{name: 'Accept', value: 'text/html'}])
    }, [])
}
