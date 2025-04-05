<?php
error_reporting(E_ALL ^ E_NOTICE);

    require_once 'config.php';
    require_once 'DatabaseUtility.php';
    require_once 'OfferedCourses.php';


$input = [OFFERED_COURSE_SEMESTER => 2, OFFERED_COURSE_YEAR => 2025, OFFERED_COURSE_ID => 'GEN101'];
if (IS_DEBUG) {echo "<br>"; var_dump($input);}

$added_class = OfferedCourses::add_offered_course($input);
 var_dump($added_class); echo "<br>" ;

/*
$results = [0,"unknown failure"];
$add_offered_course_req_headers = [OFFERED_COURSE_ID, OFFERED_COURSE_YEAR, OFFERED_COURSE_SEMESTER];

// // Validate inputs
$params = [];
if (isset($input[OFFERED_COURSE_ID])) {
    $params[OFFERED_COURSE_ID] = $input[OFFERED_COURSE_ID];
} else {
    $results = [0, "missing parameter course id"];
    // return $results
}
if (isset($input[OFFERED_COURSE_YEAR])) {
    $params[OFFERED_COURSE_YEAR] = $input[OFFERED_COURSE_YEAR];
} else {
    $results = [0, "missing parameter course year"];
    // return $results
}
if (isset($input[OFFERED_COURSE_SEMESTER])) {
    $params[OFFERED_COURSE_SEMESTER] = $input[OFFERED_COURSE_SEMESTER];
} else {
    $results = [0, "missing parameter course semester"];
    // return $results
}



// // Establish connection

global $database_source;
// todo: needs a try catch
$sql = new DatabaseUtility($database_source, DATABASE_USER, DATABASE_KEY);


// // prepare statement


$statement = "INSERT INTO ".TABLE_OFFERED_COURSE." ( ".join(', ', array_keys($params))." ) VALUES ( :".join(', :', array_keys($params))." )";
var_dump($statement);
echo "<br>";

$sql->prepare($statement);
$sql->execute($params);

// //$add_request = $sql->pdo->exec($statement);

*/



