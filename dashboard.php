<?php
session_start();
if(!isset($_SESSION['user_id'])){
	header('Location: index.php');
}


 require_once('header.php'); ?>

<h1 role="welcome">Welcome back <?php echo $_SESSION['user_name']?></h1>
<h3 role="logout">logout</h3>


<section role="dashboard">
 <aside role="stuff">


<article role="dashboardarticle">

<h3><a href="add_shoes.php">Add Shoes</a></h3>


<table border="0" cellpadding="5" cellspacing="0">
	
       <?php
	   $sql = 'SELECT shoes_id, shoes_name FROM shoes';
	   $result = mysqli_query($conn, $sql);
	   
	   while($row = mysqli_fetch_array($result)){
		   
	  
	   	
	?>
    <tr>
 
    
    	
        <td><?php echo $row['shoes_name'] ?></td>
        
        <td><form method="post" action="add_shoes.php">
        	<input type = "hidden" name="shoes_id" value = "<?php echo $row['shoes_id'] ?>">
			<input type="submit" name="action" value="Edit" id="button">
            <input type="submit" name="action" value="Delete" id="button">
</form></td>
    
   </tr>
  <?php
   }
	?>
</table>
</article>

<article role="dashboardarticle">

<h3><a href="add_designers.php">Add Designer</a></h3>


<table border="0" cellpadding="5" cellspacing="0">
	
       <?php
	   $sql = 'SELECT designer_id, designer_name FROM designer';
	   $result = mysqli_query($conn, $sql);
	   
	   while($row = mysqli_fetch_array($result)){
		   
	  
	   	
	?>
    <tr>
 
    
    
        <td><?php echo $row['designer_name'] ?></td>
        
        <td><form method="post" action="add_designers.php">
        	<input type = "hidden" name="designer_id" value = "<?php echo $row['designer_id'] ?>">
			<input type="submit" name="action" value="Edit" id="button">
            <input type="submit" name="action" value="Delete" id="button">
</form></td>
    
   </tr>
  <?php
   }
	?>
</table>
</article>

</aside>
</section>



<body>
</body>
</html>