<?php 
//stand-alone register form
//it does NOT load header.php so we need to load all dependencies here:
require( 'config.php' ); 
include_once( 'includes/functions.php' );

require( 'includes/register-parse.php' );
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Create an Account</title>
	<link rel="stylesheet" type="text/css" href="styles/milligram.css">
</head>
<body>

	<section class="big-section">
		<h1>Create an Account</h1>
		<p>Become a member so you can upload posts, comment and like other posts</p>

		<?php feedback_display( $feedback, $feedback_class, $errors ); ?>

		<form action="register.php" method="post">
			<label for="the_username">Username</label>
			<input type="text" name="username" id="the_username">

			<label for="the_password">Password</label>
			<input type="password" name="password" id="the_password">

			<label for="the_email">Email Address</label>
			<input type="email" name="email" id="the_email">

			<label>
				<input type="checkbox" name="policy" value="1">
				I agree to the <a href="" target="_blank">Terms of Service and Cookie Policy</a>
			</label>

			<input type="submit" value="Sign Up">
			<input type="hidden" name="did_register" value="1">
			
		</form>
	</section>

<?php include('includes/debug-output.php'); ?>
</body>
</html>