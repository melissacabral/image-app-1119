<?php require('includes/header.php');

//get the post_id out of the URL
//single.php?post_id=X
$post_id = $_GET['post_id'];


//parse the form if the user clicked submit
if( $_POST['did_comment'] ){
	//sanitize everything
	$body = clean_string( $_POST['body'] );
	//TODO: change to the session (logged in user)
	$user_id = $_POST['user_id'];

	//validate
	$valid = 1;

	if( strlen($body) < 2 OR strlen($body) > 255 ){
		$valid = 0;
		$errors['body'] = 'Your comment must be between 2 - 255 characters long.';
	}

	//if valid, add the comment to the DB
	if( $valid ){
		$sql = "INSERT INTO comments
		(body, date, user_id, post_id, is_approved)
		VALUES 
		('$body', now(), $user_id, $post_id, 1)";
		//run it
		$result = $db->query($sql);
		//check it (twice)
		if( ! $result ){
			echo $db->error;
		}
		if( $db->affected_rows == 1 ){
			//it worked
			$feedback = 'Thank you for your comment';
			$feedback_class = 'success';
		}else{
			//db didnt work
			$feedback = 'There was a problem saving your comment. Try again Later.';
			$feedback_class = 'error';
		}
	}else{
		//error
		$feedback = 'Your comment is invalid. Fix the following issues:';
		$feedback_class = 'error';
	}

}//end comment form parser
?>

<main class="wrapper">
	<div class="row">
		<section class="column">

				<?php //get the one post we are trying to view
				$sql = "SELECT posts.post_id, posts.title, posts.body, posts.date, posts.image, categories.*, users.username
				FROM posts, categories, users
				WHERE posts.category_id = categories.category_id
				AND posts.user_id = users.user_id
				AND posts.is_published = 1
				AND posts.post_id = $post_id
				LIMIT 1"; 
				//run it
				$result = $db->query( $sql );

				//check it (are there any rows in the result)
				if( $result->num_rows >= 1 ){
					?>
					<div class="">

						<?php 
					//loop it
						while( $post = $result->fetch_assoc() ){ 
							?>

							<div class="post">
								<!-- <pre><?php print_r($post); ?></pre> -->

								<img src="<?php echo $post['image']; ?>" 
								alt="<?php echo $post['title']; ?>" class="post-image">
								<h3><?php echo $post['title']; ?></h3>
								<h4><?php echo $post['username']; ?></h4>
								<h5><?php count_comments( $post['post_id'] ); ?></h5>

								<p><?php echo $post['body']; ?></p>

								<span class="date"><?php human_friendly_date($post['date']); ?></span>

								<span class="category"><?php echo $post['name'] ?></span>					
							</div>
					<?php } //end while there are posts 
					//free it
					$result->free();
					?>

				</div>

				<?php 
			}else{
					//no rows found in the result
				echo 'Sorry, no recent posts.';
			} //end if rows are found ?>

		</section>

		<section class="column" id="leave-comment">


			<?php 
			//get all the approved comments on THIS post
			$sql = "SELECT users.username, users.user_id, comments.body, comments.date
					FROM comments, users
					WHERE comments.user_id = users.user_id
						AND comments.is_approved = 1
						AND comments.post_id = $post_id
					ORDER BY comments.date DESC
					LIMIT 10";
			//run it
			$result = $db->query($sql);
			//check it (twice)
			if( ! $result ){
				echo $db->error;
			}
			if( $result->num_rows >= 1 ){
			?>
			<div class="comments">
				<h3>Comments:</h3>
				
				<?php //loop it
				while( $comment = $result->fetch_assoc() ){ ?>
				<div class="one-comment">
					<h4><?php echo $comment['username']; ?></h4>
					<p><?php echo $comment['body']; ?></p>
					<span class="date">
						<?php human_friendly_date($comment['date']); ?>	
					</span>
					<hr>
				</div>
				<?php } //end while ?>

			</div>
			<?php } //end if num_rows ?>



			<?php 
			if( isset( $feedback ) )
				feedback_display( $feedback, $feedback_class, $errors ); 
			?>

			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>#leave-comment" method="post">
				<label for="the_comment">Your Comment:</label>
				<textarea name="body" id="the_comment"></textarea>

				<input type="submit" value="Comment">

				<input type="hidden" name="did_comment" value="1">

				<?php //TODO: remove this so it works with the login system ?>
				<input type="hidden" name="user_id" value="2">
			</form>
		</section>

	</div>


</main>
<?php require('includes/footer.php'); ?>