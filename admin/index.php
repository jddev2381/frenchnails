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

$clientsInQueue = $visitor->getQueue();

$clientCount = count($clientsInQueue);



header("Refresh: 60;");


$page = 'home';
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

	<h4 id="refreshTimer">Updating In: <span class="white"><span id="timer">60</span> seconds</span></h4>

    <h1>Dashboard</h1>

    <table class="table">
    	<thead>
    		<tr>
    			<th>Name</th>
    			<th>Phone</th>
    			<th>Checked In At</th>
    			<th>
    				Nail Tech
    				<span class="tooltip" style="margin-left:5px;">
		    			<i class="fas fa-question-circle"></i>
		    			<span class="tooltiptext bottom">
		    				If this is blank, they chose "First Available" and have no preference.
		    			</span>
		    		</span>
    			</th>
    			<th>Details</th>
    		</tr>
    	</thead>
    	<tbody>
    		<?php if($clientCount > 0) : ?>
	    		<?php foreach($clientsInQueue as $clientInfo) : ?>
	    			<tr class="clickable" onclick="window.location.href='<?= SITE_URL ?>admin/client.php?cid=<?= $clientInfo->id ?>';">
	    				<td><?= htmlspecialchars($clientInfo->first_name) . ' ' . htmlspecialchars($clientInfo->last_name) ?></td>
	    				<td><?= htmlspecialchars($core->prettyPhone($clientInfo->phone_number)) ?></td>
	    				<td><?= htmlspecialchars(date('h:ia', strtotime($clientInfo->checked_in_at))); ?></td>
	    				<td>
	    					<?php
	    						if($clientInfo->desired_tech != 'first') {
	    							echo htmlspecialchars($admin->getTechName($clientInfo->desired_tech));
	    						}
	    					?>	
	    				</td>
	    				<td><?php echo $admin->formatWorkDetails($clientInfo->work_done) ?></td>
	    			</tr>
	    		<?php endforeach; ?>
	    	<?php else : ?>
	    		<tr>
	    			<td colspan="5">
	    				There are currently no clients in queue.
	    			</td>
	    		</tr>
	    	<?php endif; ?>
    	</tbody>
    </table>


</section>



<script>
    var timeslot = document.getElementById('timer');
    var counter = 60;

    var x = setInterval(function() { 
        counter--
        timeslot.innerHTML = counter
    }, 1000);
</script>



<?php require_once "inc/footer.php"; ?>