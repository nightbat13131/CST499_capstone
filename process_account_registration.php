<?php
    error_reporting(E_ALL ^ E_NOTICE);

    require_once 'config.php';
    require_once 'DatabaseUtility.php';
    require_once 'UserEntity.php';

echo "process  account registration"; var_dump($_POST); echo '<br>';
global $registration_req_headers;
echo var_dump($registration_req_headers) .'<br>';


$input = $_POST;

$params = [];

foreach ($registration_req_headers as $_ => $reqkey) {
    // echo "<br> $_ $reqkey";
    //var_dump(array_key_exists($reqkey, $input));
    if (isset($input[$reqkey])) {
        //echo "why not!";
        $params[$reqkey] = $input[$reqkey];
        //var_dump($params);
    } else {
        echo "0 - missing required value"; // replace with return
        break;
    }

}
if (isset($input[USER_GOESBY])) {
    $params[USER_GOESBY] = $input[USER_GOESBY];
} else {$params[USER_GOESBY] = $input[USER_FULLNAME];}

if (isset($input[USER_PHYSICAL_ADDRESS])) {
    $params[USER_PHYSICAL_ADDRESS] = $input[USER_PHYSICAL_ADDRESS];
}
$params[USER_PASSWORD_ENCRYPTED] = password_hash($params[USER_PASSWORD_PLAINTEXT], PASSWORD_DEFAULT);
// https://www.w3schools.com/php/php_mysql_prepared_statements.asp



global $database_source;
$sql = new DatabaseUtility($database_source, DATABASE_USER, DATABASE_KEY);


var_dump($sql->add_entry(TABLE_USER_INFORMATION, $params) );