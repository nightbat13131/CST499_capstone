<?php error_reporting(E_ALL ^ E_NOTICE);
include_once "config.php";
include_once "utilities.php";
include_once "UserEntity.php";

$login_attempt = UserEntity::process_login($_POST);
if (IS_DEBUG) {echo "process_login Login_attempt: "; nl_dump($login_attempt);}
if ($login_attempt[0] == 1) { # successful login
    $user = $login_attempt[2];
    if ( get_class($user) == 'UserEntity') {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION[USER_USERNAME] = $user->get_attribute(USER_USERNAME);
        $serialized_user = serialize($user);

        if (IS_DEBUG) {
            nl_dump($serialized_user);
            file_put_contents('$serialized_user.txt', $serialized_user);
        }
        setcookie(COOKIE_USERIDETITY, $serialized_user, 0, '/', null, false, true);
        func_redirect(PAGE_USER_ACCOUNT, "login successful", 'success');
    }
} else { func_redirect(PAGE_LOGIN, "login unsuccessful, $login_attempt[1]");}

func_redirect(PAGE_LOGIN, "login failed - unknown error", 'error');

