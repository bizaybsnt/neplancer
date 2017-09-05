<?php
include('includes/application_top.php');

 if( isset($_SESSION['msg']))
        {
          unset($_SESSION['msg']);
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

<?php

if(isset($_POST["pay_btn"]))
{
	$full_name=$_POST["fname"];
	$company_account =$_POST["acc"];
	$pin =$_POST["pin"];

	$client_account= $_POST["caccount"];
	$amount =$_POST["amount"];

	$funObj->flush_table();
    $funObj->table = "bank";
    $funObj->tableField ="amount";
    $funObj->cond=array( "account_no"=> $company_account);
    $res = $funObj->select();
    $value = $funObj->fetch_assoc($res); //company ammount
    
    if (empty($value))
    {
    	$_SESSION["msg"] = "Your account detail is not correct";
    	$url= "payment.php?project_id=".$_GET["project_id"]."&account=".$_GET["account"];
    	$funObj->redirect($url);
    }
    // echo $value["amount"]." ";

    $funObj->cond=array( "account_no"=> $client_account);
    $res = $funObj->select();
    $client_value = $funObj->fetch_assoc($res);
    
    if (empty($client_value) || $client_account!=$_GET["account"])
    {
    	$_SESSION["msg"] = "Client account number does not exist";
    	$url= "payment.php?project_id=".$_GET["project_id"]."&account=".$_GET["account"];
    	$funObj->redirect($url);
    }
    //echo $client_value["amount"];

    $company_amount=$value["amount"]-$amount;
    $client_amount =$client_value["amount"]+$amount;

	$funObj->flush_table();
    $funObj->table = "bank";
    $funObj->data =array("amount" => $company_amount);
    $funObj->cond=array(
    			"full_name" => $full_name,
    			"pin"		=> $pin,
    			"account_no"=> $company_account
            	
            );

    $s=$funObj->update();

    $funObj->flush_table();
    $funObj->table = "bank";
    $funObj->data =array("amount" => $client_amount);
    $funObj->cond=array(
            	"account_no"=> $client_account
            );
    $funObj->update();

    if(isset($_GET['project_id']))
    {
    $funObj->flush_table();
    $funObj->table = "project_completed";
    $funObj->data =array("payment" =>1);
    $funObj->cond=array(
            	"id"=> $_GET['project_id']
            );
    $funObj->update();

    $_SESSION['paid']="Payment Successful";
    $url= "company_home.php?_page=project_list&project=completed";
    $funObj->redirect($url);
}



}

?>



<div class="container">
	<div class="row">
		<center><h2>Welcome to the Virtual Bank</h2></center>
	</div>
</div>

<form class="form-horizontal" action="" method="POST">
<fieldset>
<hr />

<div align="center">
<label>Don't Have Account?</label><br />
<a href="bankaccount.php" class="btn btn-info btn-md">Create Account</a>

</div>


<hr />
<center><legend>Account Holder Detail</legend></center>  
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">Full Name</label>  
  <div class="col-md-4">
  <input name="fname" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">Account Number</label>  
  <div class="col-md-4">
  <input name="acc" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">Pin Number</label>  
  <div class="col-md-4">
  <input name="pin" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>
<center><legend>Client Detail</legend></center>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">Client Account Number</label>  
  <div class="col-md-4">
  <input name="caccount" type="text" placeholder="" class="form-control input-md" required="">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label">Payment Amount</label>  
  <div class="col-md-4">
	  <input name="amount" type="text" placeholder="" class="form-control input-md" required="">
	   
	  <br/>
	   <center>
	   <input type="submit" name="pay_btn" value="Pay" class="btn btn-success btn-lg btn-block">
	   </center>
 </div>
</div>

</fieldset>
</form>

</body>
</html>
