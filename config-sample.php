<?php
//create database variables
$database_name 		= 'melissa_image_app_1119';
$database_user 		= 'mmc_imageapp1119';
$database_password 	= 'BqCxQ0TcSF2t5JDh';
$database_host 		= 'localhost';

//Debug mode on or off
//true: show all errors and superglobal output
//false: live site mode
define( 'DEBUG_MODE', true );

//SALT for password and cookie security
define( 'SALT', '895srthh%^$VHNH21%$NBnwerklj558!)&#^#85SDG@&*56VS' );


//==============STOP EDITING===========

//error reporting
if( DEBUG_MODE ){
	// error_reporting( E_ALL );
	// show all EXCEPT notices
	error_reporting( E_ALL & ~E_NOTICE );
}else{
	//hide all errors
	error_reporting(0);
	ini_set('display_errors', 0);
}


//connect to the database
$db = new mysqli( $database_host, $database_user, $database_password, $database_name );

//handle database error
if( $db->connect_errno > 0 ){
	die('Failed to connect to database');
}






//no close php