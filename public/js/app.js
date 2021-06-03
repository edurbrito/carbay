function update_content() {
  let times = document.querySelectorAll("#time-remaining")

  for (const time of times) {
      let final_date = time.getAttribute("data-time");
      let date2 = new Date(final_date);
      let date1 = new Date();
      let diff = new Date(date2.getTime() - date1.getTime());
      let new_time = `${Math.floor(diff.getTime() / (1000 * 3600 * 24))}d ${diff.getUTCHours()}h ${diff.getMinutes()}m ${diff.getSeconds()}s`;

      new_time = diff.getTime() < 0 ? "Ended" : new_time;
      
      time.querySelector("#time-remaining-value").innerHTML = new_time;
  }
}

setInterval(update_content, 1000)

function update_featured(){
    featured = document.querySelector("#featured-auctions")
    featured.innerHTML = JSON.parse(this.response).content
}

function getFeatured(){
    sendAjaxRequest('GET', `/api/auctions/featured`, {}, update_featured, [{name: 'Accept', value: 'text/html'}])
}

setInterval(() => {
   getFeatured()
}, 26000)

getFeatured()
