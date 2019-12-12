<?php
$user_id = $logged_in_user['user_id'];
//pre-fill this form with the current DB values
$sql = "SELECT * 
		FROM posts 
		WHERE post_id = $post_id
		AND user_id = $user_id
		LIMIT 1";
$result = $db->query($sql);

if(! $result){
	echo $db->error;
	die('You are not the author of this post.');
}
if($result->num_rows == 0){
	die('You are not the author of this post.');
}

$post = $result->fetch_assoc();

//create the variables for the sticky fields
$title 			= $post['title'];
$body 			= $post['body'];
$category_id 	= $post['category_id'];
$allow_comments = $post['allow_comments'];


if( $_POST['did_edit'] ){
	//sanitize everything
	$title 			= clean_string($_POST['title']);
	$body 			= clean_string($_POST['body']);
	$category_id 	= clean_int($_POST['category_id']);
	$allow_comments = clean_boolean($_POST['allow_comments']);
	//validate
	$valid = 1;
		//title  blank or more than 50 chars
	if( strlen($title) == 0 OR strlen($title) > 50 ){
		$valid = 0;
		$errors[] = 'Add a title that is less than 50 characters long.';
	}
		//body more than 1000 chars
	if( strlen($body) > 1000 ){
		$valid = 0;
		$errors[] = 'Body cannot be more than 1000 characters long.';
	}	
		//category not a number
	if( ! is_numeric($category_id) ){
		$valid = 0;
		$errors[] = 'Invalid Category';
	}
	
	//if valid, update the post in the database
	if( $valid ){

		$sql = "UPDATE posts
		SET
		title = '$title',
		body = '$body',
		category_id = $category_id,
		allow_comments = $allow_comments,
		is_published = 1
		WHERE post_id = $post_id 
		AND user_id = $user_id
		LIMIT 1";
		$result = $db->query($sql);
		if(! $result){
			echo $db->error;
		}
		if( $db->affected_rows == 1 ){
			//success
			$feedback = 'Post successfully saved.';
			$feedback_class = 'success';
		}else{
			//error - FYI update will affect 0 rows if the data stays the same 
			$feedback = 'No changes made';
			$feedback_class = 'neutral';
		}
		//show feedback
	}else{
		$feedback = 'There were problems with your post. Fix the following:';
		$feedback_class = 'error';
	}//end if valid

}//end if did edit