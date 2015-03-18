<?php 
session_start();
require_once('../conn.php'); 

if(isset($_REQUEST['action'])){
	
	switch($_REQUEST['action']){
		
		/////////////////////////////
		//
		// LOGIN
		//
		/////////////////////////////
		case 'Login':
			$username = $_POST['username'];
			$password = $_POST['password'];
			
			// Check Database 
			if(!empty($username) && !empty($password)){
				// md5, sha1, sha256
				
				$password= sha1($password);
				
				$secret = 'ab10';
				$password = str_split($password, strlen($password)/ 2);
				$password = implode($secret, $password);
				
				///echo $password;
				///exit(); 
				
				$sql = 'SELECT * FROM users
						WHERE user_name = "'.$username.'" 
							AND user_password = "'.$password.'"';
							
				$result = mysqli_query($conn, $sql);
				$num = mysqli_num_rows($result);
				if($num > 0){
					while($row = mysqli_fetch_array($result)){
						session_start();
					
						$_SESSION['user_id'] = $row['user_id'];
						$_SESSION['user_name'] = $row['user_name'];
						$_SESSION['user_access_lvl'] = $row['user_access_lvl'];
						
						header('Location:../dashboard.php');	
						}
					
				} else {
					header('Location:../index.php?error=invalid');	
				}
				
				
			}	else {
				('Location: ../index.php?error=empty');
			}
			
		
		break;
		
		/////////////////////////////
		//
		// LOGOUT
		//
		/////////////////////////////
		case 'logout':
			$_SESSION = NULL; 
			unset($_SESSION);
			session_destroy();
			header('Location: ../index.php');
		break;
		
		/////////////////////////////
		//
		// DEFAULT
		//
		/////////////////////////////
		
		default: 
			('Location: ../index.php');
		break;
		
	}
	
} else {
	header('Location: ../index.php?error=badpath');
}




?>
