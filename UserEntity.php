<?php
    require_once 'config.php';
    require_once 'DatabaseUtility.php';
    require_once 'OfferedCourses.php';
class UserEntity
{
    private static ?DatabaseUtility $_sql = null;
    private ?array $attributes = [USERENTITY_ROLE =>USERENTITY_GUEST];

    private function __construct(array $inputs)
    {
        if (IS_DEBUG) {echo "UserEntity=> construct inputs: "; nl_dump($inputs);}
        if (!isset($inputs[USER_USERID]) or !isset($inputs[USER_USERNAME])) {return $this;} # default user

        $sql = self::get_sql();
        $sql->prepare("SELECT * FROM ".TABLE_USER_INFORMATION." WHERE ".USER_USERID."= :".USER_USERID." AND ".USER_USERNAME." = :".USER_USERNAME);
        $sql->execute($inputs);
        $results = $sql->get_last_results();
        if (IS_DEBUG) {echo "UserEntity=> construct results: "; nl_dump($results);}
        if (!$results[0]) { return $this;} # default user
        $data = $results[2][0];
        foreach ([USER_GOESBY, USER_FULLNAME, USER_USERNAME, USER_USERID, USER_EMAIL, USER_PHONENUMBER] as $att) {
            if (isset($data[$att])) { $this->attributes[$att] = $data[$att]; }
        }
        $this->attributes[USERENTITY_ROLE] = USERENTITY_STUDENT;
        if (IS_DEBUG) { nl_dump($this->attributes);}
    }

    public static function get_default_user() : UserEntity
    {
        return new UserEntity([]);
    }

    public function request_enrollment(array $inputs) : array {
        if (IS_DEBUG) {echo "UserEntity-> request_enrollment inputs: ", nl_dump($inputs);}
        # validate inputs
        if (!isset($inputs[USER_USERID]) or !isset($inputs[COURSE_OFFERED_ID]) ) {
            return [0, "invalid inputs"];
        } else {
            if (!$this->get_attribute(USER_USERID) == $inputs[USER_USERID]) {
                return [0, "user mismatch"];
            }
        }
        $requested_course=$inputs[COURSE_OFFERED_ID];
        #make sure class is not duplicate
        $current_classes = $this->get_enroll_wait_course();
        if (IS_DEBUG) {echo "get_enroll_wait_course "; nl_dump($current_classes);}
        if (!$current_classes[0]) {return [0, "class retreaval for compare failed"];}
        # __offered_course_id, CourseID
        foreach ($current_classes[2] as $class_row) {
            if (IS_DEBUG) {echo "class_row: "; nl_dump($class_row);}
            $row_class = $class_row[OBSCURE.COURSE_OFFERED_ID];
            if ($class_row["Status"] == ENROLL and substr($requested_course,5, 6) == substr($row_class, 5, 6) ) {
                return [0, "Already ".$class_row['Status']." in class $row_class, can not enroll in $requested_course"];
            }
            if ($requested_course == $class_row[OBSCURE.COURSE_OFFERED_ID]) { # should be waitlists
                return [0, "Already ".$class_row['Status']." in class $requested_course"];
            }
        }
        # sent to course for enrollment
        return OfferedCourses::request_enrollment($inputs[USER_USERID], $requested_course);
    }

    public function drop_class(array $inputs) : array {
        if (IS_DEBUG) {echo "UserEntity->drop_class inputs: ", nl_dump($inputs);}
        # validate inputs
        if (!isset($inputs[USER_USERID]) or !isset($inputs[COURSE_OFFERED_ID]) ) {
            return [0, "invalid inputs"];
        }
        $params = [COURSE_OFFERED_ID => $inputs[COURSE_OFFERED_ID]];
        if ($this->get_attribute(USER_USERID) == $inputs[USER_USERID]) {
            $params[USER_USERID] = $inputs[USER_USERID];
            } else {
                return [0, "user mismatch"];
        }

        $sql = self::get_sql();
        foreach ([TABLE_COURSE_ENROL, TABLE_COURSE_ENROL] as $table){
            if (IS_DEBUG) {nl_dump($table);}
            $sql = self::get_sql();
            $request = $sql->prepare(
                "DELETE FROM $table WHERE "
                .USER_USERID." = :".USER_USERID." AND "
                .COURSE_OFFERED_ID." = :".COURSE_OFFERED_ID
            );
            if (!$request[0]) {return [0, "drop_class prepair failed for $table"];}
            $request = $sql->execute($params);
            if (!$request[0]) {return [0, "drop_class execute failed for $table"];}
        }
        return [1, "Dropping ".$inputs[COURSE_OFFERED_ID]." successful "];
    }
    public static function process_new_registration(array $input): array {
        if (IS_DEBUG) {echo '<class UserEntity-process_new_registration: '; ln_dump($input);}
        // Validate that data is usable
        $params = [];
        global $registration_req_headers;
        foreach ($registration_req_headers as $_ => $reqkey) {
            if (isset($input[$reqkey])) {
                $params[$reqkey] = $input[$reqkey];
                if ($reqkey == USER_USERNAME) {
                    // validate username is safe to add
                    if (self::username_found($input[$reqkey]) ){
                        return [0, 'duplicate Username'];
                    }
                }
            } else {return [0, "missing required value $reqkey"]; }
        }
        if (isset($input[USER_GOESBY])) {
            $params[USER_GOESBY] = $input[USER_GOESBY];
        } else {$params[USER_GOESBY] = $input[USER_FULLNAME];}
        $params[USER_PASSWORD_ENCRYPTED] = password_hash($params[USER_PASSWORD_PLAINTEXT], PASSWORD_DEFAULT);
        return self::get_sql()->add_entry(TABLE_USER_INFORMATION, $params);
    }

