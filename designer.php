<?php require_once('header.php'); ?>





<?php

$sql ='SELECT shoes.*, designer.*, collection.*, type.*
		FROM shoes
		LEFT JOIN designer
			ON designer.designer_id = shoes.shoes_designer_id
		
		
		LEFT JOIN collection
			ON collection.collection_id = shoes.shoes_collection_id	
			
		LEFT JOIN type
			ON type.type_id = shoes.shoes_type_id
			
			WHERE designer_id = '.$_GET['designer_id'];


$result = mysqli_query($conn, $sql);



while( $row = mysqli_fetch_array($result)){
		echo '<article>';
		echo '<h2>'.$row['designer_name'].'</h2>';
		echo '<img src="'.$row['designer_image'].'">';
		echo '<h5>'.$row['designer_website'].'</h5>';
		echo '<p>'.$row['designer_description'].'</p>';
		echo '</article>';
		
	
		}

		
?>
</body>
</html>
