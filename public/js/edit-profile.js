// TODO: Not working yet

window.onload = function () {
    if (window.File && window.FileList && window.FileReader) {
        let filesInput = document.querySelector("#photo-input");

        filesInput.addEventListener("change", function (event) {
            let file = event.target.files[0];

            if (!file.type.match('image'))
                return;

            let picReader = new FileReader();

            let profile_photo = document.querySelector("#profile-photo");
            profile_photo.innerHTML = ""

            picReader.addEventListener("load", function (event) {
                let picFile = event.target;

                let div = document.createElement("div");
                div['id'] = 'profile-photo';
                div['class'] = 'avatar mx-auto col-md-12 position-relative mb-4 p-0';

                div.innerHTML = `<img src="${picFile.result}" class="rounded z-depth-1-half img-fluid" alt="Sample avatar" style="min-height:300px;height:300px;min-width:300px;width:300">`
            });

            //Read the image
            picReader.readAsDataURL(file);
        });
    }
    else {
        console.log("Your browser does not support File API");
    }
}