    private static function username_found(string $username) : bool {
        if (IS_DEBUG) {echo '<class UserEntity-username_found username: '; nl_dump($username);}

        self::get_sql()->prepare("SELECT ".USER_USERNAME." FROM ". TABLE_USER_INFORMATION. " WHERE ".USER_USERNAME." = :".USER_USERNAME);
        self::get_sql()->execute([USER_USERNAME => $username]);
        return count(self::get_sql()->get_last_results() ) == 1;
    }

    private static function get_sql() : DatabaseUtility {
        if (!isset(self::$_sql)) {
             global $database_source;
             self::$_sql = new DatabaseUtility($database_source, DATABASE_USER, DATABASE_KEY);
            }
        return self::$_sql;
    }

    public function get_attribute(string $key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        } return USERENTITY_GUEST;

    }

    public function has_role(string $request_role) : bool {
        if ($request_role == USERENTITY_GUEST) { return true;}
        return $this->get_attribute(USERENTITY_ROLE) == $request_role;
    }

    public static function process_login($input) : array {
        if (IS_DEBUG) {echo "UserEntity->process_long input: "; nl_dump($input) ;}

        if (!isset($input[USER_PASSWORD_PLAINTEXT])) {
            return [0, "Missing Parameter: ".USER_PASSWORD_PLAINTEXT, null ];
        }
        if (isset($input[USER_USERNAME])) {
            $params[USER_USERNAME] = $input[USER_USERNAME];
        } else {
            return [0, "Missing Parameter: ".USER_USERNAME];
        }

        $statement = "SELECT ".USER_USERID.", ".USER_PASSWORD_ENCRYPTED." FROM ".TABLE_USER_INFORMATION." 
        WHERE ".USER_USERNAME." = :".USER_USERNAME;
        $sql = self::get_sql();
        $sql->prepare($statement);
        $sql->execute($params);
        $results = $sql->get_last_results();
        nl_dump($results[2][0]);
        if ($results[0] == 0) {return [0, "No match found", $results];
        } elseif (password_verify($input[USER_PASSWORD_PLAINTEXT], $results[2][0][USER_PASSWORD_ENCRYPTED])) {

            $object = new UserEntity([USER_USERNAME => $params[USER_USERNAME], USER_USERID => $results[2][0][USER_USERID]]);
            nl_dump($object);
            if ($object == null) {
                return [0, "object create failed", $results];
            } else {
                return [1, "successes", $object];
            }
        } else {return [0, "fail", $results]; }
    }

    public function get_enroll_wait_course() : array {
        if (IS_DEBUG) {echo "UserEntity->get_enroll_wait_course user"; nl_dump($this->get_attribute(USER_USERID));}
        $sql = self::get_sql();
        $view = VIEW_ENROLLED_WAIT_COURSES;
        $key = OBSCURE.USER_USERID;
        $params[$key] = $this->get_attribute(USER_USERID);
        $results = $sql->prepare("SELECT * FROM $view WHERE $key = :$key");
        if ($results[0]) {
            $results = $sql->execute($params);
            if ($results[0]) {
                $results = $sql->get_last_results();
            }
        }
        return $results;
    }

    public function __serialize(): array
    {
        return $this->attributes;
    }

    public function __unserialize(Array $data) : void
    {
        $this->attributes = $data;
    }
}














