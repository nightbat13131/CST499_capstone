<?php
    error_reporting(E_ALL ^ E_NOTICE);

    require_once 'config.php';
    require_once 'utilities.php';
    require_once 'UserEntity.php';

$add_user_result = UserEntity::process_new_registration($_POST);
if ($add_user_result[0] == 1) { func_redirect(PAGE_LOGIN, 'Registration successful. Login to continue.', 'success');}
else {func_redirect(PAGE_ACCOUNT_REGISTRATION,$add_user_result[1] );}