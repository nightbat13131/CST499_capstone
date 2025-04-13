<?php
const IS_DEBUG = false;

const PAGE_ACCOUNT_REGISTRATION = "account_registration.php";
const PAGE_CLASS_ENROLLMENT = "class_enrollment.php";
const PAGE_LANDING = "landing_page.php";
const PAGE_LOGIN = "login.php";
const PAGE_USER_ACCOUNT = "user_account.php";
const ADMIN_ADD_COURSE = 'admin_add_course.php';
const WIDGET_DROP_CLASS = 'widget_drop_class.php';
const WIDGET_USER_ENROLLED = 'widget_user_enrolled.php';
const WIDGET_OFFERED_CLASSES = 'widget_available_classes.php';
const WIDGET_REQUEST_ENROLL = 'widget_request_enroll.php';

const PROCESS_ACCOUNT_REGISTRATION = "process_account_registration.php";
const PROCESS_ADD_OFFERED_COURSE = 'process_add_offered_course.php';
const PROCESS_DROP_CLASS ='process_drop_class.php';
const PROCESS_LOGIN = "process_login.php";
const PROCESS_LOGOUT = "process_logout.php";
const PROCESS_REQUEST_ENROLL = 'process_request_enroll.php';


const USER_USERID = "user_id";
const USER_USERNAME = "user_name";
const USER_PASSWORD_ENCRYPTED = "e_password";
const USER_PASSWORD_PLAINTEXT = "pass_plain_text";
const USER_FULLNAME = "full_name";
const USER_GOESBY = "goes_by_name";
const USER_PHONENUMBER = "phone";
const USER_EMAIL = "email";
const USERENTITY_ROLE = 'UserRole';
const USERENTITY_GUEST = 'Guest';
const USERENTITY_STUDENT = 'UserRole_Student';
const COOKIE_USERIDETITY = 'cookie_serialized_user';
const COURSE_OFFERED_ID = 'offered_course_id';
const COURSE_YEAR = 'year';
const COURSE_SEMESTER_ID = 'semester_id';
const COURSE_ID = 'course_id';

const TABLE_USER_INFORMATION = 'tbl_users';
const TABLE_COURSES = 'tbl_courses';
const TABLE_OFFERED_COURSE = 'tbl_offered_courses';
const TABLE_COURSE_ENROL = 'tbl_users_enrolled';
const TABLE_COURSE_WAIT = 'tbl_users_waitlisted';

const VIEW_ENROLLED_WAIT_COURSES = 'vw_enrol_wait_courses';

const OBSCURE = '__';
const ENROLL = 'Enrolled';
CONST WAIT = 'Waitlist';
$registration_req_headers =[USER_FULLNAME, USER_PHONENUMBER, USER_EMAIL, USER_USERNAME, USER_PASSWORD_PLAINTEXT ];


const DATABASE_HOST = '127.0.0.1';
const DATABASE_DBNAME = 'cst499';

$database_source = "mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_DBNAME;
const DATABASE_USER = 'root';
const DATABASE_KEY = 'root';
