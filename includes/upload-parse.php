<?php 
if( $_POST['did_add_post'] ){
	//prepare to upload the file. 
	//Don't forget to make this directory in your siteroot
	$target_path = 'uploads/';

	$sizes = array(
		'thumb' 		=> '150',
		'large' 		=> '600',
		'xtra-large' 	=> '1080',
	);

	//grab the file that the user uploaded
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];

	//get the width and height of the original image
	list( $width, $height ) = getimagesize( $uploadedfile );

	//validate - does the image contain pixels?
	if( $width > 0 AND $height > 0 ){
		//what MIME type of file is it?
		$filetype = $_FILES['uploadedfile']['type'];

		switch( $filetype ){
			case 'image/gif':
			$src = imagecreatefromgif( $uploadedfile );
			break;

			case 'image/jpg':
			case 'image/jpeg':
			case 'image/pjpeg':
			$src = imagecreatefromjpeg( $uploadedfile );
			break;

			case 'image/png':
			$src = imagecreatefrompng( $uploadedfile );
			break;
		}

		//for the saved filename - a random string
		$generated_filename = sha1( microtime() );

		//resize the image for each image size
		foreach( $sizes as $size_name => $pixels ) {
			// square crop calculations (landscape or portrait?)
			if( $width > $height ){
				//landscape
				$crop_x = ($width - $height) / 2;
				$crop_y = 0;
				$crop_size = $height;
			}else{
				//portrait
				$crop_x = 0;
				$crop_y = ( $height - $width ) /2;
				$crop_size = $width;
			}

			//do the resampling!
			//make a new blank canvas at the desired size
			$tmp_canvas = imagecreatetruecolor( $pixels, $pixels );
			//resample the pixels from the original onto the canvas
			//dst_image, src_image, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h
			imagecopyresampled( $tmp_canvas, $src, 0, 0, $crop_x, $crop_y, $pixels, $pixels, 
				$crop_size, $crop_size );

			//save the image to the target directory
			//uploads/4376238538_thumb.jpg
			$filepath = $target_path . $generated_filename . '_' . $size_name . '.jpg';

			// save it as a jpg (70% quality)
			$did_save = imagejpeg( $tmp_canvas, $filepath, 70 );

		}//end foreach size


		if($did_save){
			//it worked, add the post to the database
			$user_id = $logged_in_user['user_id'];

			$sql = "INSERT INTO posts
					(image, date, user_id, is_published)
					VALUES
					('$generated_filename', now(), $user_id, 0)";

			$result = $db->query($sql);

			if(! $result){
				echo $db->error;
				$did_save = false;
			}

			if( $db->affected_rows == 1 ){
				//success! 
				//redirect to step 2
				$post_id = $db->insert_id;
				header( "Location:edit-post.php?post_id=$post_id" );

			}else{
				//db failed. show error
				$feedback = 'Error. Post not addded';
				$feedback_class = 'error';
			}

		}else{	
			$feedback = 'Error. File not saved';
			$feedback_class = 'error';
		}		

	}else{
		//no pixels
		$feedback = 'That is not a valid image.';
		$feedback_class = 'error';
	}//end if image contains pixels
}