function update_time_remaining() {
    let auctions = document.querySelectorAll("#time-remaining")

    for (const auction of auctions) {
        let final_date = auction.getAttribute("data-time");
        let date2 = new Date(final_date);
        let date1 = new Date();
        let diff = new Date(date2.getTime() - date1.getTime() - 1000*60*60);
        let new_time = `${Math.floor(diff.getTime() / (1000 * 3600 * 24))}d ${diff.getUTCHours()}h ${diff.getMinutes()}m ${diff.getSeconds()}s`;

        new_time = diff.getTime() < 0 ? "Ended" : new_time;
        
        auction.querySelector("#time-remaining-value").innerHTML = new_time;
    }
}

setInterval(update_time_remaining, 1000)

function setSelect(response, attribute = "name") {
    let objects = JSON.parse(response)

    let new_objects = []

    for (const object of objects) {
        let new_object = {'id': object.id, [attribute]: object[attribute]}
        new_objects.push(new_object);
    }

    return new_objects
}

function setColours() {
    let colours = setSelect(this.responseText)
    
    let select = document.querySelector("#select-colour")

    for (const colour of colours) {
        select.insertAdjacentHTML('beforeend', `<option value="${colour.id}">${colour.name}</option>`)
    }
}

function setBrands() {
    let brands = setSelect(this.responseText)
    
    let select = document.querySelector("#select-brand")

    for (const brand of brands) {
        select.insertAdjacentHTML('beforeend', `<option value="${brand.id}">${brand.name}</option>`)
    }
}

function setScales() {
    let scales = setSelect(this.responseText)
    
    let select = document.querySelector("#select-scale")

    for (const scale of scales) {
        select.insertAdjacentHTML('beforeend', `<option value="${scale.id}">${scale.name}</option>`)
    }
}

function setSellers() {
    let sellers = JSON.parse(this.responseText)
    
    let select = document.querySelector("#select-seller")

    select.insertAdjacentHTML('beforeend', '<optgroup label="Favourites">')

    for (const seller of sellers.favourites) {
        select.insertAdjacentHTML('beforeend', `<option value="${seller.id}">${seller.username}</option>`)
    }

    select.insertAdjacentHTML('beforeend', '</optgroup><optgroup label="All">')

    for (const seller of sellers.all) {
        select.insertAdjacentHTML('beforeend', `<option value="${seller.id}">${seller.username}</option>`)
    }
    select.insertAdjacentHTML('beforeend', '</optgroup>')
}

function getColours() {
    sendAjaxRequest('GET','/api/colours', {}, setColours)
}

function getBrands() {
    sendAjaxRequest('GET','/api/brands', {}, setBrands)
}

function getScales() {
    sendAjaxRequest('GET','/api/scales', {}, setScales)
}

function getSellers() {
    sendAjaxRequest('GET','/api/sellers', {}, setSellers, [{name: 'Accept', value: 'application/json'}])
}

function getAllSelectData() {
    getColours()
    getBrands()
    getScales()
    getSellers()
}

getAllSelectData()

full_text_form = document.querySelector("#full-text-form")

full_text_form.addEventListener('submit', search)

advanced_form = document.querySelector("#advanced-form")

advanced_form.addEventListener('submit', search)

full_text = full_text_form.querySelector("#full-text")
sort_by = advanced_form.querySelector("#sort-by")
order_by = advanced_form.querySelector('input[name="order-by"]:checked')
buy_now = advanced_form.querySelector("#buy-now")
ended_auctions = advanced_form.querySelector("#ended-auctions")

colour = advanced_form.querySelector("#select-colour")
brand = advanced_form.querySelector("#select-brand")
scale = advanced_form.querySelector("#select-scale")
seller = advanced_form.querySelector("#select-seller")

min_bid = advanced_form.querySelector("#min-bid")
max_bid = advanced_form.querySelector("#max-bid")
min_buy_now = advanced_form.querySelector("#min-buy-now")
max_buy_now = advanced_form.querySelector("#max-buy-now")

function search(e) {
    e.preventDefault()

    data = {
        'full-text' : full_text.value,
        'sort-by' : sort_by.value,
        'order-by' : order_by.checked ? 0 : 1,
        'buy-now' : buy_now.checked,
        'ended-auctions' : ended_auctions.checked,
        'colour' : colour.value,
        'brand' : brand.value,
        'scale' : scale.value,
        'seller' : seller.value,
        'min-bid' : min_bid.value,
        'max-bid' : max_bid.value,
        'min-buy-now' : min_buy_now.value,
        'max-buy-now' : max_buy_now.value,
    }

    sendAjaxRequest('GET','/api/auctions/search', data, refresh_search, [{name: 'Accept', value: 'text/html'}])
}

function refresh_search() {

    div_auctions = document.querySelector("#auctions")

    div_auctions.innerHTML = this.response;

    count = (this.response.match(/id="auction-\d/g) || []).length

    total_search = document.querySelector("#total-search")

    total_search.innerHTML = count + " Auctions found"
}

reset_button = document.querySelector("#reset-button")

reset_button.addEventListener('click', reset_search)

function reset_search() {
    div_auctions = document.querySelector("#advanced-form")

    full_text.value = ""
    sort_by.value = "0"
    order_by.value = "0"
    buy_now.checked = true
    ended_auctions.checked = false
    colour.value = -1
    brand.value = -1
    scale.value = -1
    seller.value = -1
    min_bid.value = ""
    max_bid.value = ""
    min_buy_now.value = ""
    max_buy_now.value = ""

    data = {
        'full-text' : full_text.value,
        'sort-by' : sort_by.value,
        'order-by' : order_by.value,
        'buy-now' : buy_now.checked,
        'ended-auctions' : ended_auctions.checked,
        'colour' : colour.value,
        'brand' : brand.value,
        'scale' : scale.value,
        'seller' : seller.value,
        'min-bid' : min_bid.value,
        'max-bid' : max_bid.value,
        'min-buy-now' : min_buy_now.value,
        'max-buy-now' : max_buy_now.value,
    }

    sendAjaxRequest('GET','/api/auctions/search', data, refresh_search, [{name: 'Accept', value: 'text/html'}])
}