<?php 
//parse the register form if it was submitted
if( $_POST['did_register'] ){
	//clean everything
	$username 	= clean_string( $_POST['username'] );
	$password 	= clean_string( $_POST['password'] );
	$email 		= clean_email( $_POST['email'] );
	$policy 	= clean_boolean( $_POST['policy'] );

	//validate
	$valid = 1;

	//username wrong length
	if( strlen($username) < 4 OR strlen($username) > 40 ){
		$valid = 0;
		$errors['username'] = 'Create a username between 4 - 40 characters long.';
	}else{
		//check for duplicate username in the DB
		$sql = "SELECT username 
				FROM users
				WHERE username = '$username'
				LIMIT 1";
		$result = $db->query($sql);
		//if one row found, this username is taken!
		if( $result->num_rows >= 1 ){
			$valid = 0;
			$errors['username'] = 'Sorry, that username is taken. Try another.';
		}
	}//end username checks 

	//password too short
	if( strlen($password) < 7 ){
		$valid = 0;
		$errors['password'] = 'Your password must be at least 7 characters long.';
	}

	//email invalid format
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = 0;
		$errors['email'] = 'Please provide a valid email address.';
	}else{
		//check if email is already in use
		$sql = "SELECT email 
				FROM users
				WHERE email = '$email'
				LIMIT 1";
		$result = $db->query($sql);
		if( $result->num_rows >= 1 ){
			$valid = 0;
			$errors['email'] = 'That email address is already registered. Try logging in.';
		}
	}//end email checks

	//policy box not checked
	if( $policy != 1 ){
		$valid = 0;
		$errors['policy'] = 'You must agree to the terms of service.';
	}	

	//if valid, add the user to the db and redirect them to the right place
	if( $valid ){
		//salt and hash the password for storage
		$password = sha1( $password . constant('SALT')  );
		//add them to the DB
		$sql = "INSERT INTO users
				( username, email, password, join_date, is_admin )
				VALUES 
				( '$username', '$email', '$password', now(), 0 )";
		$result = $db->query($sql);
		if( $db->affected_rows == 1 ){
			//success
			$feedback = 'You are now signed up! You can log in to your account.';
			$feedback_class = 'success';
		}else{
			// db error
			$feedback = 'Something went wrong during account creation. Try again.';
			$feedback_class = 'error';
		}
	}else{
		//error - not valid
		$feedback = 'Please correct the following issues:';
		$feedback_class = 'error';
	}

}
//no close php