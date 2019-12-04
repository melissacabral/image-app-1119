<?php 
require('config.php'); 
include_once('includes/functions.php');
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
				<li><a href="register.php" class="button button-clear">Sign Up</a></li>
				<li><a href="login.php" class="button button-clear">Log In</a></li>
			</ul>

		</nav>
	</header>