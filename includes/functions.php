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



//Form Feedback Output HTML - Error or success
function feedback_display( $message, $class = 'error', $list = array() ){
	?>
	<div class="feedback <?php echo $class; ?>">
		<h2><?php echo $message; ?></h2>
		
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


//no close php