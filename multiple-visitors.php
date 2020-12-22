<?php

require_once "inc/config.php";


// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'classes/' . $className . '.php';
});

// Instantiate Core Class
$visitor = new Visitor;
$core = new Core;






if(isset($_GET['number'])) {
    $phone = $_GET['number'];
    $phone = $core->formatPhone($phone);
    if(empty($phone)) {
        $core->setMessage('error', "<h1>Something went wrong. Number can't be empty.</h1>");
        $core->redirect('');
    } elseif(!preg_match("/^[0-9]*$/",$phone)) {
        $core->setMessage('error', "<h1>Something went wrong. Invalid characters in number.</h1>");
        $core->redirect('');
    }
}

if(isset($_GET['cancelID'])) {
    $cancelID = $_GET['cancelID'];

    if($cancelID == 'ALL') {
        //cancel all with number
        $visitor->cancelVisit($phone);
    } else {
        // cancel single
        $visitor->cancelVisit($phone, $cancelID);
    }
}

$queue = $visitor->getQueueByPhone($phone);



$title = 'Check Out';

require_once "inc/header.php";

?>






<div class="checkin">

    <a class="back-button" href="index.php" title="Back">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>

    <div class="cancel-multis mb-50">

        <h2>It looks like there are multiple people in queue with that phone number.</h2>
        <h3>What would you like to do?</h3>

    </div>




    <div class="other-queue centered mb-25">


        <div class="user-box th">
            <p>Name:</p>
            <p class="text-center">Checked In At:</p>
            <p class="time">Checked In At:</p>

        </div>


        <?php foreach($queue as $currentVisitor) : ?>

            <div class="user-box">
                <p class="name"><?= htmlspecialchars($currentVisitor->first_name); ?> <?= substr($currentVisitor->last_name, 0, 1) ?>.</p>
                <p class="text-center"><?= date('h:ia', strtotime($currentVisitor->checked_in_at)) ?></p>
                <p class="time"><a class="table-btn" href="multiple-visitors.php?number=<?= $phone ?>&cancelID=<?= $currentVisitor->id ?>">Check Out</a></p>
            </div>

        <?php endforeach; ?>

    </div>


    <h2 class="or mb-25">OR</h2>

    <a class="full-cancel-btn" href="multiple-visitors.php?number=<?= $phone ?>&cancelID=ALL">Check All Out</a>


</div>





<?php require_once "inc/footer.php"; ?>