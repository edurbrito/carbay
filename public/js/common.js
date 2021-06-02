function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler, headers = []) {
    let request = new XMLHttpRequest();

    if(method == "GET")
        url = url + `?${encodeForAjax(data)}`

    request.open(method, url, true);
    request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    for (const header of headers) {
        request.setRequestHeader(header.name, header.value);
    }
    request.addEventListener('load', handler);
    if(method == "GET")
        request.send()
    else
        request.send(encodeForAjax(data));
}

function timeSince(date) {

    var seconds = Math.floor((new Date() - date) / 1000);
  
    var interval = seconds / 31536000;
  
    if (interval > 1) {
      return Math.floor(interval) + " years";
    }
    interval = seconds / 2592000;
    if (interval > 1) {
      return Math.floor(interval) + " months";
    }
    interval = seconds / 86400;
    if (interval > 1) {
      return Math.floor(interval) + " days";
    }
    interval = seconds / 3600;
    if (interval > 1) {
      return Math.floor(interval) + " hours";
    }
    interval = seconds / 60;
    if (interval > 1) {
      return Math.floor(interval) + " minutes";
    }
    return Math.floor(seconds) + " seconds";
}

notification_list = document.querySelectorAll(".notifications-list");
notify_badge = document.querySelectorAll(".notify-badge");
clear_all = document.querySelectorAll(".clear-all")

function parse_notification(response){

    if(response.result == "success"){
        let content = response.content
        let result = ""
        let not_viewed = false
        
        for (let notification of content) {
            
                let bold = notification.viewed ? "text-muted" : "font-weight-bold"

                if(!notification.viewed)
                    not_viewed = true

                result += `<li style="cursor: pointer;">
                                <button class="dropdown-item btn-secondary d-flex flex-column px-2 py-2 ${bold}" type="button" onclick="view_notification(${notification.id}, '${notification.content.url}')">
                                ${notification.content.text}
                                <span class="w-100 grey" style="text-align: end; font-weight: normal;">${timeSince(new Date(notification.datehour)) + " ago"}</span>
                                </button>
                            </li>`
                result += `<li><hr class="dropdown-divider my-0"></li>`
            }
        
        return {"result": result, "not_viewed": not_viewed}
    }
}

function add_notifications(){
    let response = JSON.parse(this.response)

    if(response.result == "success" && response.content.length > 0) {
        let result = ""

        notifications = parse_notification(response)
        result += notifications.result

        for (let list of notification_list) {
            list.innerHTML = result
        }

        if(notifications.not_viewed){
            for (let badges of notify_badge) {
                badges.removeAttribute('hidden')
                badges.innerHTML = "•"
            }
        }

        for (let clear of clear_all) {
            clear.hidden = false
            clear.addEventListener("click", () => {
                sendAjaxRequest('GET', '/api/users/notifications/clear', {}, add_notifications, [{ name: 'Accept', value: 'application/json' }]);
            })            
        }
    }
    else{
        for (let list of notification_list) {
            list.innerHTML = `<li><button class="dropdown-item px-6" type="button">Nothing here for you...</button></li>`
        } 

        for (let badges of notify_badge) {
            badges.setAttribute('hidden', '')
        }

        for (let clear of clear_all) {
            clear.hidden = true
            clear.addEventListener("click", () => {
                sendAjaxRequest('GET', '/api/users/notifications/clear', {}, add_notifications, [{ name: 'Accept', value: 'application/json' }]);
            })            
        }
    }
}

function get_notifications(){
    sendAjaxRequest('GET', '/api/users/notifications', {}, add_notifications, [{ name: 'Accept', value: 'application/json' }]);    
}

function view_notification(id, href){
    if(href){
        sendAjaxRequest('GET', '/api/users/notifications/view', {'id': id}, add_notifications, [{ name: 'Accept', value: 'application/json' }]);
        location.href = href;
    }
}

if(notification_list.length > 0){
    get_notifications()
    setInterval(get_notifications, 5000)
}
    