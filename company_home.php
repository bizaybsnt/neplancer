<?php
include('view/component/header.php');
if(isset($_SESSION['LoggedIn']))
 {
$contentPage = isset($_GET['_page'])?$_GET['_page']:"home";
include_once("view/pages/company/".$contentPage.".php");
?>

<?php
include('view/component/footer.php');
}
else
{
	 $url="login.php";
    $funObj->redirect($url);
}
?>
 
		
