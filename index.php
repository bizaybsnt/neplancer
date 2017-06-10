<?php
include('includes/application_top.php');

?>

<!DOCTYPE html>
<html>
<head>
	<title>Neplancer</title>
</head>
<body>

 <?php 

        if(isset($_SESSION['LoggedIn']))
        {
            echo'Welcome '.$_SESSION['username'].'||| ';     
            echo '<a href="logout.php">Logout</a>';
        }
        else
        {
        	echo '<a href="login.php">login</a>';
			echo '<a href="sign-up.php">||||register </a>';
        }

 ?>
		
</body>
</html>