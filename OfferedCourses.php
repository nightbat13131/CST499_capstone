<?php
require_once 'config.php';
require_once 'DatabaseUtility.php';

class OfferedCourses
{
    public static function add_offered_course(array $input) : array {
        if (IS_DEBUG) {echo "OfferedCourses::add_offered_course inputs:"; var_dump($input); echo "<br>";}


// // Validate inputs
        $params = [];
        if (isset($input[OFFERED_COURSE_ID])) {
            $params[OFFERED_COURSE_ID] = $input[OFFERED_COURSE_ID];
        } else {
            return [0, "missing parameter course id"];
        }
        if (isset($input[OFFERED_COURSE_YEAR])) {
            $params[OFFERED_COURSE_YEAR] = $input[OFFERED_COURSE_YEAR];
        } else {
            return [0, "missing parameter course year"];
        }
        if (isset($input[OFFERED_COURSE_SEMESTER])) {
            $params[OFFERED_COURSE_SEMESTER] = $input[OFFERED_COURSE_SEMESTER];
        } else {
            return [0, "missing parameter course semester"];
        }
        if (IS_DEBUG) {echo "params:"; var_dump($params); echo "<br>";}
// // Establish connection

        global $database_source;
// todo: needs a try catch
        $sql = new DatabaseUtility($database_source, DATABASE_USER, DATABASE_KEY);
        $results = $sql->add_entry(TABLE_OFFERED_COURSE, $params);

// // prepare statement

/*
        $statement = "INSERT INTO ".TABLE_OFFERED_COURSE." ( ".join(', ', array_keys($params))." ) VALUES ( :".join(', :', array_keys($params))." )";
        var_dump($statement);
        echo "<br>";
*/
/*
        $sql->prepare($statement);
        $sql->execute($params);

*/
        return $results;
}
}