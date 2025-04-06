<?php
    error_reporting(E_ALL ^ E_NOTICE);

    require_once 'config.php';
    require_once 'utilities.php';
    require_once 'DatabaseUtility.php';
    require_once 'UserEntity.php';

$add_user_result = UserEntity::process_new_registration($_POST);
if ($add_user_result[0] == 1) { func_redirect(LOGIN_PAGE);}
else {func_redirect(ACCOUNT_REGISTRATION_PAGE);}