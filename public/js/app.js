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

function update_content() {
  let times = document.querySelectorAll("#time-remaining")

  for (const time of times) {
      let final_date = time.getAttribute("data-time");
      let date2 = new Date(final_date);
      let date1 = new Date();
      let diff = new Date(date2.getTime() - date1.getTime());
      let new_time = `${Math.floor(diff.getTime() / (1000 * 3600 * 24))}d ${diff.getHours()}h ${diff.getMinutes()}m ${diff.getSeconds()}s`;

      new_time = diff.getTime() < 0 ? "Ended" : new_time;
      
      time.querySelector("#time-remaining-value").innerHTML = new_time;
  }
}

setInterval(update_content, 1000)

function update_featured(){
    featured = document.querySelector("#featured-auctions")
    featured.innerHTML = this.response
}

setInterval(() => {
    sendAjaxRequest('GET', `/api/auctions/featured`, {}, update_featured, [{name: 'Accept', value: 'text/html'}])
}, 26000)
