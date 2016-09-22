<?php

if(isset($_POST['reset']))
{
	$umail = $_POST['email'];
	
	$message = $user->forgot_password($umail);
}

if(isset($_POST['update']))
{
	$umail = $_GET['email'];
	$utoken = $_GET['token'];
	$upass = $_POST['password'];
	$upass_repeat = $_POST['password_repeat'];
	
	$message = $user->forgot_password_reset($umail, $utoken, $upass, $upass_repeat);
}

?>
<?php 

if (isset($_GET['email']) && isset($_GET['token']))
{

?>
<div class="ui-body ui-body-a ui-corner-all login-body">
	<div class="login_head"><img src="images/login.png" width="168" height="168" /></div>
    <div data-role="navbar">
    	<ul>
    		<li><a data-theme="b" href="?login" class="ui-corner-left" data-ajax="false">Login</a></li>
    		<li><a data-theme="b" href="?register" data-ajax="false">Register</a></li>
    		<li><a data-theme="b" href="?change" class="ui-corner-right" data-ajax="false">Change password</a></li>
    	</ul>
	</div>
    <div>
		<form id="forgot_form" data-ajax="false" method="post">
			<?php if (!empty($message)) { ?><div id="message" class="ui-body-a ui-body ui-corner-all"><?php echo $message; ?></div><?php } ?>
			<div class="ui-field-contain">
				<input type="password" name="password" id="password" maxlength="30" placeholder="Password"/>
			</div>
			<div class="ui-field-contain">
				<input type="password" name="password_repeat" id="password_repeat" maxlength="30" placeholder="Repeat password"/>
			</div>
			<div class="ui-field-contain">
				<input data-theme="b" type="submit" name="update" id="update" value="Update password"/>
			</div>
		</form>
	</div>
</div>
<?php 

}
else
{ 

?>
<div class="ui-body ui-body-a ui-corner-all login-body">
	<div class="login_head"><img src="images/login.png" width="168" height="168" /></div>
    <div data-role="navbar">
    	<ul>
    		<li><a data-theme="b" href="?login" class="ui-corner-left" data-ajax="false">Login</a></li>
    		<li><a data-theme="b" href="?register" data-ajax="false">Register</a></li>
    		<li><a data-theme="b" href="?change" class="ui-corner-right" data-ajax="false">Change password</a></li>
    	</ul>
</div>
    <div>
		<form id="forgot_form" data-ajax="false" method="post">
			<?php if (!empty($message)) { ?><div id="message" class="ui-body-a ui-body ui-corner-all"><?php echo $message; ?></div><?php } ?>
	    	<div class="ui-field-contain">
				<input type="email" name="email" id="email" maxlength="100" placeholder="Email address"/>
			</div>
			<div class="ui-field-contain">
				<input data-theme="b" type="submit" name="reset" id="reset" value="Send reset email"/>
			</div>
		</form>
	</div>
</div>
<?php 

}

?>