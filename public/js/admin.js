user_list = document.querySelector("#user-management-list")
user_links = document.querySelector("#user-management-pagination")
make_admin_text = document.querySelector("#make-admin-text")
make_admin_form = document.querySelector("#make-admin-form")
ban_text = document.querySelector("#ban-text")
ban_form = document.querySelector("#ban-form")

sendAjaxRequest('GET','/api/users', {}, setUsers, [{name: 'Accept', value: 'text/html'}])

function setUsers(){
    let users = JSON.parse(this.response)
    
    if(users.result == "success"){
        user_list.innerHTML = users.content.users
        user_links.innerHTML = users.content.links
        enable_pagination()

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
            current_page = user_links.getAttribute("data-page")

            if(this.getAttribute("rel") == "next")
                page_number = parseInt(current_page) + 1
            else if(this.getAttribute("rel") == "prev")
                page_number = parseInt(current_page) - 1

            user_links.setAttribute("data-page", page_number)
            sendAjaxRequest('GET','/api/users', {'page': page_number}, setUsers, [{name: 'Accept', value: 'text/html'}])
        })
    }
}

function update_ma_modal(){
    username = this.getAttribute("data-username")
    make_admin_text.innerHTML = `You are going to promote ${username} to admin.`
    make_admin_form.setAttribute('action', `/admin/make/${username}`)
}

function update_ban_modal(){
    username = this.getAttribute("data-username")

    banned = this.innerHTML == "Unban"

    console.log(banned);

    ban_text.innerHTML = `You are going to ban ${username}.`
    ban_form.setAttribute('action', `/admin/ban/${username}`)

    button = ban_form.querySelector("button[type=submit]")
    button.innerHTML = banned ? "Unban" : "Ban"
    
    if(banned){
        button.classList.replace("btn-danger", "btn-success")
    }
    else{
        button.classList.replace("btn-success", "btn-danger")
    }
}