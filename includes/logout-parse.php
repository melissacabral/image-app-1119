<?php 
// if they followed the logout link, destroy the session and cookie data
// URI will look like login.php?action=logout
if( $_GET['action'] == 'logout' ){
	//remove secret key from db
	$user_id = $_SESSION['user_id'];

	$sql = "UPDATE users
			SET secret_key = ''
			WHERE user_id = $user_id";
	//run it
	$result = $db->query($sql);

	// unset all cookies
	setcookie('secret_key', '', time() -9999 );
	setcookie('user_id', '', time() -9999 );

	// Unset all of the session variables.
	$_SESSION = array();

	// If it's desired to kill the session, also delete the session cookie.
	// Note: This will destroy the session, and not just the session data!
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}

	//unset all the sessions vars
	session_destroy();

	// redirect to a clean url with no query string
	header('location:login.php');

}//end if logout