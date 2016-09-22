<?php

if(!$user->is_loggedin())
	$user->redirect('?login');

?>
<div class="ui-body ui-body-a ui-corner-all login-body">
	<div class="login_head"><img src="images/login_success.png" width="168" height="168" /></div>
    <div>
    	<div class="ui-field-contain">
			<h2>Welcome, <?php echo $user->details($_SESSION['user_session'])['fname']; ?></h2>
		</div>
		<div class="ui-field-contain">
			<form data-ajax="false" action="?logout" method="POST">
				<input data-theme="b" type="submit" name="logout" id="logout" value="Logout"/>
			</form>
		</div>
	</div>
</div>