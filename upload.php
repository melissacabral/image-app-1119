<?php 
require('includes/header.php');

//lock this page down so only logged in users can access it
if(! $logged_in_user){
	die('You must be logged in to access this');
}

//parse the form
require('includes/upload-parse.php');
?>
<main class="narrow-section">	
	<h1>New Post</h1>
	
	<?php feedback_display($feedback, $feedback_class); ?>

	<form action="upload.php" method="post" enctype="multipart/form-data">
		<label for="the_image">Image:</label>
		<input type="file" name="uploadedfile" id="the_image" required accept="image/*">

		<hr>

		<input type="submit" value="Next Step: Edit Details &rarr;">
		<input type="hidden" name="did_add_post" value="1">
	</form>
</main>
<?php require('includes/footer.php'); ?>