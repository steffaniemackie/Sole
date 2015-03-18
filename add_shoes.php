<?php include_once('conn.php'); 

function move_image($files){
		$filename = $files['shoes_image']['name'];
		$type = $files['shoes_image']['type'];
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
			 ($files['shoes_image']['size'] < 15000000) && 
			 (in_array($extention, $allowedExts)) ):	
		 	if($files['shoes_image']['error'] > 0){
			
			return false;
			
		} else {
			$tmpname = $files['shoes_image']['tmp_name'];
			$shoes_image = 'product/'.$filename;
			
		if(!file_exists('product/'.$filename)){
				move_uploaded_file($tmpname, 'product/'.$filename);
			
			} else {
				echo 'File Already Exists.';
			}
				
				return $shoes_image;
		}
			

		else: 
			return 'No Image';
		endif;
		
		
		
}
if(isset($_POST['action'])){
	
	switch($_POST['action']){
		case 'Add Shoes':
		///Handle File Upload 
		///echo '<pre>';
		///print_r($_FILES);
		///print_r($_POST);
		
		$shoes_image = move_image($_FILES);
		
		///exit ();
		
		
		// end handle file upload

		
		$shoes_name	= addslashes(strip_tags($_POST['shoes_name']));
		$shoes_designer_id = $_POST['shoes_designer_id'];
		$shoes_description		= addslashes(strip_tags($_POST['shoes_description']));
		$shoes_collection_id = $_POST['shoes_collection_id'];
		$shoes_type_id = $_POST['shoes_type_id'];
		$shoes_price		= is_numeric($_POST['shoes_price'])?$_POST['shoes_price']:0;
		
		
		$sql = 'INSERT INTO shoes
							(shoes_name, shoes_designer_id, shoes_description, 
							shoes_collection_id, shoes_type_id, shoes_price, shoes_image)
					VALUES ("'.$shoes_name.'",'.$shoes_designer_id.',"'.$shoes_description.'",
				'.$shoes_collection_id.','.$shoes_type_id.','.$shoes_price.',"'.$shoes_image.'")';
		//echo $sql;
		//exit();
		if($result = mysqli_query($conn, $sql)){
			$message = 'Shoe Successfully Added';
		}else{
			die('Error: '.mysqli_error($conn));	
		};	
		break; 
		
		
		//Editing Shoe, Get Data
		case 'Edit':
		$sql = 'SELECT * FROM shoes WHERE shoes_id ='.$_POST['shoes_id'];
		$result = mysqli_query($conn, $sql);
		$row2 = mysqli_fetch_array($result);
	
		break;
		
		//Update Shoes in Database
		case 'Edit Shoes':
			$shoes_name	= addslashes(strip_tags($_POST['shoes_name']));
			$shoes_designer_id = $_POST['shoes_designer_id'];
			$shoes_description		= addslashes(strip_tags($_POST['shoes_description']));
			$shoes_collection_id = $_POST['shoes_collection_id'];
			$shoes_type_id = $_POST['shoes_type_id'];
			$shoes_price		= is_numeric($_POST['shoes_price'])?$_POST['shoes_price']:0;
		
			
		
		
			$sql = 'UPDATE shoes
					SET shoes_name = "'.$shoes_name.'", 
						shoes_designer_id = '.$shoes_designer_id.',
						shoes_description ="'.$shoes_description.'",
						shoes_collection_id = '.$shoes_collection_id.',
						shoes_type_id = '.$shoes_type_id.'
						,shoes_price = '.$shoes_price.' 
						';
						
						$shoes_image = move_image($_FILES);
						$sql .= ($shoes_image) ? ', shoes_image = "'.$shoes_image.'"' : '';
					
						$sql .= '
						WHERE shoes_id = '.$_POST['shoes_id']; 
			mysqli_query($conn, $sql);
				
			header('Location:shoe.php?shoes_id='.$_POST['shoes_id']);	
		break;
		
		case 'Delete':
			$sql = 'SELECT * FROM shoes WHERE shoes_id ='.$_POST['shoes_id'];
			$result = mysqli_query($conn, $sql);
			$row2 = mysqli_fetch_array($result);
		break; 
		
		case 'Delete Shoes':
			$sql = 'DELETE FROM shoes WHERE shoes_id = '.$_POST['shoes_id'].' LIMIT 1';
			mysqli_query($conn, $sql);
		break;
		
	}
	
}

