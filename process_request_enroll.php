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

if (!$user->has_role(USERENTITY_STUDENT)) {func_redirect( PAGE_CLASS_ENROLLMENT,
    "Invalid User. Try signing out and back in.");}

$request = $user->request_enrollment($_POST);
if (IS_DEBUG) {echo "user->request_enrollment attempt :", nl_dump($request);}
$level = 'warning';
if ($request[0]) {$level= 'success';}
func_redirect(PAGE_CLASS_ENROLLMENT, $request[1], $level);

