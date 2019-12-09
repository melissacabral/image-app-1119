<?php

//function that makes the date/time in a human-friendly format
function human_friendly_date( $date = 'today' ){
	$output = new DateTime( $date );
	echo $output->format('l, F j');
}

//Count the number of approved comments on any post
function count_comments( $post_id = 0 ){
	//get the DB connection from outside the function
	global $db;
	//sql
	$sql = "SELECT post_id, COUNT(*) AS total
			FROM comments
			WHERE post_id = $post_id
			AND is_approved = 1";
	//run it
	$result = $db->query($sql);
	//check it
	if( $result->num_rows >= 1 ){
		//loop it (output)
		while( $row = $result->fetch_assoc() ){
			$total = $row['total'];

			if( $total == 1 ){
				echo '1 Comment';
			}else{
				echo $total . ' Comments';
			}
			
		}
		//free it
		$result->free();
	}
	
}



//Helper functions for sanitizing all types of data

//remove SQL injection, HTML tags, script tags from strings
function clean_string( $dirty ){
	global $db;
	//remove HTML and scripts
	$dirty = filter_var( $dirty, FILTER_SANITIZE_STRING );
	//escape dangerous SQL
	return mysqli_real_escape_string( $db, $dirty );
}
//Clean a boolean var so it returns 1 or 0
function clean_boolean( $dirty ){
	if( $dirty == 1 ){
		return 1;
	}else{
		return 0;
	}
}
//clean integers
function clean_int( $dirty ){
	global $db;
	//remove HTML and scripts
	$dirty = filter_var( $dirty, FILTER_SANITIZE_NUMBER_INT );
	//escape dangerous SQL
	return mysqli_real_escape_string( $db, $dirty );
}
//clean email addresses
function clean_email( $dirty ){
	global $db;
	//remove HTML and scripts
	$dirty = filter_var( $dirty, FILTER_SANITIZE_EMAIL );
	//escape dangerous SQL
	return mysqli_real_escape_string( $db, $dirty );
}




//Form Feedback Output HTML - Error or success
function feedback_display( $message, $class = 'error', $list = array() ){
	if(isset($message)){
	?>
	<div class="feedback <?php echo $class; ?>">
		<h5><?php echo $message; ?></h5>
		
		<?php if( ! empty($list) ){ ?>
		<ul>
			<?php foreach( $list AS $item ){ ?>
			<li><?php echo $item; ?></li>
			<?php } //end foreach ?>
		</ul>
		<?php }//end if ?>

	</div>
	<?php
	}
}


//Check to see if the viewer is logged in. If so, get all the user info
function check_login(){
	global $db;
	if( isset($_SESSION['secret_key']) AND isset($_SESSION['user_id']) ){
		//check to see if these keys match the DB
		$secret_key = $_SESSION['secret_key'];
		$user_id = $_SESSION['user_id'];

		$sql = "SELECT * FROM users
				WHERE user_id = $user_id
				AND secret_key = '$secret_key'
				LIMIT 1";

		$result = $db->query($sql);
		if(! $result){
			return false;
		}
		if($result->num_rows == 1){
			//success! return all the info about the logged in user
			return $result->fetch_assoc();
		}else{
			return false;
		}
	}else{
		//not logged in
		return false;
	}
}


//no close php