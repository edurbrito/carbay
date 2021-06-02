@if(Auth::check())
<nav class="navbar navbar-primary bg-primary border-top border-danger fixed-bottom">
    <div class="container-fluid d-flex justify-content-center">
        <a class="navbar-brand text-light mr-2 ml-0" href="/about">About Us</a>
        <a class="navbar-brand text-light mr-2 ml-2" href="/faqs">FAQs</a>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script defer>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
    return new bootstrap.Popover(popoverTriggerEl)
    })
</script>
@else
<nav class="navbar navbar-primary bg-primary border-top border-dark fixed-bottom">
    <div class="container-fluid d-flex justify-content-center">
        <a class="navbar-brand text-light mr-4 ml-0" href="/about">About Us</a>
        <a class="navbar-brand text-light mr-0 ml-4" href="/faqs">FAQs</a>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
@endif