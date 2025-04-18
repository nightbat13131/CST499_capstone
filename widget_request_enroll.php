<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once "config.php";
# require_once "OfferedCourses.php";

require_once "page_header.php";
// $user defined in page_header
if (!isset($user)) {$user = UserEntity::get_default_user();}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <title>Account Registration</title>
    <!--<script scr="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</head>
<body>
<div class='container-lg text-center'>

    <?php
    if ($user->has_role(USERENTITY_STUDENT)) {
        $request = OfferedCourses::get_offered_courses();
        if ( $request[0] ) {
            if (true) {
            $offered_courses = $request[2];
            $used_offered_course = [];
            $used_course =[];
            $course_options = '';

            $request = $user->get_enroll_wait_course();
            if (IS_DEBUG) {echo "results of attempt to user->get_enroll_wait_course(): "; nl_dump($request);}
            if ($request[0]) {
                foreach ($request[2] as $user_row) {
                   # if (isset($user_row[OBSCURE.COURSE_OFFERED_ID])) {
                        #nl_dump($user_row);
                        array_push($used_offered_course, $user_row[OBSCURE.COURSE_OFFERED_ID]);
                        if ($user_row["Status"] == ENROLL) {
                            array_push($used_course, substr($user_row[OBSCURE.COURSE_OFFERED_ID], 5, 6));
                   #     }
                    }
                }
            } else {echo "<p>Get current courses failed. You may see duplicate offerings.</p>";}

            $used_course = join(" ", $used_course);
            foreach ($offered_courses as $offered_row) {
                $offered_code = $offered_row[COURSE_OFFERED_ID];
                $offered_class = substr($offered_code, 5, 6 );
                if (str_contains($used_course, $offered_class) or in_array($offered_code, $used_offered_course)) {
                    continue;
                } else { $course_options .= "<option>$offered_code</option>";
                }
            }

            echo "
                <form method='post' action=".PROCESS_REQUEST_ENROLL.">
                    <fieldset>
                        <LEGEND>Request Course Enrollment</LEGEND>
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
                                <input type='submit'/>
                            </div>
                            <div class='col'>
                            </div>
                        </div>
                    </fieldset>
                </form> "; }
                echo "  
                <form method='post' action=".PROCESS_REQUEST_ENROLL."> 
                    <fieldset>
                        <LEGEND>Request Course Enrollment</LEGEND>
                        <div class='form row'>
                            <div class='col'>
                            </div>
                            <div class='col'>
                                <label for=".COURSE_OFFERED_ID.">Select Course</label>
                            </div>
                            <div class='col'>
                                <input type='text' id=".COURSE_OFFERED_ID." name=".COURSE_OFFERED_ID." placeholder='6 digit course code'>
                            </div>
                            <div class='col'>
                                
                                 <input type='hidden' id=".USER_USERID." name=".USER_USERID." value=".$user->get_attribute(USER_USERID).">
                                <input type='submit'/>
                            </div>
                            <div class='col'>
                            </div>
                        </div>
                    </fieldset>
                </form>
       ";
        } else {echo "<p>Unable to load available courses. Please try again later.</p>";}
    } else {
        echo "<p>Students, sign in to your account to enroll in classes.</p>";
    }
    ?>


</div>
</body>