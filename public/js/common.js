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

notification_list = document.querySelector("#notifications-list");
notify_badge = document.querySelector(".notify-badge");

function set_notifications(){
    response = JSON.parse(this.response)

    if(response.result == "success"){
        content = response.content
        result = ""
        
        if(response.content.length == 0){
            notify_badge.setAttribute('hidden', '')
            result = `<span class="text-center py-2">Nothing here for you...</span>`
        }
        else{
            notify_badge.removeAttribute('hidden')
            notify_badge.innerHTML = response.content.length
        }

        for (let notification of content) {
            result += `\n<li class="list-group-item list-group-item-action w-100 d-flex align-items-center justify-content-start rounded-0 flex-vertical border-0 border-bottom" 
                                style="cursor: pointer;">
                            <span class="text-primary fs-7 mb-0" onclick="view_notification(${notification.id}, '${notification.content.url}')">${notification.content.text}</span>
                            <span class="ml-auto" onclick="view_notification(${notification.id})">
                            <i  class="fas fa-trash"></i>
                            </span>
                        </li>`
        }

        notification_list.innerHTML = result
    }
}

function get_notifications(){
    sendAjaxRequest('GET', '/api/users/notifications', {}, set_notifications, [{ name: 'Accept', value: 'application/json' }]);
}

function view_notification(id, href = null){
    sendAjaxRequest('GET', '/api/users/notifications/viewed', {'id': id}, set_notifications, [{ name: 'Accept', value: 'application/json' }]);
    if(href)
        location.href = href;
}

if(notification_list != null){
    get_notifications()
    setInterval(get_notifications, 5000)
}
    