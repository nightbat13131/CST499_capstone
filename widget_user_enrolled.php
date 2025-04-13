<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once "config.php";

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

   <p>Enrolled and Waitlisted Courses</p>
<?php
    if (!$user->has_role(USERENTITY_STUDENT) ) {
        echo "<p>Hi Students, sign in to see your enrolled classes.</p>";
    } else {
    $results = $user->get_enroll_wait_course();
    if ($results[0]) {
        $data = $results[2];
        $headers = DatabaseUtility::get_headers($data[0]);
        generate_table($headers, $data);
    }
    }
    ?>
</div>
</body>
