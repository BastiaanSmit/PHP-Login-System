<?php

if(isset($_POST['change']))
{
	$umail = $_POST['email'];
	$upass_old = $_POST['password_old'];
	$upass_new = $_POST['password_new'];
	$upass_new_repeat = $_POST['password_new_repeat'];
	
	$message = $user->change_password($umail,$upass_old,$upass_new,$upass_new_repeat);
}

?>
<div class="ui-body ui-body-a ui-corner-all login-body">
	<div class="login_head"><img src="images/login.png" width="168" height="168" /></div>
    <div data-role="navbar">
    	<ul>
    		<li><a data-theme="b" href="?login" class="ui-corner-left" data-ajax="false">Login</a></li>
    		<li><a data-theme="b" href="?register" data-ajax="false">Register</a></li>
    		<li><a data-theme="b" href="?forgot" class="ui-corner-right" data-ajax="false">Forgot password</a></li>
    	</ul>
	</div>
    <div>
		<form id="change_form" data-ajax="false" method="post">
			<?php if (!empty($message)) { ?><div id="message" class="ui-body-a ui-body ui-corner-all"><?php echo $message; ?></div><?php } ?>
	    	<div class="ui-field-contain">
				<input type="email" name="email" id="email" maxlength="100" placeholder="Email address"/>
			</div>
			<div class="ui-field-contain">
				<input type="password" name="password_old" id="password_old" maxlength="30" placeholder="Current password"/>
			</div>
			<div class="ui-field-contain">
				<input type="password" name="password_new" id="password_new" maxlength="30" placeholder="New password"/>
			</div>
			<div class="ui-field-contain">
				<input type="password" name="password_new_repeat" id="password_new_repeat" maxlength="30" placeholder="Repeat new password"/>
			</div>
			<div class="ui-field-contain">
				<input data-theme="b" type="submit" name="change" id="change" value="Update password"/>
			</div>
		</form>
	</div>
</div>