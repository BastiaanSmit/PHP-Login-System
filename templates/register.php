<?php

if (isset($_GET['email']) && isset($_GET['token']))
{
	$message = $user->register_activate($_GET['email'], $_GET['token']);
}

if(isset($_POST['register']))
{
	$fname = $_POST['firstname'];
	$lname = $_POST['lastname'];
	$umail = $_POST['email'];
	$upass = $_POST['password'];
	$upass_repeat = $_POST['password_repeat'];

	$message = $user->register($fname,$lname,$umail,$upass,$upass_repeat);
}

if($user->is_loggedin())
	$user->redirect('?welcome');

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
    		<li><a data-theme="b" href="?forgot" data-ajax="false">Forgot password</a></li>
    		<li><a data-theme="b" href="?change" class="ui-corner-right" data-ajax="false">Change password</a></li>
    	</ul>
	</div>
    <div>
		<form id="register_form" action="?login" data-ajax="false" method="post">
			<?php if (!empty($message)) { ?><div id="message" class="ui-body-a ui-body ui-corner-all"><?php echo $message; ?></div><?php } ?>
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
    		<li><a data-theme="b" href="?forgot" data-ajax="false">Forgot password</a></li>
    		<li><a data-theme="b" href="?change" class="ui-corner-right" data-ajax="false">Change password</a></li>
    	</ul>
	</div>
    <div>
		<form id="register_form" data-ajax="false" method="post">
			<?php if (!empty($message)) { ?><div id="message" class="ui-body-a ui-body ui-corner-all"><?php echo $message; ?></div><?php } ?>
	    	<div class="ui-field-contain">
				<input type="text" name="firstname" id="firstname" maxlength="50" placeholder="First name"/>
			</div>
	    	<div class="ui-field-contain">
				<input type="text" name="lastname" id="lastname" maxlength="50" placeholder="Last name"/>
			</div>
	    	<div class="ui-field-contain">
				<input type="email" name="email" id="email" maxlength="100" placeholder="Email address"/>
			</div>
			<div class="ui-field-contain">
				<input type="password" name="password" id="password" maxlength="30" placeholder="Password"/>
			</div>
			<div class="ui-field-contain">
				<input type="password" name="password_repeat" id="password_repeat" maxlength="30" placeholder="Repeat password"/>
			</div>
			<div class="ui-field-contain">
				<input data-theme="b" type="submit" name="register" id="register" value="Register"/>
			</div>
		</form>
	</div>
</div>
<?php 

}

?>