<?php

function breadcrum()
{
    $uri = $_SERVER['REQUEST_URI'];

    if (strcmp($uri, "/") > 0) {

        $uri = preg_replace("/\.php.*/", "", $uri);
        $uri = preg_replace("/-/", " ", $uri);

        $uri = explode("/", $uri);

?>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-uppercase p-0">
                <li class="breadcrumb-item"><a href="/" class="text-primary">Home</a></li>
                <?php
                for ($i = 1; $i < sizeof($uri) - 1; $i++) {
                    $u = $uri[$i];
                    echo "<li class=\"breadcrumb-item\"><a href=\"/" . $u . "\" class=\"text-primary\">" . $u . "</a></li>";
                }
                ?>
                <li class="breadcrumb-item active" aria-current="page"><?= $uri[sizeof($uri) - 1] ?></li>
                <?php ?>
            </ol>
        </nav>
<?php
    }
}

?>