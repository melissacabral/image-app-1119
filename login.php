<?php
//load database dependency and functions
require('config.php');
include_once('includes/functions.php');

require( 'includes/logout-parse.php' );
require( 'includes/login-parse.php' );
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login to Your account</title>
	<link rel="stylesheet" type="text/css" href="styles/milligram.css">
</head>
<body>
	<section class="narrow-section">
		<h1>Log In</h1>

		<!-- This will hide the feedback pink div  -->
		<?php feedback_display( $feedback, $feedback_class ); ?>

		<form method="post" action="login.php">

			<label for="the_username">Username</label>
			<input type="text" name="username" id="the_username"> 

			<label for="the_password">Password</label>
			<input type="password" name="password" id="the_password">

			<input type="submit" value="log In">

			<!-- This must be in form -->
			<input type="hidden" name="did_login" value="1">
			
		</form>

		<div class="cookiemessage">This site uses cookies<a href="tos.php">Read our terms and conditions</a></div>
	</section>
	<?php include('includes/debug-output.php'); ?>
</body>
</html>
