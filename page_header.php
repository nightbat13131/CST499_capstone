<?php
error_reporting(E_ALL ^ E_NOTICE);

if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.use_only_cookies','1');
    session_start(); }

require_once "config.php";
require_once "utilities.php";
require_once "UserEntity.php";


if (isset($_COOKIE[COOKIE_USERIDETITY]) ) {
    $user = unserialize($_COOKIE[COOKIE_USERIDETITY]);
} else {
    $user = UserEntity::get_default_user();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <!--<script scr="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</head>
<body>
<!-- https://getbootstrap.com/docs/5.2/components/navbar/ -->

<div class='container'>
    <div class="container text-center">
        <h1>Branding</h1>
        <p>Hi <?php echo $user->get_attribute(USER_GOESBY)  ?></p>
    </div>

    <div class='navbar navbar-expand-xl'>
        <div class="container-fluid">
            <?php
             nav_element(PAGE_LANDING, 'Home', true);
             nav_element(PAGE_CLASS_ENROLLMENT, 'Enrollment');
            if (!$user->has_role(USERENTITY_STUDENT)) {
                nav_element(PAGE_ACCOUNT_REGISTRATION, 'Register');
                nav_element(PAGE_LOGIN, 'Login');
            }
            if ($user->has_role(USERENTITY_STUDENT)) {
                nav_element(PAGE_USER_ACCOUNT, 'Account');
                nav_element(PROCESS_LOGOUT, 'Logout');
                nav_element(ADMIN_ADD_COURSE, 'Admin');
            }
            ?>

        </div>
    </div>

</div>

<?php func_displayQueryMessage() ?>
</body>