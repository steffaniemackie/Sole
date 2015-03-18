<?php require_once('header.php'); ?>


<h1>Shoes</h1>


<?php

$sql ='SELECT * FROM shoes 
	LEFT JOIN designer 
		ON shoes.shoes_designer_id = designer.designer_id
			WHERE shoes_id = '.$_GET['shoes_id'];


$result = mysqli_query($conn, $sql);



while( $row = mysqli_fetch_array($result)){
		echo '<article>';
		echo '<h2>'.$row['shoes_name'].'</h2>';
		echo '<h3>'.$row['designer_name'].'</h3>';
		echo '<img src="'.$row['shoes_image'].'">';
		echo '<h4>'.$row['type_text'].'</h4>';
		echo '<h5>'.$row['collection_type'].'</h5>';
		echo '<p>'.$row['shoes_description'].'</p>';
		echo '<small>price: $'.$row['shoes_price'].'</small>';
		
		echo '</article>';
		
		
		
				
				
	
		}

		
?>
</body>
</html>
