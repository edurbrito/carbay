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