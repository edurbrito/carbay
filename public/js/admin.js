
separator = ""
try{
    separator = window.location.href.match(/#.+/)[0].replace("#", "")
}
catch(e){
    separator = ""
}
tab_users = document.querySelector("#v-pills-users-tab")
tab_auctions = document.querySelector("#v-pills-auctions-tab")
tab_reports = document.querySelector("#v-pills-reports-tab")
tab_users.addEventListener("click", () => {
    document.location.hash = 'users'
})
tab_auctions.addEventListener("click", () => {
    document.location.hash = 'auctions'
})
tab_reports.addEventListener("click", () => {
    document.location.hash = 'reports'
})

switch (separator) {
    case "users":
        tab_users.click()
        break;
    case "auctions":
        tab_auctions.click()
        break;
    case "reports":
        tab_reports.click()
        break;
    default:
        break;
}

////////////////////////////////////////////////////////////////

user_list = document.querySelector("#user-management-list")
user_links = document.querySelector("#user-management-pagination")
user_search_input = document.querySelector("#user-management-search-input")
user_select = document.querySelector("#select-users")
auction_list = document.querySelector("#auction-management-list")
auction_links = document.querySelector("#auction-management-pagination")
auction_search_input = document.querySelector("#auction-management-search-input")
report_list = document.querySelector("#report-list")
report_links = document.querySelector("#report-pagination")
report_search_input = document.querySelector("#report-search-input")
make_admin_text = document.querySelector("#make-admin-text")
make_admin_form = document.querySelector("#make-admin-form")
discard_text = document.querySelector("#discard-text")
discard_form = document.querySelector("#user-report-discard-form")
ban_text = document.querySelector("#ban-text")
ban_form = document.querySelector("#ban-form")
suspend_text = document.querySelector("#suspend-text")
suspend_form = document.querySelector("#suspend-form")
reschedule_text = document.querySelector("#reschedule-text")
reschedule_form = document.querySelector("#reschedule-form")
reports_ban_form = document.querySelector("#user-report-ban-form")
report_ban_text = document.querySelector("#report-ban-text")

sendAjaxRequest('GET','/api/users', {}, setUsers, [{name: 'Accept', value: 'text/html'}])
sendAjaxRequest('GET','/api/auctions', {}, setAuctions, [{name: 'Accept', value: 'text/html'}])
sendAjaxRequest('GET','/api/reports', {}, setReports, [{name: 'Accept', value: 'text/html'}])

let timeout
let spinner = '<div class="spinner-border align-self-center" role="status"><span class="sr-only">Loading...</span></div>'

user_search_input.addEventListener('input', () => {

    if(timeout)
        clearTimeout(timeout)
    timeout = setTimeout(() => {
        user_list.innerHTML = spinner
        if(user_search_input.value.length > 2)
            sendAjaxRequest('GET','/api/users', {'page' : 1, 'search': user_search_input.value, 'users' : user_select.value}, setUsers, [{name: 'Accept', value: 'text/html'}])
        else if(user_search_input.value.length == 0){
            sendAjaxRequest('GET','/api/users', {}, setUsers, [{name: 'Accept', value: 'text/html'}])
        }
    }, 2000)

})

user_select.addEventListener('change', () => {

    if(timeout)
        clearTimeout(timeout)
    timeout = setTimeout(() => {
        user_list.innerHTML = spinner
        if(user_search_input.value.length > 2)
            sendAjaxRequest('GET','/api/users', {'page' : 1, 'search': user_search_input.value, 'users' : user_select.value}, setUsers, [{name: 'Accept', value: 'text/html'}])
        else if(user_search_input.value.length == 0){
            sendAjaxRequest('GET','/api/users', {'page' : 1, 'users' : user_select.value}, setUsers, [{name: 'Accept', value: 'text/html'}])
        }
    }, 1000)

})

auction_search_input.addEventListener('input', () => {

    if(timeout)
        clearTimeout(timeout)
    timeout = setTimeout(() => {
        auction_list.innerHTML = spinner
        if(auction_search_input.value.length > 2)
            sendAjaxRequest('GET','/api/auctions', {'page' : 1, 'search': auction_search_input.value}, setAuctions, [{name: 'Accept', value: 'text/html'}])
        else if(auction_search_input.value.length == 0){
            sendAjaxRequest('GET','/api/auctions', {}, setAuctions, [{name: 'Accept', value: 'text/html'}])
        }
    }, 2000)
})

report_search_input.addEventListener('input', () => {
        
    if(timeout)
        clearTimeout(timeout)
    timeout = setTimeout(() => {
        report_list.innerHTML = spinner
        if(report_search_input.value.length > 2)
            sendAjaxRequest('GET','/api/reports', {'page' : 1, 'search': report_search_input.value}, setReports, [{name: 'Accept', value: 'text/html'}])
        else if(report_search_input.value.length == 0){
            sendAjaxRequest('GET','/api/reports', {}, setReports, [{name: 'Accept', value: 'text/html'}])
        }
    }, 3000)
})

function setUsers() {
    let users = JSON.parse(this.response)
    
    if(users.result == "success") {
        user_list.innerHTML = users.content.users
        user_links.innerHTML = users.content.links
        enable_pagination(user_links, "/api/users", user_search_input, setUsers)

        make_admin_buttons = document.querySelectorAll(".make-admin-button")
        ban_buttons = document.querySelectorAll(".ban-button")

        for (const button of make_admin_buttons) {
            button.addEventListener('click', update_ma_modal)
        }

        for (const button of ban_buttons) {
            button.addEventListener('click', update_ban_modal)
        }
    }
}

function setAuctions() {
    let auctions = JSON.parse(this.response)
    
    if(auctions.result == "success") {
        auction_list.innerHTML = auctions.content.auctions
        auction_links.innerHTML = auctions.content.links
        enable_pagination(auction_links, "/api/auctions", auction_search_input, setAuctions)

        suspend_buttons = document.querySelectorAll(".suspend-button")
        reschedule_buttons = document.querySelectorAll(".reschedule-button")

        for (const button of suspend_buttons) {
            button.addEventListener('click', update_suspend_modal)
        }

        for (const button of reschedule_buttons) {
            button.addEventListener('click', update_reschedule_modal)
        }
    }
}

function setReports() {
    let reports = JSON.parse(this.response)
    
    if(reports.result == "success") {
        report_list.innerHTML = reports.content.reports
        report_links.innerHTML = reports.content.links
        enable_pagination(report_links, "/api/reports", report_search_input, setReports)

        ban_buttons = document.querySelectorAll(".user-report-ban-button")
        discard_buttons = document.querySelectorAll(".user-report-discard-button")

        for (const button of ban_buttons) {
            button.addEventListener('click', update_report_ban_modal)
        }

        for (const button of discard_buttons) {
            button.addEventListener('click', update_discard_modal)
        }
    }
}

function replace_child(original, replacement_tag) {
    var replacement = document.createElement(replacement_tag);

    for(var i = 0, l = original.attributes.length; i < l; ++i) {
        var nodeName  = original.attributes.item(i).nodeName;
        var nodeValue = original.attributes.item(i).nodeValue;

        replacement.setAttribute(nodeName, nodeValue);
    }
    replacement.innerHTML = original.innerHTML;

    original.parentNode.replaceChild(replacement, original);

    return replacement
}

function enable_pagination(parent, api, search, callback) {
    plinks = parent.querySelectorAll(`.pagination > .page-item > a.page-link`)

    for (let plink of plinks) {
        plink.removeAttribute("href")
        new_child = replace_child(plink, "span")
        new_child.style.cursor = "pointer"

        new_child.addEventListener("click", function() {
            
            page_number = this.innerHTML
            current_page = parent.getAttribute("data-page")

            if(this.getAttribute("rel") == "next")
                page_number = parseInt(current_page) + 1
            else if(this.getAttribute("rel") == "prev")
                page_number = parseInt(current_page) - 1

            parent.setAttribute("data-page", page_number)
            sendAjaxRequest('GET',api, {'page': page_number, 'search' : search.value }, callback, [{name: 'Accept', value: 'text/html'}])
        })
    }
}

function update_ma_modal() {
    username = this.getAttribute("data-username")
    admin = this.innerHTML == "Make Admin"

    action = admin ? `promote ${username} to admin` : `revoke admin role of ${username}`
    make_admin_text.innerHTML = `You are going to ${action}.`
    make_admin_form.setAttribute('action', `/admin/make/${username}`)

    button = make_admin_form.querySelector("button[type=submit]")
    button.innerHTML = admin ? "Make Admin" : "Revoke Admin"
    
    if(admin) {
        button.classList.replace("btn-danger", "btn-secondary")
    }
    else {
        button.classList.replace("btn-secondary", "btn-danger")
    }
}

function update_ban_modal() {
    username = this.getAttribute("data-username")

    banned = this.innerHTML == "Unban"

    action = banned ? "unban" : "ban"
    ban_text.innerHTML = `You are going to ${action} ${username}.`
    ban_form.setAttribute('action', `/admin/ban/${username}`)

    button = ban_form.querySelector("button[type=submit]")
    button.innerHTML = banned ? "Unban" : "Ban"
    
    if(banned) {
        button.classList.replace("btn-danger", "btn-success")
    }
    else {
        button.classList.replace("btn-success", "btn-danger")
    }
}

function update_suspend_modal() {
    id = this.getAttribute("data-id")

    suspended = this.innerHTML == "Unsuspend"

    title = this.getAttribute("data-auction")
    suspend_text.innerHTML = `You are going to suspend auction ${id} (${title}).`
    suspend_form.setAttribute('action', `/admin/suspend/${id}`)

    button = suspend_form.querySelector("button[type=submit]")
    button.innerHTML = suspended ? "Unsuspend" : "Suspend"
    
    if(suspended) {
        button.classList.replace("btn-danger", "btn-success")
    }
    else{
        button.classList.replace("btn-success", "btn-danger")
    }
}

function update_reschedule_modal() {
    id = this.getAttribute("data-id")
    title = this.getAttribute("data-auction")
    final_date = this.getAttribute("data-finaldate").match(/.+(?=:)/)[0]

    reschedule_text.innerHTML = `The auction ${title} is planned to end at:<br><span class="text-center w-100">${final_date}</span>`
    reschedule_form.setAttribute('action', `/admin/reschedule/${id}`)
}

function update_report_ban_modal() {
    username = this.getAttribute("data-username");

    report_ban_text.innerHTML = `You are going to ban ${username}.`
    reports_ban_form.setAttribute('action', `/admin/reports/ban/${username}`)

    report_id = this.getAttribute("data-id");
    
    var input = document.createElement("input");

    input.setAttribute("type", "hidden");

    input.setAttribute("name", "report-id");

    input.setAttribute("value", report_id);

    reports_ban_form.appendChild(input);
}

function update_discard_modal() {
    username = this.getAttribute("data-username");

    report_ban_text.innerHTML = `You are going to ban ${username}.`
    discard_form.setAttribute('action', `/admin/reports/discard/${username}`)

    report_id = this.getAttribute("data-id");
    
    var input = document.createElement("input");

    input.setAttribute("type", "hidden");

    input.setAttribute("name", "report-id");

    input.setAttribute("value", report_id);

    discard_form.appendChild(input);
}