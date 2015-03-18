<?php require_once('conn.php'); 

function move_image($files){
	
		$filename = $files['movie_picture']['name'];
		$type = $files['movie_picture']['type'];
		$allowedExts = array('gif', 'jpeg', 'jpg', 'png');
		$temp = explode('.', $filename);
		$extension = end($temp);
		
		/////To ensure that just picture files are accepted and size limits 
		if(	(($type == 'image/gif')  ||
		 	($type == 'image/jpg') ||
			 ($type == 'image/jpeg') ||
			 ($type == 'image/png') ||
			 ($type == 'image/x-png') ||
			 ($type == 'image/pjpeg')) &&
			 ($files['movie_picture']['size'] < 15000000) && 
			 (in_array($extention, $allowedExts)) ):	
		 	if($files['movie_picture']['error'] > 0){
			
			return false;
			
		} else {
			$tmpname = $files['movie_picture']['tmp_name'];
			$movie_picture = 'uploads/'.$filename;
			
		if(!file_exists('uploads/'.$filename)){
				move_uploaded_file($tmpname, 'uploads/'.$filename);
			
			} else {
				echo 'File Already Exists.';
			}
				
				return $movie_picture;
		}
			

		else: 
			return false;
		endif;
		
		
		
}
if(isset($_POST['action'])){
	
	switch($_POST['action']){
		case 'Add Movie':
		///Handle File Upload 
		///echo '<pre>';
		///print_r($_FILES);
		///print_r($_POST);
		
		$movie_picture = move_image($_FILES);
		
		///exit ();
		
		
		// end handle file upload
		
		
		
		
		
		
		$movie_title	= addslashes(strip_tags($_POST['movie_title']));
		$movie_year		= is_numeric($_POST['movie_year'])?$_POST['movie_year']:0;
		$movie_duration	= is_numeric($_POST['movie_duration'])?
						gmdate('H:i:s', $_POST['movie_duration'] * 60) 
						:$_POST['movie_duration'];
		$movie_release	= date ('Y-m-d', strtotime($_POST['movie_release']));
		$movie_plot		= addslashes(strip_tags($_POST['movie_plot']));
		$movie_genre_id = $_POST['movie_genre_id'];
		$movie_rating_id = $_POST['movie_rating_id'];
		$sql = 'INSERT INTO movies
							(movie_title, movie_year, movie_duration, 
							movie_release, movie_plot, movie_genre_id, movie_rating_id, movie_picture)
					VALUES ("'.$movie_title.'",'.$movie_year.',"'.$movie_duration.'",
					"'.$movie_release.'","'.$movie_plot.'",'.$movie_genre_id.','.$movie_rating_id.', "'.$movie_picture.'")';
			
			
		if($result = mysqli_query($conn, $sql)){
			$message = 'Movie Successfully Added';
		}else{
			die('Error: '.mysqli_error($conn));	
		};	
		break; 
		
		
		//Editing Movie, Get Data
		case 'Edit':
		$sql = 'SELECT * FROM movies WHERE movie_id ='.$_POST['movie_id'];
		$result = mysqli_query($conn, $sql);
		$row2 = mysqli_fetch_array($result);
	
		break;
		
		//Update Movie in Database
		case 'Edit Movie':
			$movie_title	= addslashes(strip_tags($_POST['movie_title']));
			$movie_year		= is_numeric($_POST['movie_year'])?$_POST['movie_year']:0;
			$movie_duration	= is_numeric($_POST['movie_duration'])?
							gmdate('H:i:s', $_POST['movie_duration'] * 60) 
							:$_POST['movie_duration'];
			$movie_release	= date ('Y-m-d', strtotime($_POST['movie_release']));
			$movie_plot		= addslashes(strip_tags($_POST['movie_plot']));
			$movie_genre_id = $_POST['movie_genre_id'];
			$movie_rating_id = $_POST['movie_rating_id'];
		
			
		
		
			$sql = 'UPDATE movies
					SET movie_title = "'.$movie_title.'", 
						movie_year = '.$movie_year.',
						movie_duration ="'.$movie_duration.'",
						movie_release = "'.$movie_release.'",
						movie_plot = "'.$movie_plot.'",
						movie_genre_id = '.$movie_genre_id.', 
						';
						
						$movie_picture = move_image($_FILES);
						$sql .= ($movie_picture) ? 'movie_picture = "'.$movie_picture.'",' : '';
						
						$sql .= 'movie_rating_id = '.$movie_rating_id.'
						WHERE movie_id = '.$_POST['movie_id']; 
			mysqli_query($conn, $sql);
				
			header('Location:movie.php?movie_id='.$_POST['movie_id']);	
		break;
		
		case 'Delete':
			$sql = 'SELECT * FROM movies WHERE movie_id ='.$_POST['movie_id'];
			$result = mysqli_query($conn, $sql);
			$row2 = mysqli_fetch_array($result);
		break; 
		
		case 'Delete Movie':
			$sql = 'DELETE FROM movies WHERE movie_id = '.$_POST['movie_id'].' LIMIT 1';
			mysqli_query($conn, $sql);
		break;
		
	}
	
}

