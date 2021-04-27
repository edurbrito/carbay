let carousel_indicators = document.getElementById("carousel-indicators");
let carousel_inner = document.getElementById("carousel-inner");


function createImageIndicator(num) {
    if(num == 0) {
        carousel_indicators.insertAdjacentHTML('beforeend', "<button type=\"button\" data-bs-target=\"#carouselIndicators\" data-bs-slide-to=\"" + num + "\" class=\"active\" aria-current=\"true\" aria-label=\"Slide " + num + "></button>");
    }
    else {
        carousel_indicators.insertAdjacentHTML('beforeend', "<button type=\"button\" data-bs-target=\"#carouselIndicators\" data-bs-slide-to=\"" + num + "\" aria-current=\"true\" aria-label=\"Slide " + num + "></button>");
    }
}

function createImageInner(src, num) {
    if(num == 0) {
        carousel_inner.insertAdjacentHTML('beforeend', "<div class=\"carousel-item active\"> <img src=" + src + "class=\"d-block w-100\" alt=\"...\"></div>");
    }
    else {
        carousel_inner.insertAdjacentHTML('beforeend', "<div class=\"carousel-item\"> <img src=" + src + "class=\"d-block w-100\" alt=\"...\"></div>");
    }
}

function preview_images(input) {
    carousel_indicators.innerHTML = "";
    carousel_inner.innerHTML = "";
    if(input.files && input.files[0]) {
        for(let i = 0; i < input.files.length; i++) {
            var reader = new FileReader();
            reader.onload = function (e) {
                if(i == 0) {
                    createImageIndicator(i);
                    createImageInner(e.target.result, i);
                }
                else {
                    createImageIndicator(i);
                    createImageInner(e.target.result, i);
                }
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}