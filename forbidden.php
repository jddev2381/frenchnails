<?php

require_once "inc/config.php";


// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once 'classes/' . $className . '.php';
});

// Instantiate Core Class
$core = new Core;
$visitor = new Visitor;


$core->reverseIP($ipAddress);

$title = 'Forbidden';
require_once "inc/header.php";


header("Refresh: 20;");

?>





<div class="forbidden">
    <h2>Sorry, you can't currently access this system.</h2>
    <h3>Please see a nail tech to have them give you access.</h3>
    <p>Checking in <span id="timeslot">20</span> seconds</p>
</div>




<script>
    var timeslot = document.getElementById('timeslot');
    var counter = 20;

    var x = setInterval(function() { 
        counter--
        timeslot.innerHTML = counter
    }, 1000);
</script>






<?php require_once "inc/footer.php"; ?>