include_once('header.php');

?>
<h1 role="welcome">Welcome back <?php echo $_SESSION['user_name']?></h1>
<h3 role="logout">logout</h3>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
</head>

<body>
<?php if(isset($message)) echo $message; ?>



<article><form action= "add_shoes.php" method="post" enctype="multipart/form-data">
<?php if($_POST['action'] == 'Edit' || $_POST['action'] != 'Delete') : 

switch($_POST['action']){
	case 'Edit':
		echo '<h1>Edit '.$row2['shoes_name'].'</h1>';
	break;	
	
	case 'Delete':
		echo '<h1>Are you sure you want to delete '.$row2['shoes_name'].'</h1>';
	break;	
	
	default:
		echo '<h1>Add New Shoes</h1>';
	break;	
}
?>



	<p>
		<input type="text" name="shoes_name" placeholder="name of shoe" value="<?php echo $row2['shoes_name'] ?>">
	</p>

	<p>
		<input type="text" name="shoes_designer_id" placeholder="designer" value="<?php echo $row2['shoes_designer_id'] ?>">
	</p>
    
    <p>
		<input type="text" name="shoes_price" placeholder="price" value="<?php echo $row2['shoes_price'] ?>">
	</p>
    <p>
		<input type="file" name="shoes_image" placeholder="image" value="<?php echo $row2['shoes_image'] ?>">
	</p>

      <p>
		<textarea name="shoes_description" placeholder="description"> <?php echo $row2['shoes_description'] ?></textarea>
	</p>
    
   		Collection:
        <select name="shoes_collection_id">
        	<?php 
			$sql = 'SELECT * FROM collection';
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_array($result)){
			?>
		
        		<option <?php if($row2['shoes_collection_id'] == $row['collection_id']){echo 'selected';} ?> value="<?php echo $row['collection_id']?>"><?php echo $row['collection_type']?></option>
            
            <?php }?>
        </select>
        
        Type:
        <select name="shoes_type_id">
        	<?php 
			$sql = 'SELECT * FROM type';
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_array($result)){
			?>
		
        		<option <?php if($row2['shoes_type_id'] == $row['type_id']){echo 'selected';} ?> value="<?php echo $row['type_id']?>"><?php echo $row['type_text']?></option>
            
            <?php }?>
        </select>
   
    <p>
    Designer:
    	<select name="shoes_designer_id">
        	<?php 
			$sql = 'SELECT * FROM designer';
			$result = mysqli_query($conn, $sql);
			while($row = mysqli_fetch_array($result)){
				
			?>
            
        
      		 <option <?php if($row2['shoes_designer_id'] == $row['designer_id']){echo 'selected';} ?>  value="<?php echo $row['designer_id']?>"><?php echo $row ['designer_name']?></option>
             
             <?php }?>
       </select>
    </p>
    
<p>
<?php 
if(isset($row2['shoes_id'])) {
	echo '<input type="hidden" name="shoes_id" value="'.$row2['shoes_id'].'">';
	echo '<input type="submit" name="action" value="Edit Shoes">';
} else {
	?>
		<input type="submit" name="action" value="Add Shoes">
	<?php } ?>


<?php elseif($_POST['action'] == 'Delete'): ?>

	<h1>Are you sure you want to delete <?php echo $row2['shoes_name'] ?> </h1>
    <input type="submit" name="action" value="Delete Shoes" id= "button">
     <input type="submit" name="action" value="Cancel" id= "button">
      <input type="hidden" name="shoes_id" value="<?php echo $row2['shoes_id'] ?>">

<?php endif; ?>

</p>
    
</form></article>



</body>
</html>