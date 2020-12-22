<?php

require_once "inc/config.php";


// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'classes/' . $className . '.php';
});


// Instantiate Core Class
$visitor = new Visitor;
$core = new Core;


$core->checkIP($ipAddress);



$phone = '';

if(isset($_POST['checkOut'])) {

    $phone = $_POST['phone'];
    $phone = $core->formatPhone($phone);
    
    if(empty($phone)) {
        $error = true;
        $error_phone = 'You must provide your phone number.';
    } elseif(!preg_match("/^[0-9]*$/",$phone)) {
        $error = true;
        $error_phone = 'Only numbers are allowed in your phone number.';
    }

    if(!$error) {
        $visitor->checkVisitorOut($phone);
    }
}



$title = 'Check Out';
require_once "inc/header.php";

?>






<div class="checkin">

    <h2>Check Out</h2>

    <p class="intro mb-50"><strong>We are really sorry to see you go!</strong> To check out, please enter the phone number you used to check in and we will take care of the rest.</p>


    <?php if($error) : ?>
        <div class="errors mb-50">
            <?php if(!empty($error_generic)) : ?>
                <h3 class="mb-50"><?= $error_generic; ?></h3>
            <?php else : ?>
                <h3>Please fix the errors below.</h3>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">


        <div class="form-group mb-50">
            <input type="text" name="phone" value="<?= htmlspecialchars($phone); ?>">
            <label>Phone Number</label>
            <?php if(!empty($error_phone)) : ?>
                <p class="error"><?= $error_phone; ?></p>
            <?php endif; ?>
        </div>


        <div class="flexed contains-btns mb-50">
            <a href="index.php">Cancel <i class="icon fas fa-times"></i></a>
            <button type="submit" name="checkOut">Check Out <i class="icon fas fa-sign-out-alt"></i></button>
        </div>

    </form>


</div>





<?php require_once "inc/footer.php"; ?>