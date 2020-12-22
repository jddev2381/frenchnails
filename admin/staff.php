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



$error = false;
$techName = '';
$error_techName = '';

if(isset($_POST['techName'])) {
	$techName = trim(ucwords(strtolower($_POST['techName'])));

	if(empty($techName)) {
        $error = true;
        $error_techName = 'You must provide the tech\'s name.';
    } elseif(!preg_match("/^[a-zA-Z\' ]*$/",$techName)) {
        $error = true;
        $error_techName = 'Only letters are allowed in the tech\'s name.';
    }


    if(!$error) {
    	$admin->addNailTech($techName);
    }


}

if(isset($_POST['delete-tech'])) {
	$techToDelete = $_POST['delete-tech'];
	$admin->deleteTech($techToDelete);
}


$nailTechs = $admin->getAllTechs();


if(isset($_GET['toggleTechAvailability'])) {
	$techToToggle = $_GET['toggleTechAvailability'];
	$admin->toggleTechAvailability($techToToggle);
}


$page = 'staff';
$title = 'Staff';

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

	<h1>Staff</h1>


	<div class="fiddy-fiddy">


		<div class="main add-box box">
	        <h3>Add Tech</h3>

	        <?php if($error) : ?>
	        	<h4 class="error">Please fix the errors below.</h4>
	        <?php endif; ?>


	        <form class="real" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
	            <input name="techName" id="techName" type="text" value="">
	            <label>Tech's Name</label>
	            <?php if(!empty($error_techName)) : ?>
                    <p class="error"><?= $error_techName; ?></p>
                <?php endif; ?>
	            <div class="center-item mt-20">
	            	<button type="submit" name="addTech">Add Tech</button>
	            </div>

	        </form>
	    </div>


	    <div class="main clear-box box">

	    	<h3>Current Techs 
	    		<span class="tooltip" style="margin-left:5px;">
	    			<i class="fas fa-question-circle"></i>
	    			<span class="tooltiptext bottom">
	    				You can toggle the techs availability on/off here. Toggling a tech to "on" will allow clients to choose that tech when they are registering. A tech that is "off" will not show to the client.
	    			</span>
	    		</span>
	    	</h3>

	    	<table id="" class="table">
	    		<thead>
	    			<tr>
	    				<th>Name</th>
	    				<th>Availability</th>
	    				<th>Delete</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<?php foreach($nailTechs as $tech) : ?>
	    				<tr>
	    					<td><?= htmlspecialchars($tech->name) ?></td>
	    					<td>
	    						<label class="switch">
	    							<input type="checkbox" name="techAvailability" onclick="toggleTechAvailability(<?= $tech->worker_id ?>)" value="<?= $tech->worker_id ?>" <?= $tech->available ? 'checked' : ''; ?>>
	    							<span class="slider round"></span>
	    						</label>
	    					</td>
	    					<td><span class="deleteTech" onclick="showDeleteBox(<?= $tech->worker_id ?>)" title="This will permanently delete tech!"><i class="fas fa-trash-alt"></i></span></td>
	    				</tr>
	    			<?php endforeach; ?>
	    			<!-- <tr>
	    				<td>JD Simpkins</td>
	    				<td>
	    					<label class="switch">
							 	<input type="checkbox" checked>
								<span class="slider round"></span>
							</label>
	    				</td>
	    				<td></td>
	    			</tr>
	    			<tr>
	    				<td>JD Simpkins</td>
	    				<td></td>
	    				<td></td>
	    			</tr> -->

	    		</tbody>
	    	</table>

	    </div>

	</div>






</section>




<?php foreach($nailTechs as $tech) : ?>
	<div id="deleteTech<?= $tech->worker_id ?>" class="popup-box fadeIn">
		<div class="content">
			<h2>Are you sure you want to delete <?= $tech->name ?>?</h2>
			<h3>This action can't be undone!</h3>
			<div class="buttons">
				<button class="close" onclick="dismissDeleteBox(<?= $tech->worker_id ?>)">No</button>
				<form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
					<input type="hidden" name="delete-tech" value="<?= $tech->worker_id ?>">
					<button class="continue" type="submit">Yes</button>
				</form>
			</div>
		</div>
	</div>
<?php endforeach; ?>



<?php require_once "inc/footer.php"; ?>