include_once('header.php');

?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php if(isset($message)) echo $message; ?>

<article><form action= "add_movie.php" method="post" enctype="multipart/form-data">
<?php if($_POST['action'] == 'Edit' || $_POST['action'] != 'Delete') : 

switch($_POST['action']){
	case 'Edit':
		echo '<h1>Edit '.$row2['movie_title'].'</h1>';
	break;	
	
	case 'Delete':
		echo '<h1>Are you sure you want to delete '.$row2['movie_title'].'</h1>';
	break;	
	
	default:
		echo '<h1>Add New Movie</h1>';
	break;	
}
?>



	<p>
		<input type="text" name="movie_title" placeholder="Movie Title" value="<?php echo $row2['movie_title'] ?>">
	</p>

	<p>
		<input type="text" name="movie_year" placeholder="Movie Year" value="<?php echo $row2['movie_year'] ?>">
	</p>
    
    <p>
		<input type="text" name="movie_duration" placeholder="Duration" value="<?php echo $row2['movie_duration'] ?>">
	</p>
    <p>
		<input type="file" name="movie_picture" placeholder="Picture" value="<?php echo $row2['movie_picture'] ?>">
	</p>
    <p>
		<input type="date" name="movie_release" placeholder="Release Data" value="<?php echo $row2['movie_release'] ?>">
	</p>
      <p>
		<textarea name="movie_plot" placeholder="Plot"> "<?php echo $row2['movie_plot'] ?>"</textarea>
	</p>
    
   		Genre:
        <select name="movie_genre_id">
        	<?php 
			$sql = 'SELECT * FROM genre';
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_array($result)){
			?>
		
        		<option <?php if($row2['movie_genre_id'] == $row['genre_id']){echo 'selected';} ?> value="<?php echo $row['genre_id']?>"><?php echo $row['genre_title']?></option>
            
            <?php }?>
        </select>
   
    <p>
    	<select name="movie_rating_id">
        	<?php 
			$sql = 'SELECT * FROM rating';
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_array($result)){
				
			?>
            
        
      		 <option <?php if($row2['movie_rating_id'] == $row['rating_id']){echo 'selected';} ?>  value="<?php echo $row['rating_id']?>"><?php echo $row ['rating_num']?></option>
             
             <?php }?>
       </select>
    </p>
    
<p>
<?php 
if(isset($row2['movie_id'])) {
	echo '<input type="hidden" name="movie_id" value="'.$row2['movie_id'].'">';
	echo '<input type="submit" name="action" value="Edit Movie">';
} else {
	?>
		<input type="submit" name="action" value="Add Movie">
	<?php } ?>


<?php elseif($_POST['action'] == 'Delete'): ?>

	<h1>Are you sure you want to delete <?php echo $row2['movie_title'] ?> </h1>
    <input type="submit" name="action" value="Delete Movie">
     <input type="submit" name="action" value="Cancel">
      <input type="hidden" name="movie_id" value="<?php echo $row2['movie_id'] ?>">

<?php endif; ?>

</p>
    
</form></article>



</body>
</html>