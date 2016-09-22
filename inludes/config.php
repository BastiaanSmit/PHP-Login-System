<?php

class Config {

	/*
	* DATABASE CONFIGURATION
	*/

	// Database host
	static $config_db_host = "localhost";
	// Database name
	static $config_db_name = "database";
	// Database username
	static $config_db_user = "username";
	// Database password
	static $config_db_pass = "password";

	/*
	* MAIL CONFIGURATION
	*/

	// Sender name
	static $config_mail_sender = "Example";
	// Sender mail address
	static $config_mail_address = "example@mail.com";

	/*
	* PASSWORD CONFIGURATION
	*/

	// Minimal password length
	static $config_password_length = 8;
	// Complex passwords (at least one uppercase letter, one lowercase letter and one number)
	static $config_password_complex = true;

	/*
	* GENERAL CONFIGURATION
	*/

	// Show error messages
	static $config_debug = true;

}

?>