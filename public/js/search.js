
full_text_form = document.querySelector("#full-text-form")

full_text_form.addEventListener('submit', search)

advanced_form = document.querySelector("#advanced-form")

advanced_form.addEventListener('submit', search)

reset_button = document.querySelector("#reset-button")

reset_button.addEventListener('click', reset_search)

full_text = full_text_form.querySelector("#full-text")
sort_by = advanced_form.querySelector("#sort-by")
order_by = advanced_form.querySelector('input[name="order-by"]:checked')
buy_now = advanced_form.querySelector("#buy-now")
ended_auctions = advanced_form.querySelector("#ended-auctions")

scale = advanced_form.querySelector("#select-scale")
colour_input = advanced_form.querySelector("#select-colour-input")
brand_input = advanced_form.querySelector("#select-brand-input")
seller_input = advanced_form.querySelector("#select-seller-input")

min_bid = advanced_form.querySelector("#min-bid")
max_bid = advanced_form.querySelector("#max-bid")
min_buy_now = advanced_form.querySelector("#min-buy-now")
max_buy_now = advanced_form.querySelector("#max-buy-now")

page = document.querySelector("#pagination")
div_auctions = document.querySelector("#auctions")
total_search = document.querySelector("#total-search")
pagination = document.querySelector("#pagination")
spinner = '<div class="spinner-border align-self-center m-auto" role="status"><span class="sr-only">Loading...</span></div>'

g_colours = {}
g_brands = {}
g_sellers = {}

let timeout

function query_on_url(){
    query = ""
    try{
        query = window.location.href.match(/\?.+/)[0]
    }
    catch(e){
        query = ""
    }
    
    if(query.length > 1){
        let request = new XMLHttpRequest();

        url = '/api/auctions/search' + query    
        request.open("GET", url, true);
        request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        headers = [{name: 'Accept', value: 'text/html'}]
        for (const header of headers) {
            request.setRequestHeader(header.name, header.value);
        }
        request.addEventListener('load', refresh_search);
        request.send()
    }
    else{
        reset_search()
    }
}

function replace_child(original, replacement_tag){
    var replacement = document.createElement(replacement_tag);

    for(var i = 0, l = original.attributes.length; i < l; ++i){
        var nodeName  = original.attributes.item(i).nodeName;
        var nodeValue = original.attributes.item(i).nodeValue;

        replacement.setAttribute(nodeName, nodeValue);
    }
    replacement.innerHTML = original.innerHTML;

    original.parentNode.replaceChild(replacement, original);

    return replacement
}

function enable_pagination() {
    plinks = document.querySelectorAll(".pagination > .page-item > a.page-link")

    for (let plink of plinks) {
        plink.removeAttribute("href")
        new_child = replace_child(plink, "span")
        new_child.style.cursor = "pointer"

        new_child.addEventListener("click", function(){
            
            page_number = this.innerHTML
            current_page = page.getAttribute("data-page")

            if(this.getAttribute("rel") == "next")
                page_number = parseInt(current_page) + 1
            else if(this.getAttribute("rel") == "prev")
                page_number = parseInt(current_page) - 1

            page.setAttribute("data-page", page_number)
            search(null, page_number)
        })
    }
}

function update_time_remaining() {
    let auctions = document.querySelectorAll(".time-remaining")

    for (const auction of auctions) {
        let final_date = auction.getAttribute("data-time");
        let date2 = new Date(final_date);
        let date1 = new Date();
        let diff = new Date(date2.getTime() - date1.getTime());
        let new_time = `${Math.floor(diff.getTime() / (1000 * 3600 * 24))}d ${diff.getUTCHours()}h ${diff.getMinutes()}m ${diff.getSeconds()}s`;

        new_time = diff.getTime() < 0 ? "Ended" : new_time;
        
        auction.querySelector(".time-remaining-value").innerHTML = new_time;
    }
}

function setScales() {    
    let response = JSON.parse(this.responseText)
    
    if(response.result == "success"){

        let scales = response.content

        let select = document.querySelector("#select-scale")

        for (const scale of scales) {
            select.insertAdjacentHTML('beforeend', `<option value="${scale.id}">${scale.name}</option>`)
        }
    }

}

function setColours() {
    let response = JSON.parse(this.responseText)
    
    if(response.result == "success"){
        let select = document.querySelector("#select-colour")
        let colours = response.content
        let result = ""

        for(let colour of colours){
            g_colours[colour.name] = colour.id
            result += `<option>${colour.name}</option>`
        }

        select.innerHTML = result
    }
}

function setBrands() {
    let response = JSON.parse(this.responseText)
    
    if(response.result == "success"){
        let select = document.querySelector("#select-brand")
        let brands = response.content
        let result = ""

        for(let brand of brands){
            g_brands[brand.name] = brand.id
            result += `<option>${brand.name}</option>`
        }
        
        select.innerHTML = result
    }
}

