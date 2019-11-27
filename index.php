<?php require('includes/header.php'); ?>

	<main class="wrapper">

		<section class="hero">
			<div class="container">

				<?php //get all the categories in alpha order
				$sql = "SELECT *
						FROM categories
						ORDER BY RAND()
						LIMIT 6";
				//run it
				$result = $db->query( $sql );
				//check it
				if( $result->num_rows >= 1 ){ 
				?>
					<h1>Browse Images by Category</h1>

					<?php while( $row = $result->fetch_assoc() ){ ?>
						<a class="button" href="#">
							<?php echo $row['name']; ?>
						</a>
					<?php } //end while
					//free it
					$result->free();
					?>

				<?php 
				}else{
					echo '<h1>Share images with the community!</h1>';
					echo '<a class="button" href="#">Sign Up</a>';
				} ?>

			</div>
		</section>

		<section class="container big-section">
			
			<?php //get the latest 4 published posts
			$sql = "SELECT posts.post_id, posts.title, posts.body, posts.date, posts.image, categories.*, users.username
				FROM posts, categories, users
				WHERE posts.category_id = categories.category_id
					AND posts.user_id = users.user_id
					AND posts.is_published = 1
				ORDER BY posts.date desc
				LIMIT 5"; 
			//run it
			$result = $db->query( $sql );

			//check it (are there any rows in the result)
			if( $result->num_rows >= 1 ){
			?>
			<h2>Latest posts from the community</h2>

			<div class="grid">
				
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

		<?php //get up to 10 most recently joined users
		$sql = "SELECT username, profile_pic
				FROM users 
				ORDER BY join_date DESC
				LIMIT 10";

		//run it
		$result = $db->query($sql);
		//check if the result has at least 1 row
		if( $result->num_rows >= 1 ){
		?>
		<section class="container big-section">
			<h2>Newest Users:</h2>
			<div class="row">
				<?php //loop it
				while( $row = $result->fetch_assoc() ){ ?>
				<div>
					<img src="https://<?php echo $row['profile_pic'] ?>" 
					alt="<?php echo $row['username']; ?>">
				</div>		
				<?php }//end while 
				//free it
				$result->free(); ?>		
			</div>
		</section>
		<?php } //end if no users found ?>


	</main>
<?php require('includes/footer.php'); ?>