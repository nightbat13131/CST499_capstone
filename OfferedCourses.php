<?php
require_once 'config.php';
require_once 'DatabaseUtility.php';

class OfferedCourses
{
    private static ?DatabaseUtility $_sql = null;
    public static function add_offered_course(array $input) : array {
        if (IS_DEBUG) {echo "OfferedCourses::add_offered_course inputs:"; nl_dump($input);}

// // Validate inputs
        $params = [];
        foreach ([COURSE_ID, COURSE_YEAR,COURSE_SEMESTER_ID ] as $key) {
            if (isset($input[$key])) {
                $params[$key] = $input[$key];
            } else {
                return [0, "missing parameter:".$key ];
            }
        }
        if (IS_DEBUG) {echo "params:"; nl_dump($params);}
// // Get connection

        $sql = self::get_sql();
        return $sql->add_entry(TABLE_OFFERED_COURSE, $params);

    }
    public static function get_offered_courses() : array {
        if (IS_DEBUG) {echo 'OfferedCoures ->get_offered_courses <br> '; };
        $sql = self::get_sql();
        return $sql->get_full_table('vw_offered_courses');
    }
    public static function get_courses() : array {
        if (IS_DEBUG) {echo 'OfferedCourse->get_corses';}
        $sql = self::get_sql();
        $results = $sql->prepare(
            "SELECT ".COURSE_ID." FROM ".TABLE_COURSES
        );
        if ($results[0]) {
            $results = $sql->execute();
            if ($results[0]) {
                $results = $sql->get_last_results();
            }
        }
        return $results;
    }

    public static function request_enrollment(string $user_id, string $offered_course_id ) : array {
        if (IS_DEBUG) {echo "OfferedCoures::request_enrollment"; nl_dump([$user_id, $offered_course_id]);}
        # database uses foreign key, so at this time, validating $offerd_course is a real value is not needed
        $sql = self::get_sql();
        # get current count and limit
        $request = $sql->prepare(
            "SELECT suggested_enrol_limit FROM ".TABLE_COURSES." WHERE ".COURSE_ID." = :".COURSE_ID
        );
        if (!$request[0]) {return $request;}
        $request = $sql->execute([COURSE_ID =>substr($offered_course_id, 5, 6 )]);
        if (!$request[0]) {return $request;}
        $request = $sql->get_last_results();
        #nl_dump($request);
        if (!$request[0]) {return $request;}
        $limit = $request[2][0][0];
        nl_dump($limit);
        ### using the VIEW_ENROLLED_WAIT_COURSES isntead of enroll table to account for pending acceptance of wait -> enroll upgrade
        $request = $sql->prepare(
            "SELECT COUNT(".OBSCURE.USER_USERID.") FROM ".VIEW_ENROLLED_WAIT_COURSES." WHERE ".OBSCURE.COURSE_OFFERED_ID." =:".COURSE_OFFERED_ID
        );
        if (!$request[0]) {return $request;}
        $request = $sql->execute([COURSE_OFFERED_ID=>$offered_course_id]);
        if (!$request[0]) {return $request;}
        $request = $sql->get_last_results();
        if (!$request[0]) {return $request;}
        nl_dump($request);
        $current_count = $request[2][0][0];
        # compare  current count and limit
        $target_table = TABLE_COURSE_WAIT;
        $mode = WAIT;
        if ( $current_count < $limit )  {
            $target_table = TABLE_COURSE_ENROL;
            $mode = ENROLL;
        }
        $request = $sql->add_entry($target_table, [USER_USERID=>$user_id, COURSE_OFFERED_ID=>$offered_course_id]);
        if (!$request[0]) {return $request;}
        return [1, "Successfully $mode in $offered_course_id."];
}

    private static function get_sql() : DatabaseUtility {
    if (!isset(self::$_sql)) {
        global $database_source;
        self::$_sql = new DatabaseUtility($database_source, DATABASE_USER, DATABASE_KEY);
    }
    return self::$_sql;
    }
}