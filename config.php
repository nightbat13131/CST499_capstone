<?php
const IS_DEBUG = false;

const ACCOUNT_REGISTRATION_PAGE = "account_registration.php";
const LANDING_PAGE = "landing_page.php";
const LOGIN_PAGE = "login.php";
const USER_ACCOUNT_PAGE = "user_account.php";
const ACCOUNT_REGISTRATION_PROCESS = "process_account_registration.php";

const USER_USERID = "user_id";
const USER_USERNAME = "user_name";
const USER_PASSWORD_ENCRYPTED = "e_password";
const USER_PASSWORD_PLAINTEXT = "pass_plain_text";
const USER_FULLNAME = "full_name";
const USER_GOESBY = "goes_by_name";
const USER_PHONENUMBER = "phone";
const USER_EMAIL = "email";
const USER_PHYSICAL_ADDRESS = "physical_address";
const USER_REGISTRATION_DATE = 'registration_date';
const USER_MODIFIED_DATE ='modified_date';

const OFFERED_OFFERED_COURSE_ID = 'offered_course_id ';
const OFFERED_COURSE_YEAR = 'year';
const OFFERED_COURSE_SEMESTER = 'semester_id';
const OFFERED_COURSE_ID = 'course_id';

const TABLE_USER_INFORMATION = 'tbl_users';

const TABLE_OFFERED_COURSE = 'tbl_offered_courses';

$registration_req_headers =[USER_FULLNAME, USER_PHONENUMBER, USER_EMAIL, USER_USERNAME, USER_PASSWORD_PLAINTEXT ];
$user_table_headers = $registration_req_headers + [USER_USERID, USER_PASSWORD_ENCRYPTED, USER_PHYSICAL_ADDRESS, USER_REGISTRATION_DATE, USER_MODIFIED_DATE ];



const DATABASE_HOST = '127.0.0.1';
const DATABASE_DBNAME = 'cst499';

$database_source = "mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_DBNAME;
const DATABASE_USER = 'root';
const DATABASE_KEY = 'root';


?>