<?php 
if($_SERVER['HTTP_HOST'] == 'localhost'){
    $conn = mysqli_connect('localhost', 'root', 'root', 'sole');
} else {
    $conn = mysqli_connect('localhost', 'smackie', '26MsePp84f', 'smackie_sole');
}

if(mysqli_connect_errno($conn)){
    echo mysqli_error($conn);
    exit();
}

?>
