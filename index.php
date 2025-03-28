<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once "config.php";
header("Location: ".LANDING_PAGE); exit;


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <title>Index</title>
    <!--<script scr="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</head>
<body>

<?php require "page_header.php";?>

<div class='container-lg text-center'>
<h1>Index</h1>
 <p>If redirect fails, visit our landing page here: <?php echo " <a href='".LANDING_PAGE."'>Landing Page</a>" ?>
     .</p>

</div>

<?php require_once "page_footer.php";?>

</body>



