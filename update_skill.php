	<?php
	include('view/component/header.php');
	?>
	<?php 

	if(isset($_SESSION['LoggedIn']))
	{



		$funObj->flush_table();
		$funObj->table = "freelancer";
		$funObj->cond = array("user_account_id"=>$_SESSION['userId']);
		$result=$funObj->select();
		$user = $funObj->fetch_assoc($result);
		$userId = $user['id'];




		$funObj->flush_table();
		$funObj->table = "skill";
		$funObj->cond = array();
		$res = $funObj->select();

		echo "Please select your skills";
		echo "<form action='update_skill.php' method='POST'>";

		while( $row = $funObj->fetch_assoc( $res ) )
		{
			$skill=$row['skill_name'];
			$skillId=$row['id'];
			echo "<input type='checkbox' name='skill[]' value='{$skillId}'>{$skill}<br>";
		}

		echo "<input type='submit' name='sbn_btn' value='Update'>";



		if(isset($_POST['sbn_btn']))
		{
			$skills =$_POST['skill'];
			
			echo "<br>";
			

			foreach ($_POST['skill'] as $sk) 
			{
				$funObj->flush_table();
				$funObj->table = "has_skill";
				$funObj->data = array("skill_id"=>$sk, "freelancer_id"=>$userId);
				$funObj->insert();
			}

			$url="profile.php";
			$funObj->redirect($url);
			
			
		}


	}
	else
	{
		$url="index.php";
		$funObj->redirect($url);
	}

	?>
