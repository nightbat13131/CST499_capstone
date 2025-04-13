<?php
error_reporting(E_ALL ^ E_NOTICE);

    require_once 'config.php';
    require_once 'utilities.php';
    //require_once 'DatabaseUtility.php';
    require_once 'OfferedCourses.php';

#$input = [OFFERED_COURSE_SEMESTER => 2, OFFERED_COURSE_YEAR => 2025, OFFERED_COURSE_ID => 'GEN101'];
if (IS_DEBUG) { nl_dump($_GET);}

$request = OfferedCourses::add_offered_course($_GET);
if (IS_DEBUG) nl_dump($request);
$message = 'Unable to schedule course, unknown error.';
$level = 'warning';
if ($request[0]) {
    $message = "Class added successfully.";
    $level ="success";
} else {
    if ( str_contains( $request[2], 'Duplicate')) {
    $message = "Unable to schedule course, duplicate entry";
    $level = 'danger';
    } else {
        func_redirect(ADMIN_ADD_COURSE);
        $message = "Unable to schedule course, unknown error.";
    }
}

func_redirect(ADMIN_ADD_COURSE, $message, $level);



