<?php

/*
* Email template for Login System
* Made by Bastiaan Smit
*/

/* Available options
* siteurl	= site base url
* clickurl	= click url
* mail		= email receiver
* sender	= name email sender
*
* Example: %reseturl%
*/

$subject = "Forgot password";

$message =
"
Dear Sir or Madam,

You can change your password for <a href='%siteurl%'>%siteurl%</a> by clicking <a href='%clickurl%'>here</a>.
You can also copy and paste the reset link into your browser:
%clickurl%

Kind regards,
%sender%
";

?>