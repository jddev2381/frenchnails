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



session_unset();
session_destroy();

$core->setMessage('success', '<h1>You\'ve been logged out successfully!<h1>');
$core->redirect('admin/login.php');






?>
