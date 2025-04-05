
//https://getbootstrap.com/docs/5.2/forms/form-control/

<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">-->
    <title>Landing Page</title>
    <!--<script scr="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>-->
</head>
<body>
<?php require_once "page_header.php";?>

<div class='container-lg text-center'>

    <h1>Registration</h1>
    <?php echo '
    <form method="post" action="'.ACCOUNT_REGISTRATION_PROCESS.'">
        <fieldset>
            <legend>Registration Form</legend>
            
            <label for="'.USER_FULLNAME.'">Full Name</label>
            <input type="text" name="'.USER_FULLNAME.'" id="'.USER_FULLNAME.'" required/>
            
            <label for="'.USER_GOESBY.'">Nick Name</label>
            <input type="text" name="'.USER_GOESBY.'" id="'.USER_GOESBY.'"/>
            
            <label for="'.USER_PHONENUMBER.'">Phone Number</label>
            <input type="tel" name="'.USER_PHONENUMBER.'" id="'.USER_PHONENUMBER.'" required/>
            
            <label for="'.USER_EMAIL.'">Email Address</label>
            <input type="email" name="'.USER_EMAIL.'" id="'.USER_EMAIL.'" required/>
            
            <label for="'.USER_USERNAME.'">UserName (used to log into account)</label>
            <input type="text" name="'.USER_USERNAME.'" id="'.USER_USERNAME.'"/>
            
            <label for="'.USER_PASSWORD_PLAINTEXT.'">Password</label>
            <input type="password" name="'.USER_PASSWORD_PLAINTEXT.'" id="'.USER_PASSWORD_PLAINTEXT.'"/>
            
            <input type="submit" />
        </fieldset>
    </form>
' ?>




</div>

<?php require_once "page_footer.php";?>

</body>