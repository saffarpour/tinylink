<?php

/**
 * Description of index.php
 * Main entry point of application
 * @author Reza
 */ 

spl_autoload_register(function($class_name) {
    if (file_exists('./Views/' . $class_name . '.php')) {
        require_once './Views/' . $class_name . '.php';
    } else if (file_exists('./Controllers/' . $class_name . '.php')) {
        require_once './Controllers/' . $class_name . '.php';
    } else if (file_exists('./Models/' . $class_name . '.php')) {
        require_once './Models/' . $class_name . '.php';
    } else if (file_exists('./classes/' . $class_name . '.php')) {
        require_once './classes/' . $class_name . '.php';
    } else if (file_exists('./Config/' . $class_name . '.php')) {
        require_once './Config/' . $class_name . '.php';
    }
});

error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);

header("Author: Reza Saffarpour");

$tinyLinkRouter = new Router();
$userParam = $tinyLinkRouter->getUserParams();

$iController = new IndexController();
$iController->processRequest($userParam);
