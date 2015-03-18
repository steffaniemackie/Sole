<?php require_once('conn.php'); 




function move_image($files){
	
		$filename = $files['designer_image']['name'];
		$type = $files['designer_image']['type'];
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
		 	if($files['designer_image']['error'] > 0){
			
			return false;
			
		} else {
			$tmpname = $files['designer_image']['tmp_name'];
			$movie_picture = 'products/'.$filename;
			
		if(!file_exists('products/'.$filename)){
				move_uploaded_file($tmpname, 'products/'.$filename);
			
			} else {
				echo 'File Already Exists.';
			}
				
				return $designer_image;
		}
			

		else: 
			return false;
		endif;
		
		
		
}
if(isset($_POST['action'])){
	
	switch($_POST['action']){
		case 'Add Designer':
		///Handle File Upload 
		///echo '<pre>';
		///print_r($_FILES);
		///print_r($_POST);
		
		$designer_picture = move_image($_FILES);
		
		///exit ();
		
		
		// end handle file upload
		
		$designer_name	= addslashes(strip_tags($_POST['designer_name']));
		$designer_website	=  $_POST['designer_website'];
		
		$designer_description		= addslashes(strip_tags($_POST['designer_description']));
	
	
	
		$sql = 'INSERT INTO designer
							(designer_name, designer_website, designer_description, designer_image)
					VALUES ("'
					.$designer_name.'",
					"'.$designer_website.'",
					"'.$designer_description.'",
					"'.$designer_image.'")';
			
			
		if($result = mysqli_query($conn, $sql)){
			$message = 'Designer Successfully Added';
		}else{
			die('Error: '.mysqli_error($conn));	
		};	
		break; 
		
		
		//Editing Movie, Get Data
		case 'Edit':
		$sql = 'SELECT * FROM designer WHERE designer_id ='.$_POST['designer_id'];
		$result = mysqli_query($conn, $sql);
		$row2 = mysqli_fetch_array($result);
	
		break;
		
		//Update Movie in Database
		case 'Edit Designer':
			$designer_name	= addslashes(strip_tags($_POST['designer_name']));
			$designer_description = addslashes(strip_tags($_POST['designer_description']));
			$designer_website = addslashes(strip_tags($_POST['designer_website']));
			
			$sql = 'UPDATE designer
					SET designer_name = "'.$designer_name.'", 
						designer_description ="'.$designer_description.'"
						,designer_website = "'.$designer_website.'"
						';
						
						$designer_image = move_image($_FILES);
						$sql .= ($designer_image) ? 'designer_image = "'.$designer_image.'",' : '';
						
						
						$sql .= '
						
						
						WHERE designer_id = '.$_POST['designer_id']; 
			mysqli_query($conn, $sql);
				
			header('Location:designer.php?designer_id='.$_POST['designer_id']);	
		break;
		
		case 'Delete':
			$sql = 'SELECT * FROM designer WHERE designer_id ='.$_POST['designer_id'];
			$result = mysqli_query($conn, $sql);
			$row2 = mysqli_fetch_array($result);
		break; 
		
		case 'Delete Designer':
			$sql = 'DELETE FROM designer WHERE designer_id = '.$_POST['designer_id'].' LIMIT 1';
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

 <h1 role="welcome">Welcome back <?php echo $_SESSION['user_name']?></h1>
<h3 role="logout">logout</h3>

<article><form action= "add_designers.php" method="post" enctype="multipart/form-data">
<?php if($_POST['action'] == 'Edit' || $_POST['action'] != 'Delete') : 

switch($_POST['action']){
	case 'Edit':
		echo '<h1>Edit '.$row2['designer_name'].'</h1>';
	break;	
	
	case 'Delete':
		echo '<h1>Are you sure you want to delete '.$row2['designer_name'].'</h1>';
	break;	
	
	default:
		echo '<h1>Add New Designer</h1>';
	break;	
}
?>



	<p>
		<input type="text" name="designer_name" placeholder="Designer Name" value="<?php echo $row2['designer_name'] ?>">
	</p>

 	<p>
		<input type="file" name="designer_image" placeholder="Picture" value="<?php echo $row2['designer_image'] ?>">
	</p>

	<p>
		<input type="text" name="designer_website" placeholder="Designer Website" value="<?php echo $row2['designer_website'] ?>">
	</p>
 <p>
		<textarea name="designer_description" placeholder="Description"> <?php echo $row2['designer_description'] ?></textarea>
	</p>

    
<p>
<?php 
if(isset($row2['designer_id'])) {
	echo '<input type="hidden" name="designer_id" value="'.$row2['designer_id'].'">';
	echo '<input type="submit" name="action" value="Edit Designer">';
} else {
	?>
		<input type="submit" name="action" value="Add Designer">
	<?php } ?>


<?php elseif($_POST['action'] == 'Delete'): ?>

	<h1>Are you sure you want to delete <?php echo $row2['designer_name'] ?> </h1>
    <input type="submit" name="action" value="Delete Designer" id= "button">
     <input type="submit" name="action" value="Cancel" id= "button">
      <input type="hidden" name="designer_id" value="<?php echo $row2['designer_id'] ?>">

<?php endif; ?>

</p>
    
</form></article>



</body>
</html>