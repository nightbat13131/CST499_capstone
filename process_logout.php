<?php
require_once "config.php";
require_once 'utilities.php';

unset($_SESSION[USER_USERNAME]);

if (isset($_COOKIE[COOKIE_USERIDETITY])) {
    setcookie(COOKIE_USERIDETITY, '', time() - 3600, "/", null, false, true);
}
func_redirect( 'index.php', 'Logout Successful'  );


