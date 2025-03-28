<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once "config.php";
function nav_element(string $url, bool $is_current = false) : string {
    $active = "";
    if ($is_current) {$active= "active";};
    return "<a class='nav-item $active href='".$url."'>Navbar</a>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <title>Landing Page</title>
    <!--<script scr="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</head>
<body>
<!-- https://getbootstrap.com/docs/5.2/components/navbar/ -->

<div class='container'>
    <div class="container">
        <p>Branding</p>
    </div>

    <div class='navbar navbar-expand-xl bg-primary'>
        <div class="container-fluid">
            <?php echo nav_element(LANDING_PAGE, true)?>
            <?php echo nav_element(LANDING_PAGE)?>
            <?php echo nav_element(LANDING_PAGE)?>
            <?php echo nav_element(LANDING_PAGE)?>
            <?php echo nav_element(LANDING_PAGE)?>
            <?php echo nav_element(LANDING_PAGE)?>

        </div>
    </div>

</div>







</body>