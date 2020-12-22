<?php

require_once "../inc/config.php";


// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once '../classes/' . $className . '.php';
});

// Instantiate Core Class
$core = new Core;
$login = new Login;

//$login->check();


$email = '';
$error = '';

if(isset($_POST['login'])) {
	$email = strtolower(trim($_POST['email_address']));
	$pw = $_POST['pw'];


	if(!$login->login($email, $pw)) {
		$error = 'Invalid login credentials.';
	}
}


$page = 'login';
$title = "Log In";

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



<section id="login">


	<div class="box">
		<h3>Log In</h3>
		<?php 
			if(!empty($error)) : 
		?>
			<p class="error"><?= $error ?></p>
		<?php endif; ?>
		<form class="real" action="" method="POST">
			<input type="email" name="email_address" value="<?= $email ?>">
			<label>Email Address</label>

			<input type="password" name="pw">
			<label>Password</label>

			<button type="submit" name="login">GO <i style="padding-left:10px;" class="far fa-hand-point-right"></i></button>
		</form>
	</div>

</section>




<?php require_once "inc/footer.php"; ?>