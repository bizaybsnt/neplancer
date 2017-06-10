<?php
 include_once("includes/application_top.php"); 

if(isset($_POST['submit']))
{
$fname=$_POST['fname'] ;
$lname=$_POST['lname'] ;
$username=$_POST['uname'] ;
$password=$_POST['pass'] ;
$email=$_POST['email'] ;
// var_dump($_POST['usertype']);
if($_POST['usertype']=="freelancer")
{
	$usertype=0;
}
else
{
	$usertype=1;
}

 $funObj->flush_table();
 $funObj->table = "user_account";
 $funObj->data = array("user_name"=>$username, "password"=>$password,"email"=>$email,"first_name"=>$fname,"last_name"=>$lname,"user_type"=>$usertype);
 $funObj->insert();




 $funObj->flush_table();
 $funObj->table = "user_account";
 $funObj->tableField ="id";
$funObj->cond = array("user_name"=>$username, "password"=>$password,"email"=>$email,"first_name"=>$fname,"last_name"=>$lname);
$res = $funObj->select();

$user = $funObj->fetch_assoc($res);

// echo $user['id'];
 
}
?>

<html>
<head>
<title> </title>
</head>
<body>
<?php 
	if($_POST['usertype']=="freelancer")
	{
		?>
		<form action=<?php echo "profile.php?id=".$user['id']."&user=freelancer" ?> method="POST">
		Enter certificate you obtain 
		Name of Cerificate <input type="text" name="cname"/></br>
		Provider Name <input type="text" name="pname"/></br>
		About Certificate<input type="text" name="desc"/></br>
		Date Earned <input type="text" name="edate"></br>

		<input type="submit" name="submit" value="submit">

		</form>

		<?php
	}
	else if($_POST['usertype']=="company")
	{

		?>

		<form action=<?php echo "profile.php?id=".$user['id']."&user=company" ?> method="POST">
		COmpany 
	<!-- 	Name of Cerificate <input type="text" name="cname"/></br>
		Provider Name <input type="text" name="pname"/></br>
		About Certificate<input type="text" name="desc"/></br>
		Date Earned <input type="text" name="edate"></br>

		<input type="submit" name="submit" value="submit"> -->

		</form>

		<?php
			}
		?>
</body>
</html>