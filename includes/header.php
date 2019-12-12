<?php 
require('config.php'); 
include_once('includes/functions.php');

//check if the viewer is logged in
$logged_in_user = check_login();
?>
<!DOCTYPE html>
<html lang="en-us">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Image sharing App</title>
	<link rel="stylesheet" type="text/css" href="styles/milligram.css">
</head>
<body>
	<header>
		<nav class="main-menu">
			<h1 class="logo"><a href="index.php">Image App Name</a></h1>

			<form method="get" action="search.php" class="search">
				<input type="search" name="phrase" placeholder="Search" 
					value="<?php echo $_GET['phrase']; ?>">
				<input type="submit" value="go" class="button button-outline">
			</form>

			<ul class="menu-links">
				<?php //logged in menu 
				if( $logged_in_user ){?>

					<li><a href="upload.php" class="button button-clear">Upload</a></li>
					<li><a href="#" class="button button-clear">
						<?php echo $logged_in_user['username']; ?>
					</a></li>
					<li><a href="login.php?action=logout" class="button button-clear">Log Out</a></li>

				<?php }else{ //not logged in menu ?>

					<li><a href="register.php" class="button button-clear">Sign Up</a></li>
					<li><a href="login.php" class="button button-clear">Log In</a></li>

				<?php } ?>


			</ul>

		</nav>
	</header>