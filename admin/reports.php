<?php

require_once "../inc/config.php";


// Autoload Core Libraries
spl_autoload_register(function($className) {
    require_once '../classes/' . $className . '.php';
});

// Instantiate Core Class
$visitor = new Visitor;
$core = new Core;
$login = new Login;

$login->check();


$page = 'reports';
$title = "Reports";

require_once "inc/header.php";



?>



<section id="adminContent" class="fadeIn">

	<h1>Reports</h1>
    

    <h3 class="coming-soon">This section is coming soon!</h3>

</section>





<?php require_once "inc/footer.php"; ?>