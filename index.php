<?php

// Include settings and classes
require_once 'includes/include.php';

// Create user object
$user = new User();

// Include header
include 'templates/header.php';

// Include selected template or login template if not found
$template = explode("&",$_SERVER['QUERY_STRING'])[0];
if (!empty($action) && file_exists("templates/$template.php"))
	include "templates/$template.php";
else
	include 'templates/login.php';

// Include footer
include 'templates/footer.php';
	
?>
