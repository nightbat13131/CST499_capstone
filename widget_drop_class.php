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

$course_options = '';

$results = $user->get_enroll_wait_course();

if ($results[0]) {
    foreach ($results[2] as $class_row) {
        #nl_dump($class_row);
        if (isset($class_row[OBSCURE.COURSE_OFFERED_ID] )) {
            $course_options .= "<option>" . $class_row[OBSCURE . COURSE_OFFERED_ID] . "</option>";
        } else {echo "why".OBSCURE.COURSE_OFFERED_ID;}
    }

            echo "
            <form method='get' action=".PROCESS_DROP_CLASS.">
                <fieldset>
                    <LEGEND>Drop Course</LEGEND>
                    <div class='form row'>
                            <div class='col'>
                            </div>
                            <div class='col'>
                                <label for=".COURSE_OFFERED_ID.">Select Course</label>
                            </div>
                            <div class='col'>
                                <select id=".COURSE_OFFERED_ID." name=".COURSE_OFFERED_ID.">$course_options</select>
                            </div>
                            <div class='col'>
                                <input type='hidden' id=".USER_USERID." name=".USER_USERID." value=".$user->get_attribute(USER_USERID).">
                                <input class='form-control' type='submit'/>
                            </div>
                            <div class='col'>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
       ";

        } else {echo "<p>Unable to load available courses for DROP WIDGET. Please try again later.</p>";}
 #   } else {
 #       echo "<p>Students, sign in to your account to enroll in classes.</p>";
 #   }
    ?>


