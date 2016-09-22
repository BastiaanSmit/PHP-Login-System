<?php

/*
* Include all files used for Login System
* Made by Bastiaan Smit
*/

// Load config
require_once 'includes/config.php';
new Config();

// Show error's if debug option = true
if (Config::$config_debug)
{
	ini_set("display_errors", "1");
	error_reporting(E_ALL);
}

// Start session
session_start();

// Auto load classes
function __autoload($class_name) {
    require_once('includes/classes/'.strtolower($class_name).'.class.php');
}

?>