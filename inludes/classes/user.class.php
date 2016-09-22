<?php

/*
* User Class used for Login System
* Made by Bastiaan Smit
*/

class User {
	
	private $_db;
	
	public function __construct()
    {    	
		$this->_db = new mysqli(Config::$config_db_host, Config::$config_db_user, Config::$config_db_pass, Config::$config_db_name);
		
		if($this->_db->connect_error)
		{
			if (Config::$config_debug)
			{
				echo "Error: ".$this->_db->connect_error;
				exit;
			}
			else
				exit;
		}
    }
    
    // Registration
	public function register($fname, $lname, $umail, $upass, $upass_repeat)
	{
		// Default return
		$return = "Information incorrect!";
		
		// Prevent sql injection
		$fname = mysqli_real_escape_string($this->_db,$fname);
		$lname = mysqli_real_escape_string($this->_db,$lname);
		$umail = mysqli_real_escape_string($this->_db,$umail);
		$upass = mysqli_real_escape_string($this->_db,$upass);
		$upass_repeat = mysqli_real_escape_string($this->_db,$upass);
		
		// Create pasword hash
		$password = password_hash($upass, PASSWORD_DEFAULT);
		
		// Set options
		$options = array
		(
			'mail' => $umail,
			'template' => "register",
			'fname' => $fname,
			'lname' => $lname,			
			'token' => $this->generateRandomString(10)
		);
		
		// Check if first name is valid
		if (empty($fname) || strlen($fname) > 50)
		{			
			$return = "First name not filled in!";
		}
		// Check if last name is valid
		elseif (empty($lname) || strlen($lname) > 50)
		{			
			$return = "Last name not filled in!";
		}
		// Check if passwords are valid with complex enabled
		elseif ((strlen($upass) < 8 || strlen($upass) > 30 || $upass != $upass_repeat) && Config::$config_password_complex && !preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/",$upass))
		{			
			$return = "Passwords do not match or are not complex enough!<br/>At least ".Config::$config_password_length." characters including 1 uppercase and 1 lowercase letter.";
		}
		// Check if passwords are valid with complex disabled
		elseif (strlen($upass) < 8 || strlen($upass) > 30 || $upass != $upass_repeat)
		{
			$return = "Passwords do not match or are too short!<br/>Your password must be at least ".Config::$config_password_length." characters long.";
		}
		// All inputs are valid
		else
		{
			// Select user by email
			$query = "SELECT * FROM users WHERE email='$umail'";
			$result = $this->_db->query($query);
			
			// If not already registered
			if ($result->num_rows == 0)
			{
				// Create user
				$query = "INSERT INTO users VALUES ('', '$fname', '$lname', '$umail', '$password', '0', '".$options['token']."')";
				$execute = $this->_db->query($query);
				
				// If user created
				if ($this->_db->affected_rows > 0)
				{
					// Success, send activation mail to user
					Mail::send($options);
				    $return = "Check your inbox for the activation link!";
				}
			}	
		}
		
		return $return;
	}

	// Registration activation - Activate account with the link received by email
	public function register_activate($umail, $utoken)
	{
		// Default return
		$return = "Activation link not valid!";
		
		// Prevent sql injection
		$umail = mysqli_real_escape_string($this->_db,$umail);
		$utoken = mysqli_real_escape_string($this->_db,$utoken);
		
		// If token not empty
		if (!empty($utoken))
		{
			// Update user, set user active if token and email are valid
			$query = "UPDATE users SET active='1', token='' WHERE email='$umail' AND token='$utoken'";
			$execute = $this->_db->query($query);

			// If query success
			if ($this->_db->affected_rows > 0)
			    $return = "Account successfully activated!<br/>You can now login with your credentials.";
		}
		
		return $return;
	}
		
	// Login
	public function login($umail, $upass)
	{
		// Default return
		$return = "Invalid credentials!";
		
		// Prevent sql injection
		$umail = mysqli_real_escape_string($this->_db,$umail);
		$upass = mysqli_real_escape_string($this->_db,$upass);
		
		// Select user by email
		$query = "SELECT * FROM users WHERE email='$umail'";
		$result = $this->_db->query($query);

		// If email found
		if ($result->num_rows > 0)
		{
			// Get user data
			while($row = $result->fetch_assoc()) 
			{
				// Check if password is valid
				if (password_verify($upass, $row['password']))
				{
					// Login success, redirect
					$_SESSION['user_session'] = $umail;
					$this->redirect('?login');
					$return = "";
				}
		    }
		}
		
		return $return;
	}
	
	// Change password
	public function change_password($umail, $upass_old, $upass_new, $upass_new_repeat)
	{
		// Default return
		$return = "Invalid credentials!";
		
		// Prevent sql injection
		$umail = mysqli_real_escape_string($this->_db,$umail);
		$upass_old = mysqli_real_escape_string($this->_db,$upass_old);
		$upass_new = mysqli_real_escape_string($this->_db,$upass_new);
		$upass_new_repeat = mysqli_real_escape_string($this->_db,$upass_new_repeat);
		
		// Create password hash
		$password = password_hash($upass_new, PASSWORD_DEFAULT);
		
		// Check if email is valid
		if (empty($umail) || strlen($umail) > 100)
		{			
			$return = "Email address not filled in!";
		}
		// Check if passwords are valid with complex enabled
		elseif ((strlen($upass_new) < 8 || strlen($upass_new) > 30 || $upass_new !== $upass_new_repeat) && Config::$config_password_complex && !preg_match("/(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])/",$upass_new))
		{			
			$return = "Passwords do not match or are not complex enough!<br/>At least ".Config::$config_password_length." characters including 1 uppercase and 1 lowercase letter.";
		}
		// Check if passwords are valid with complex disabled
		elseif (strlen($upass_new) < 8 || strlen($upass_new) > 30 )
		{
			$return = "Passwords do not match or are too short!<br/>Your password must be at least ".Config::$config_password_length." characters long.";
		}
		// All inputs are valid
		else
		{
			// Select user by email
			$query = "SELECT * FROM users WHERE email='$umail'";
			$result = $this->_db->query($query);

			// User found
			if ($result->num_rows > 0)
			{
				// Get user data
				while($row = $result->fetch_assoc()) 
				{
					// Check if password is valid
					if (password_verify($upass_old, $row['password']))
					{
						// Update user, set new password
						$query = "UPDATE users SET password='$password' WHERE id='".$row['id']."'";
						$execute = $this->_db->query($query);
			
						// If query success
						if ($this->_db->affected_rows > 0)
						    $return = "Password successfully changed!<br/>You can now login with your new password.";
					}
			    }
			}
		}
		
		return $return;
	}
		
	// Forgot password - Send reset email with link
	public function forgot_password($umail)
	{
		// Default return
		$return = "No account found with the entered email!";
		
		// Prevent sql injection
		$umail = mysqli_real_escape_string($this->_db,$umail);
		
		// Set extra options
		$options = array
		(
			'mail' => $umail,
			'template' => "forgot",
			'token' => $this->generateRandomString(10)
		);
		
		// Check if email is valid
		if (empty($umail) || strlen($umail) > 50)
		{			
			$return = "Email address not filled in!";
		}
		// All inputs are valid
		else
		{
			// Update user, set token
			$query = "UPDATE users SET token='".$options['token']."' WHERE email='".$options['mail']."'";
			$execute = $this->_db->query($query);
			
			// If query success
			if ($this->_db->affected_rows > 0)
			{
				// Send mail
				Mail::send($options);
				$return = "A reset email has been sent!";
			}
		}
		
		return $return;
	}

	// Forgot password reset - Reset password with the link received by email
	public function forgot_password_reset($umail, $utoken, $upass, $upass_repeat)
	{
		// Default return
		$return = "Security token not valid!<br/>Please try again by sending a new reset email.";
		
		// Prevent sql injection
		$umail = mysqli_real_escape_string($this->_db,$umail);
		$utoken = mysqli_real_escape_string($this->_db,$utoken);
		$upass = mysqli_real_escape_string($this->_db,$upass);
		$upass_repeat = mysqli_real_escape_string($this->_db,$upass_repeat);
		
		// Create password hash
		$password = password_hash($upass, PASSWORD_DEFAULT);
		
		// Check if token filled in
		if (!empty($utoken))
		{
			// Update user, set new password if email and token are valid
			$query = "UPDATE users SET password='$password', token='' WHERE email='$umail' AND token='$utoken'";
			$execute = $this->_db->query($query);

			// If query success
			if ($this->_db->affected_rows > 0)
			    $return = "Password successfully changed!<br/>You can now login with your new password.";
		}
		
		return $return;
	}

	// Get user details
	public function details($umail)
	{
		// Default return
		$return = false;
		
		// Select user
		$query = "SELECT * FROM users WHERE email='$umail'";
		$result = $this->_db->query($query);
		
		// If user found
		if ($result->num_rows > 0)
		{
			// Get user data
			while($row = $result->fetch_assoc()) 
			{
				$return['fname'] = $row['firstname'];
				$return['lname'] = $row['lastname'];
				$return['active'] = $row['active'];
			}
		}
		
		return $return;
	}

	// Logged in status
	public function is_loggedin()
	{
		// Default return
		$return = false;
		
		// Check if session found
		if(isset($_SESSION['user_session']))
		{
			$return = true;
		}
		
		return $return;
	}
	
	// Refirect
	public function redirect($url)
	{
		// Redirect to url
		header("Location: $url");
	}

	// Logout
	public function logout()
	{
		// Remove session and redirect to login
		unset($_SESSION['user_session']);
		header("Location: ?login");
		return true;
	}
     
	// Generate random string
	public function generateRandomString($length = 10) {
		// Available characters
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    // Get characters length
	    $charactersLength = strlen($characters);
	    // Store random string
	    $randomString = '';
	    // Loop
	    for ($i = 0; $i < $length; $i++) {
	    	// Add new random character to string
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
    return $randomString;
}

}