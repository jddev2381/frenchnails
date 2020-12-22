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





if(isset($_GET['cid'])) {
    $clientID = $_GET['cid'];
    $clientID = number_format($clientID);
    $clientInfo = $admin->getClientInfo($clientID);
    if(!$clientInfo) {
        $core->setMessage('error', '<h1>Uh Oh!</h1><h2>Something went wrong.</h2><h3>Unable to find that client.</h3>');
        $core->redirect('admin/');
        die();
    }

} else {
    $core->setMessage('error', '<h1>Uh Oh!</h1><h2>Something went wrong.</h2><h3>Can not show that page right now.</h3>');
    $core->redirect('admin/');
    die();
}


if(isset($_GET['action'])) {
	if($_GET['action'] == 'noshow') {
    	if($admin->markAsNoShow($clientID)) {
    		// set message and redirect
    		$core->redirect('admin/');
    	} else {
    		// Should never reach here.
    		die('Something went wrong. Hit your back button and let JD know about this.');
    	}
    }
    if($_GET['action'] == 'checkin') {
        if($admin->markAsCheckedIn($clientID)) {
            $core->redirect('admin/');
        } else {
            // Should never reach here
            die("Something went wrong. Hit your back button and let JD know about this.");
        }
    }
}








$page = 'client';
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

    <h1 class="client-name"><?= htmlspecialchars($clientInfo->first_name) . ' ' . htmlspecialchars($clientInfo->last_name) ?></h1>



    <div class="current-time">
    	<h3>Current Time:</h3>
    	<h4><?= htmlspecialchars(date('h:ia', strtotime($core->currentTimeStamp()))); ?></h4>
    </div>

    <div class="client-info-wrapper">

    	<div class="phone">
    		<h3>Phone:</h3>
    		<h4><?= htmlspecialchars($core->prettyPhone($clientInfo->phone_number)) ?></h4>
    	</div>

    	<div class="time">
    		<h3>Checked In:</h3>
    		<h4><?= htmlspecialchars(date('h:ia', strtotime($clientInfo->checked_in_at))) ?></h4>
    	</div>

    	<div class="tech">
    		<h3>Desired Tech:</h3>
    		<h4>
    			<?php
					if($clientInfo->desired_tech != 'first') {
						echo htmlspecialchars($admin->getTechName($clientInfo->desired_tech));
					} else {
						echo 'Any';
					}
				?>
    		</h4>
    	</div>

    </div>

    <div class="client-info-wrapper">

    	<div class="work">
    		<h3>Work To Be Done:</h3>
    		<p class="mt-20">
    			<?php echo $admin->formatWorkDetails($clientInfo->work_done) ?>
    		</p>
    	</div>

    </div>



    <div class="check-in-buttons">

        <a class="noshow" href="<?= SITE_URL ?>admin/client.php?cid=<?= $clientID ?>&action=noshow">Not Available <i class="far fa-times-circle"></i></a>

        <a class="checkin" href="<?= SITE_URL ?>admin/client.php?cid=<?= $clientID ?>&action=checkin">Check In <i class="far fa-calendar-check"></i></a>

    	<!-- <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    		<input type="hidden" name="noshow" value="<?= htmlspecialchars($clientInfo->id) ?>">
    		<button type="submit" class="noshow">Not Available <i class="far fa-times-circle"></i></button>
    	</form>

    	<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    		<input type="hidden" name="checkin" value="<?= htmlspecialchars($clientInfo->id) ?>">
    		<button type="submit" class="checkin">Check In <i class="far fa-calendar-check"></i></button>
    	</form> -->

    </div>

    

</section>





<?php require_once "inc/footer.php"; ?>