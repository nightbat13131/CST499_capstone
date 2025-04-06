<?php
    require_once 'config.php';
class UserEntity
{
    private static ?DatabaseUtility $_sql = null;

    public static function process_new_registration(array $input): array {
        if (IS_DEBUG) {echo '<class UserEntity-process_new_registration: '; var_dump($input); echo '<br>';}

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
        if (IS_DEBUG) {echo "post foreach <br>";}
        if (isset($input[USER_GOESBY])) {
            $params[USER_GOESBY] = $input[USER_GOESBY];
        } else {$params[USER_GOESBY] = $input[USER_FULLNAME];}

        if (isset($input[USER_PHYSICAL_ADDRESS])) {
            $params[USER_PHYSICAL_ADDRESS] = $input[USER_PHYSICAL_ADDRESS];
        }
        $params[USER_PASSWORD_ENCRYPTED] = password_hash($params[USER_PASSWORD_PLAINTEXT], PASSWORD_DEFAULT);


        return self::get_sql()->add_entry(TABLE_USER_INFORMATION, $params);
    }

    private static function username_found(string $username) : bool {
        if (IS_DEBUG) {echo '<class UserEntity-username_found username: '; var_dump($username); echo '<br>';}
        $found = true;
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

}