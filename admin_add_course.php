<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once "config.php";
require_once "utilities.php";
require_once "page_header.php";
require_once "OfferedCourses.php";
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
    <title>Landing Page</title>
    <!--<script scr="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</head>
<body>

<div class='container-lg text-center'>

    <h1>Admin Page</h1>

    <?php
    $request = OfferedCourses::get_courses();
    if (!$request[0]) {
        echo "<p>Unalbe to load Course tool. Error: $request[1]. Try again later.</p>";
    } else {
        $data = $request[2];
        $class_options = '';
        foreach ($data as $row) {
            $class_options .= "<option>".$row[COURSE_ID]."</option>";
        }

        echo "
    <form method='GET' action=".PROCESS_ADD_OFFERED_COURSE.">
        <fieldset>
            <legend>Add An Offered Course</legend>
        <div class='form row'>
            <div class='col'>
                <label for=".COURSE_ID.">Class</label>
                <select id=".COURSE_ID." name=".COURSE_ID." class='form-control'>
                    $class_options
                </select>
            </div>
            <div class='col'>
                <label for=".COURSE_YEAR.">Select Year</label>
                <select id=".COURSE_YEAR." name=".COURSE_YEAR." class='form-control'>
                    <option>".(date('Y'))."</option>
                    <option>".(date('Y') + 1)."</option>
                    <option>".(date('Y') + 2)."</option>
                    <option>".(date('Y') + 3)."</option>
                    <option>".(date('Y') + 4)."</option>
                </select>
            </div>
            <div class='col'>
                <label for=".COURSE_SEMESTER_ID.">Semester</label>
                <select id=".COURSE_SEMESTER_ID." name=".COURSE_SEMESTER_ID." class='form-control'>
                    <option value='1'>Spring</option>
                    <option value='2'>Summer</option>
                    <option value='3'>Fall</option>
                </select>
            </div>
            <div class='col'>
                <label>Duplicates will be rejected.</label>
                <input class='form-control' type='submit'/>
            </div>
        </div>
        </fieldset>
    </form>";
}
    ?>

    <?php
    require_once WIDGET_OFFERED_CLASSES
    ?>

    <p>Add courses to be implemented in a later release </p>
</div>

<?php include_once "page_footer.php";?>

</body>