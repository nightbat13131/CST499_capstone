<?php
error_reporting(E_ALL ^ E_NOTICE);

    require_once 'config.php';
    require_once 'DatabaseUtility.php';
    require_once 'OfferedCourses.php';


$input = [OFFERED_COURSE_SEMESTER => 2, OFFERED_COURSE_YEAR => 2025, OFFERED_COURSE_ID => 'GEN101'];
if (IS_DEBUG) {echo "<br>"; var_dump($input);}

$added_class = OfferedCourses::add_offered_course($input);
if (IS_DEBUG) var_dump($added_class); echo "<br>" ;


