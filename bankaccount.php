<?php 
include('includes/application_top.php');

if(isset($_POST['sbt_btn']))
{
$fname=$_POST['fname'] ;
$pin=$_POST['pin'] ;
$uname=$_POST['username'] ;


 $funObj->flush_table();
 $funObj->table = "bank";
 $funObj->data = array("full_name"=>$fname, "pin"=>$pin);
 $funObj->insert();

 $funObj->flush_table();
 $funObj->table="bank";
 $funObj->cond=array("full_name"=>$fname, "pin"=>$pin);
 $result=$funObj->select();
 $data = $funObj->fetch_assoc($result);

 echo $data[account_no];


 $funObj->flush_table();
 $funObj->table = "user_account";
 $funObj->cond = array("user_name"=>$uname);
 $result=$funObj->select();

 $count=$funObj->total_rows($result);

 $user = $funObj->fetch_assoc($result);
 if($count!=1)
 { 

 	$_SESSION["msg"] = "username doesnot match";
 	 $url= "payment.php";
 $funObj->redirect($url);
 }

else
{
	         $funObj->flush_table();
    	$funObj->table = "user_account";
    	$funObj->data =array("account_no" => $data[account_no] );
    	$funObj->cond=array(
    			"user_name" => $user['user_name']
            );

    	$s=$funObj->update();

}


 
 $_SESSION["msg"] = "Your account has been created";
 $url= "payment.php";
 $funObj->redirect($url);



}

?>

<html>
<html>
<head>
	<title>Virtual Bank</title>
	 <link href="css/bootstrap.min.css" rel="stylesheet">
	 <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />
</head>
<body>

<div class="container">
	<div class="row">
		<center><h2>Welcome to the Virtual Bank</h2></center>
	</div>
</div>
<form class="form-horizontal" action="" method="POST">
<fieldset>

<center><legend>Fill Account Details</legend></center>  

 

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">Full Name</label>  
  <div class="col-md-4">
  <input name="fname" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<div class="form-group">
  <label class="col-md-4 control-label">Username</label>  
  <div class="col-md-4">
  <input name="username" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">Pin Number</label>  
  <div class="col-md-4">
	  <input name="pin" type="text" placeholder="" class="form-control input-md" required="">
	   
	  <br/>
	   <center>
	   <input type="submit" name="sbt_btn" value="Create Account" class="btn btn-success btn-lg btn-block">
	   </center>
 </div>
</div>

</fieldset>
</form>

</body>
</html>
