<?php 
require('includes/header.php');

//lock this page down so only logged in users can access it
if(! $logged_in_user){
	die('You must be logged in to access this');
}

//get the post_id
//TODO: make sure the logged in user is the author of this post
$post_id = $_GET['post_id'];

//parse the form
require('includes/edit-parse.php');
?>
<main class="big-section">	
	<h1>Edit Post</h1>

	<img src="<?php image_url( $post_id, 'thumb' ); ?>">
	
	<?php feedback_display($feedback, $feedback_class, $errors); ?>

	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
		<div class="row">
			<div class="column column-75">
				<label for="the_title">Title</label>
				<input type="text" name="title" id="the_title" value="<?php echo $title; ?>">

				<label for="the_body">Body</label>
				<textarea name="body" id="the_body"><?php echo $body; ?></textarea>
			</div>
			
			<div class="column column-25">
				<label for="the_cat">Category</label>
				
				<select name="category_id" id="the_cat">
				<?php 
				$sql = "SELECT *
						FROM categories";
				$result = $db->query($sql);

				if($result->num_rows >= 1){
					while( $cat = $result->fetch_assoc() ){
				 ?>
					<option value="<?php echo $cat['category_id']; ?>" 
						<?php selected( $cat['category_id'], $category_id ); ?>>
						<?php echo $cat['name']; ?>
					</option>
				<?php 
					}//end while
				} //end if
				?>
				</select>

				<label>
					<input type="checkbox" name="allow_comments" value="1" 
						<?php checked(1, $allow_comments); ?>>
					Allow Comments
				</label>

				<input type="submit" value="Save Post">

				<input type="hidden" name="did_edit" value="1">
			</div>
		</div>
	</form>
</main>
<?php require('includes/footer.php'); ?>