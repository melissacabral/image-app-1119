<?php
// only parse the form if the user submitted the form
if( isset($_POST['did_login'])){

	//get the data that the user typed in and sanitize it
	$username = clean_string($_POST['username']);
	$password = clean_string($_POST['password']);

	$hashed_password = sha1( $password . constant('SALT') );

	//look for this combo in the database
	$sql = "SELECT * FROM users
			WHERE username = '$username'
			AND password = '$hashed_password'
			LIMIT 1";
	//run it
	$result = $db->query($sql);

	//check it
	if( ! $result ){
		echo $db->error;
	}

	//if one row found, success! set cookie, session and secret key. redirect to the next page
	if( $result->num_rows == 1  ){
		// success
		//generate a secret key
		$secret_key = sha1(microtime());

		//get the user_id out of the previous query result
		$row = $result->fetch_assoc();
		$user_id = $row['user_id'];

		//store it in the db
		$sql = "UPDATE users 
				SET secret_key = '$secret_key'
				WHERE user_id = $user_id";
		//run it
		$result = $db->query($sql);

		//check it
		if( ! $result ){
			echo $db->error;
		}

		if( $db->affected_rows == 1 ){
			//save it as a cookie and session
			$exp = time() + 60 * 60 * 24 * 30;
			setcookie( 'secret_key', $secret_key, $exp );
			setcookie( 'user_id', $user_id, $exp );

			$_SESSION['secret_key'] = $secret_key;
			$_SESSION['user_id'] = $user_id;

			//redirect TODO: uncomment this
			header('Location:index.php');
			
			$feedback = 'Success! You are now logged in';
		}else{
			//problem with db
			$feedback = 'Login Failed';
		}

	}else{
		//error
		$feedback = 'Your username/Password combo is incorrect. Try again :-)';
	}

}//end of if('did_login') statement