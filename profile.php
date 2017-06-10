<?php
 include_once("includes/application_top.php"); 

if(isset($_POST['submit']))
{
	$cname=$_POST['cname'] ;
	$pname=$_POST['pname'] ;
	$description=$_POST['des'] ;
	$edate=$_POST['edate'] ;

	 $funObj->flush_table();
	 $funObj->table = "freelancer";
	 $funObj->data = array("
}

?>