function setSellers() {
    let response = JSON.parse(this.responseText)
    
    if(response.result == "success"){
        let select = document.querySelector("#select-seller")
        let sellers = response.content
        let favourites = sellers.favourites
        let all = sellers.all

        let result = ""

        for(let seller of favourites){
            g_sellers[seller.username] = seller.id
            result += `<option>${seller.username}</option>`
        }

        for(let seller of all){
            g_sellers[seller.username] = seller.id
            result += `<option>${seller.username}</option>`
        }

        select.innerHTML = result
    }


}

function getScales() {
    sendAjaxRequest('GET','/api/scales', {}, setScales)
}

colour_input.addEventListener('input', () => {

    if (timeout)
        clearTimeout(timeout)
    timeout = setTimeout(() => {
        value = colour_input.value

        if (value.length > 1) {
            sendAjaxRequest('GET', '/api/colours', { 'search': value }, setColours, [{ name: 'Accept', value: 'application/json' }])
        }
    }, 1000)
})

brand_input.addEventListener('input', () => {
    if (timeout)
        clearTimeout(timeout)
    timeout = setTimeout(() => {
        value = brand_input.value

        if (value.length > 1) {
            sendAjaxRequest('GET', '/api/brands', { 'search': value }, setBrands, [{ name: 'Accept', value: 'application/json' }])
        }
    }, 1000)
})

seller_input.addEventListener('input', () => {
    if (timeout)
        clearTimeout(timeout)
    timeout = setTimeout(() => {
        value = seller_input.value

        if (value.length > 1) {
            sendAjaxRequest('GET', '/api/sellers', { 'search': value }, setSellers, [{ name: 'Accept', value: 'application/json' }])
        }
    }, 1000)
})

function search(e, page_number = 1) {
    if(e != null)
        e.preventDefault()

    data = {
        'full-text' : full_text.value,
        'sort-by' : sort_by.value,
        'order-by' : order_by.checked ? 0 : 1,
        'buy-now' : buy_now.checked,
        'ended-auctions' : ended_auctions.checked,
        'scale' : scale.value,
        'colour' : g_colours[colour_input.value] ? g_colours[colour_input.value] : -1,
        'brand' : g_brands[brand_input.value] ? g_brands[brand_input.value] : -1,
        'seller' : g_sellers[seller_input.value] ? g_sellers[seller_input.value] : -1,
        'min-bid' : min_bid.value,
        'max-bid' : max_bid.value,
        'min-buy-now' : min_buy_now.value,
        'max-buy-now' : max_buy_now.value,
        'page' : page_number
    }

    purl = window.location.href.match(/.+?\?/)
    url = purl == null ? window.location.href + "?" : purl[0]
    history.replaceState({}, null, url + encodeForAjax(data));
    
    remove_div_auctions_class()
    div_auctions.innerHTML = spinner
    sendAjaxRequest('GET','/api/auctions/search', data, refresh_search, [{name: 'Accept', value: 'text/html'}])
}

function refresh_search() {

    response = JSON.parse(this.response)

    if(response.result == "success"){
          
        add_div_auctions_class()
        div_auctions.innerHTML = response.content.auctions

        total_search.innerHTML = response.content.total

        pagination.innerHTML = response.content.links

        enable_pagination()
    }
    else{
        div_auctions.innerHTML = ""

        total_search.innerHTML = response.content[Object.keys(response.content)[0]][0]

        pagination.innerHTML = ""
    }

    let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    let tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
}

function reset_search() {

    full_text.value = ""
    sort_by.value = "0"
    order_by.value = "0"
    buy_now.checked = true
    ended_auctions.checked = false
    scale.value = -1
    colour_input.value = ""
    brand_input.value = ""
    seller_input.value = ""
    min_bid.value = ""
    max_bid.value = ""
    min_buy_now.value = ""
    max_buy_now.value = ""
    page.setAttribute("data-page", "1")

    data = {
        'full-text' : full_text.value,
        'sort-by' : sort_by.value,
        'order-by' : order_by.value,
        'buy-now' : buy_now.checked,
        'ended-auctions' : ended_auctions.checked,
        'scale' : -1,
        'colour' : -1,
        'brand' : -1,
        'seller' : -1,
        'min-bid' : min_bid.value,
        'max-bid' : max_bid.value,
        'min-buy-now' : min_buy_now.value,
        'max-buy-now' : max_buy_now.value,
        'page': "1"
    }

    purl = window.location.href.match(/.+?\?/)
    url = purl == null ? window.location.href + "?" : purl[0]
    history.replaceState({}, null, url + encodeForAjax(data));
    
    remove_div_auctions_class()
    div_auctions.innerHTML = spinner
    sendAjaxRequest('GET','/api/auctions/search', data, refresh_search, [{name: 'Accept', value: 'text/html'}])
}

function add_div_auctions_class(){
    div_auctions.classList.add("row-cols-1")
    div_auctions.classList.add("row-cols-md-3")
    div_auctions.classList.add("g-4")
}

function remove_div_auctions_class(){
    div_auctions.classList.remove("row-cols-1")
    div_auctions.classList.remove("row-cols-md-3")
    div_auctions.classList.remove("g-4")
}

query_on_url()
getScales()
setInterval(update_time_remaining, 1000)