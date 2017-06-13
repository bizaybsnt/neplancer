<?php
 include_once("includes/application_top.php"); 

if(isset($_POST['submit']) && $_GET['user']=="freelancer")
{
	$uid = $_GET['id'];
	$location=$_POST['location'];
	$overview=$_POST['overview'];

	$cname=$_POST['cname'] ;
	$pname=$_POST['pname'] ;
	$description=$_POST['desc'] ;
	$edate=$_POST['edate'] ;
		
	 $funObj->flush_table();
	 $funObj->table = "freelancer";
	 $funObj->data = array("user_account_id"=>$uid,"location"=>$location,"overview"=>$overview);
	 $funObj->insert();

	$funObj->flush_table();
	 $funObj->table = "freelancer";
	 $funObj->tableField ="id";
	$funObj->cond = array("user_account_id"=>$uid,"location"=>$location,"overview"=>$overview);
	$res = $funObj->select();

	$user = $funObj->fetch_assoc($res);

	

	 $funObj->flush_table();
	 $funObj->table = "certification";
	 $funObj->data = array("freelancer_id"=>$user['id'],"certification_name"=>$cname,"provider"=>$pname,"description"=>$description,"date_earned"=>$edate);
	 $funObj->insert();

}
else if(isset($_POST['submit'])&& $_GET['user']=="company")

{
	$uid = $_GET['id'];
	$cname=$_POST['cname'];
	$location = $_POST['location'];

	$funObj->flush_table();
	$funObj->table = "company";
	$funObj->data = array("user_account_id"=>$uid,"company_name"=>$cname,"location"=>$location);
	$funObj->insert();
}

?>