<?php require('includes/header.php');

//search configuration
$per_page = 2;

//sanitize the phrase field
$phrase = clean_string( $_GET['phrase'] );

//parse the form if the phrase is not blank
if( $phrase != '' ){
	//get all the posts that contain the phrase
	$sql = "SELECT title, image, post_id, body
			FROM posts
			WHERE ( title LIKE '%$phrase%' 
				OR body LIKE '%$phrase%' )
				AND is_published = 1
			ORDER BY date DESC";
	//run it		
	$result = $db->query($sql);

	//check it
	if(! $result){
		echo $db->error;
	}
	//total number of posts found before adding pagination
	$total = $result->num_rows;

	//how many pages will it take to hold these results?
	$max_page = ceil($total / $per_page);

	//what page are we on?
	//query string will be like search.php?phrase=abc&page=2
	if(isset( $_GET['page'] ) AND $_GET['page'] <= $max_page ){
		$current_page = $_GET['page'];
	}else{
		$current_page = 1;
	}

	//update the query with a LIMIT
	//calculate the offset of this page
	$offset = ( $current_page - 1 ) * $per_page;
	$sql .= " LIMIT $offset, $per_page";

	$result = $db->query($sql);

}//end of search parser
 ?>
	<main class="wrapper">
		<section class="big-section">
			<h2>Search Results for <b><?php echo $_GET['phrase']; ?></b></h2>
			<h3><?php echo $total; ?> posts found.</h3>

			<?php if( $total >= 1 ){ ?>
			<h3> Showing page <?php echo $current_page; ?> of <?php echo $max_page; ?>.</h3>

			<div class="grid">

				<?php while( $post = $result->fetch_assoc() ){ ?>
				<div class="item">
					<a href="single.php?post_id=<?php echo $post['post_id']; ?>">
						<img src="<?php image_url( $post['post_id'] ); ?>" 
							alt="<?php echo $post['title']; ?>">
					</a>
						<h4><?php echo $post['title']; ?></h4>
						<p><?php echo $post['body']; ?></p>
					
				</div>
				<?php }//end while ?>

			</div>
			<?php }//end if total >= 1 ?>

			<div class="pagination">
				<?php 
				$next = $current_page + 1;
				$prev = $current_page - 1;
				
				//previous button
				if( $current_page != 1 ){
				?>
<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $prev; ?>" class="button">
					&larr; Previous Page
				</a>

			<?php } //end previous button 

				//numbered pagination
				for( $i = 1; $i <= $max_page; $i++ ){
					$url = "search.php?phrase=$phrase&amp;page=$i";
					echo "<a href='$url' class='button button-outline'>";
					echo $i;
					echo '</a> ';
				}
				//end numbered pagination


				//next button
				if( $current_page < $max_page ){
			?>
<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>" class="button">
					Next Page &rarr;
				</a>
			<?php } ?>
			</div>

		</section>
	</main>

<?php require('includes/footer.php'); ?>