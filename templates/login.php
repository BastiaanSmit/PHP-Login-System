<?php
	
if(isset($_POST['login']))
{
	$umail = $_POST['email'];
	$upass = $_POST['password'];
	
	$message = $user->login($umail,$upass);
}

if($user->is_loggedin())
	$user->redirect('?welcome');

?>
<div class="ui-body ui-body-a ui-corner-all login-body">
	<div class="login_head"><img src="images/login.png" width="168" height="168" /></div>
    <div data-role="navbar">
    	<ul>
    		<li><a data-theme="b" href="?register" class="ui-corner-left" data-ajax="false">Register</a></li>
    		<li><a data-theme="b" href="?forgot" data-ajax="false">Forgot password</a></li>
    		<li><a data-theme="b" href="?change" class="ui-corner-right" data-ajax="false">Change password</a></li>
    	</ul>
	</div>
    <div>
		<form id="login_form" data-ajax="false" method="post">
			<?php if (!empty($message)) { ?><div id="message" class="ui-body-a ui-body ui-corner-all"><?php echo $message; ?></div><?php } ?>
	    	<div class="ui-field-contain">
				<input type="email" name="email" id="email" maxlength="100" placeholder="Email address"/>
			</div>
			<div class="ui-field-contain">
				<input type="password" name="password" id="password" maxlength="30" placeholder="Password"/>
			</div>
			<div class="ui-field-contain">
				<input data-theme="b" type="submit" name="login" id="login" value="Login"/>
			</div>
		</form>
	</div>
</div>