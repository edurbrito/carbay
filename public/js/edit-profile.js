function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        document.getElementById('profile-photo').src=e.target.result
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }

let filesInput = document.querySelector("#photo-input");

filesInput.addEventListener("change", function (event) {
    readURL(this);
})