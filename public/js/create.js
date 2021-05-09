window.onload = function () {

    if (window.File && window.FileList && window.FileReader) {

        let filesInput = document.querySelector("#auction-images");

        filesInput.addEventListener("change", function (event) {

            let files = event.target.files;

            let carousel = document.querySelector("#carousel-inner");
            carousel.innerHTML = ""

            let carousel_buttons = document.querySelector("#carousel-indicators");
            carousel_buttons.innerHTML = ""

            for (let i = 0; i < files.length; i++) {

                let file = files[i];

                if (!file.type.match('image'))
                    continue;

                let picReader = new FileReader();

                picReader.addEventListener("load", function (event) {

                    let picFile = event.target;

                    let div = document.createElement("div");

                    div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                        "title='" + picFile.name + "'/>";

                    carousel.innerHTML += `<div class="carousel-item ${i == 0 ? "active" : ""}"><img src="${picFile.result}" class="d-block w-100"></div>`

                    carousel_buttons.innerHTML += `<button type="button" data-bs-target="#carouselIndicators" data-bs-slide-to="${i}" ${i == 0 ? "class=\"active\" aria-current=\"true\"" : ""} aria-label="Slide ${i+1}"></button>`
                });

                //Read the image
                picReader.readAsDataURL(file);
            }
        });
    } else {
        console.log("Your browser does not support File API");
    }
}

function setSelect(response, attribute = "name") {
    let objects = JSON.parse(response).content

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
        select.insertAdjacentHTML('beforeend', `<option>${colour.name}</option>`)
    }
}

function setBrands() {
    let brands = setSelect(this.responseText)
    
    let select = document.querySelector("#select-brand")

    for (const brand of brands) {
        select.insertAdjacentHTML('beforeend', `<option>${brand.name}</option>`)
    }
}

function setScales() {
    let scales = setSelect(this.responseText)
    
    let select = document.querySelector("#select-scale")

    for (const scale of scales) {
        select.insertAdjacentHTML('beforeend', `<option>${scale.name}</option>`)
    }
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
    sendAjaxRequest('GET','/api/sellers', {}, setSellers)
}

function getAllSelectData() {
    getColours()
    getBrands()
    getScales()
}

getAllSelectData()
