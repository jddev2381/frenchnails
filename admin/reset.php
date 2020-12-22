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



if(isset($_GET['pass'])) {
    $resetCode = $_GET['pass'];
    $core->updateNewIP($ipAddress, $resetCode);
    $core->setMessage('success', "<h1>You did it! <i class=\"fas fa-check\"></i></h1><h2>The system has been reset and your clients can now check in.<h2>");
    $core->redirect('admin/');
    die();
    exit();
} else {
    $core->redirect('');
    die('Get out!');
}




$page = 'reset';
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


    

</section>





<?php require_once "inc/footer.php"; ?>