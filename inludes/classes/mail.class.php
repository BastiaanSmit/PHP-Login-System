<?php

/*
* Mail Class used for Login System
* Made by Bastiaan Smit
*/

class Mail {    
    // Send mail
	public static function send($options)
	{
		// Set extra options
		$options["siteurl"] = isset($_SERVER["HTTPS"]) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . explode("?", $_SERVER['REQUEST_URI'])[0];
		$options["clickurl"] = $options["siteurl"]."?".$options["template"]."&email=".$options['mail']."&token=".$options['token'];
		$options["sender"] = Config::$config_mail_sender;
		
		// Load template
		$template = $options["template"];
		if (!empty($template) && file_exists("email_templates/$template.php"))
			include "email_templates/$template.php";
		elseif(Config::$config_debug)
		{
			echo "Email template not found! Mail not sended!";
			exit;
		}
		
		// Replace options in template with value's
		foreach($options as $key => $value)
		{
			$message = str_replace("%$key%",$value,$message);
		}
		
		// Setup mail headers
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
		$headers .= "From: ".Config::$config_mail_sender." <".Config::$config_mail_address.">" . "\r\n";
		
		// Send mail
		mail($options["mail"], $subject, nl2br($message), $headers);
	}
}