<?php require_once('header.php'); ?>


<h1> </h1>


<?php

$sql ='SELECT shoes.*, designer.*, collection.*, type.*
		FROM shoes
		LEFT JOIN designer
			ON designer.designer_id = shoes.shoes_designer_id
		
		
		LEFT JOIN collection
			ON collection.collection_id = shoes.shoes_collection_id	
			
			
		LEFT JOIN type
			ON type.type_id = shoes.shoes_type_id	
			';


$result = mysqli_query($conn, $sql);



while($row = mysqli_fetch_array($result)){
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
</div>

</html>
