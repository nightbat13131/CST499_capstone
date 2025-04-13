<?php  //https://getbootstrap.com/docs/5.2/forms/form-control/
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

    <?php echo '
    <form method="post" action="'.PROCESS_ACCOUNT_REGISTRATION.'">
        <fieldset>
            <legend>Registration Form</legend>
            <div class="row">
                <div class="col text-end">
                    <label for="'.USER_FULLNAME.'">Full Name</label>
                    </div>
                    <div class="col text-start">
                    <input type="text" name="'.USER_FULLNAME.'" id="'.USER_FULLNAME.'" required/>
                </div>
            </div>
            <div class="row">
                <div class="col text-end">
                    <label for="'.USER_GOESBY.'">Nick Name</label>
                    </div>
                    <div class="col text-start">
                    <input type="text" name="'.USER_GOESBY.'" id="'.USER_GOESBY.'"/>
                </div>
            </div>
            <div class="row">
                <div class="col text-end">
                    <label for="'.USER_PHONENUMBER.'">Phone Number</label>
                    </div>
                    <div class="col text-start">
                    <input type="tel" name="'.USER_PHONENUMBER.'" id="'.USER_PHONENUMBER.'" required/>
                </div>
            </div>
            <div class="row">
                <div class="col text-end">
                    <label for="'.USER_EMAIL.'">Email Address</label>
                    </div>
                    <div class="col text-start">
                    <input type="email" name="'.USER_EMAIL.'" id="'.USER_EMAIL.'" required/>
                </div>
            </div>
            <div class="row">
                <div class="col text-end">
                    <label for="'.USER_USERNAME.'">UserName</label>
                    </div>
                    <div class="col text-start">
                    <input type="text" name="'.USER_USERNAME.'" id="'.USER_USERNAME.'" placeholder="used to log into account"/>
                </div>
            </div>
            <div class="row">
                <div class="col text-end">
                    <label for="'.USER_PASSWORD_PLAINTEXT.'">Password</label>
                    </div>
                    <div class="col text-start">
                    <input type="password" name="'.USER_PASSWORD_PLAINTEXT.'" id="'.USER_PASSWORD_PLAINTEXT.'"/>
                </div>
            </div>
            <input type="submit" />
        </fieldset>
    </form>
' ?>
</div>
<?php require_once "page_footer.php";?>
</body>