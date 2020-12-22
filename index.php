<?php

require_once "inc/config.php";


// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'classes/' . $className . '.php';
});

// Instantiate Core Class
$core = new Core;
$visitor = new Visitor;


$core->checkIP($ipAddress);


$nextVisitor = $visitor->getNext();

$queueCount = $visitor->queueCount();

$queue = $visitor->getQueue();

$count = 0;

header("Refresh: 60;");

$title = 'French Nails';
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







<div class="content">

    <div class="queue">

        <h2>NEXT</h2>

        <?php if($nextVisitor) : ?>
            <div class="user-box">
                <p class="name"><?= substr($nextVisitor->first_name, 0, 1) . substr($nextVisitor->last_name, 0, 1); ?></p>
                <p class="time"><span>Checked In At:</span> <?= date('h:ia', strtotime($nextVisitor->checked_in_at)); ?></p>
            </div>
        <?php else : ?>
            <div class="user-box">
                <p class="name">YOU</p>
                <p class="time">Register Now</p>
            </div>
        <?php endif; ?>

    </div>

    <div class="time">

        <h2>Current Time:</h2>

        <span class="current-time"> <?= date('h:ia', strtotime($core->currentTimeStamp())); ?> </span>

        <h3>People In Queue:<br><span> <?= $queueCount; ?> </span></h3>

        <h4>Updating In: <span class="white"><span id="timer">60</span> seconds</span></h4>

    </div>

    <div class="actions">

        <a class="check-in" href="check-in.php">Check In <i class="icon fas fa-sign-in-alt"></i></a>

        <a class="check-out" href="check-out.php">Check Out <i class="icon fas fa-sign-out-alt"></i></a>

    </div>


</div>

<script>
    var timeslot = document.getElementById('timer');
    var counter = 60;

    var x = setInterval(function() { 
        counter--
        timeslot.innerHTML = counter
    }, 1000);
</script>




<div class="other-queue">


    <h2>QUEUE</h2>

    <div class="user-box th">
        <p>Name:</p>
        <p class="text-center">Position:</p>
        <p class="time">Checked In At:</p>

    </div>

    <?php if(empty($queue)) : ?>
        <div class="user-box">
            <p style="width:100%; text-align:center;">The queue is currently empty! Register above.</p>
        </div>
    <?php else : ?>

        <?php foreach($queue as $currentVisitor) : ?>

            <?php $count ++; ?>

            <div class="user-box">
                <p class="name"><?= htmlspecialchars($currentVisitor->first_name); ?> <?= substr($currentVisitor->last_name, 0, 1) ?>.</p>
                <p class="text-center">#<?= $count ?></p>
                <p class="time"><?= date('h:ia', strtotime($currentVisitor->checked_in_at)) ?></p>
            </div>

        <?php endforeach; ?>

    <?php endif; ?>



</div>







<?php require_once "inc/footer.php"; ?>