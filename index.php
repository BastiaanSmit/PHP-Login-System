<?php

// Include settings and classes
require_once 'includes/include.php';
$user = new User();

// Include header
include 'templates/header.php';

// Include page or login if not found
$action = explode("&",$_SERVER['QUERY_STRING'])[0];
if (!empty($action) && file_exists("templates/$action.php"))
	include "templates/$action.php";
else
	include 'templates/login.php';

// Include footer
include 'templates/footer.php';
	
?>