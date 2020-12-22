<?php

require_once "../inc/config.php";


// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once '../classes/' . $className . '.php';
});

// Instantiate Core Class
$visitor = new Visitor;
$core = new Core;
$admin = new Admin;
$login = new Login;

$login->check();


$error = '';

if(isset($_POST['submit'])) {
    $currentPW = $_POST['current_pw'];
    $newPW = $_POST['new_pw'];
    $newPW2 = $_POST['confirm_new_pw'];

    if(empty($currentPW) || empty($newPW) || empty($newPW2)) {
        $error = 'You must complete all fields.';
    } elseif($newPW !== $newPW2) {
        $error = 'Your new passwords did not match one another.';
    }

    if(empty($error)) {
        // Let's check the current pw and update
        if($login->checkCurrentPW($currentPW)) {
            // password matched, let's now update the pw
            $login->updatePW($newPW);
        } else {
            $error = 'You current password was incorrect.';
        }
    }


}
 


$page = 'profile';
$title = 'Dashbaord';

require_once "inc/header.php";



?>





<?php if(isset($_SESSION['message'])) : ?>

    <div id="flashMessage" class="flash-message <?= $_SESSION['message_type']; ?>">
        <div class="message-wrapper">
            <?= $_SESSION['message'] ?>
            <a class="dismiss-button" onclick="dismissMessage()">OK <i class="icon fas fa-check"></i></a>
        </div>
    </div>

<?php endif; ?>



<?php $core->clearMessage(); ?>








<section id="adminContent" class="fadeIn">


    <h1>Your Profile</h1>

    
    <div class="box" style="max-width:500px;">

        <h3>Update Password:</h3>

        <?php if(!empty($error)) : ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <form class="real" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
            <input type="password" name="current_pw">
            <label>Current Password</label>

            <input type="password" name="new_pw">
            <label>New Password</label>

            <input type="password" name="confirm_new_pw">
            <label>Repeat New Password</label>

            <button style="margin:0 auto; margin-top:30px;" type="submit" name="submit">Update Password</button>

        </form>


</section>






<?php require_once "inc/footer.php"; ?>