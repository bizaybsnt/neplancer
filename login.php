<?php
include('includes/application_top.php');
        
        if(isset($_SESSION['LoggedIn']))
        {
            $url="index.php";
            $funObj->redirect($url);
        }
    if(isset($_POST['login_btn']))
    {
       
        $username=$_POST["uname"];
        $password=$_POST["pass"];
        
        $funObj->flush_table();
        $funObj->table="user_account";
        $funObj->cond=array("user_name"=>$username,"password"=>$password);
        $result=$funObj->select();
        $count=$funObj->total_rows($result);
        if($count==1)
        {
            $user = $funObj->fetch_assoc($result);
            
            $_SESSION['username'] = $username;
            $_SESSION['userId'] = $user['id'];
            
            
            $_SESSION['LoggedIn']=true;
            $url="index.php";
            $funObj->redirect($url);
            
        }
        else
        {
             $_SESSION['systemMessage']="Username/Password doesnot match!";
             $url="login.php";
             $funObj->redirect($url);
             
        }


      
    }
?>
<!--html>
<head>
<title>
Admin::Login
</title>
</head>
<body>
<div align="center">
    <h1>Admin::Login</br></h1>
    
	<form method="POST" action="login.php">
	<p><input type="text" name="uname" placeholder="username"></p>
	<p><input type="password" name="pass" placeholder="******"></p>
	<p><input type="submit" name="login_btn" value="login"></p>
	</form>
	</div>
</body>
</html-->

<!DOCTYPE html>
<html class="bg-white">
    <head>
        <meta charset="UTF-8">
        <title>Admin Login</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="bg-white">

        <div class="form-box" id="login-box">
            <div class="header bg-black">Login</div>
            
            <form action="login.php" method="post" >
                <div class="body bg-gray">
                    <div class="form-group">
                       <h4>Username</h4><input type="text" class="form-control" placeholder="Enter Username" name="uname"/>
                    </div>
                    <div class="form-group">
                    <h4>Password</h4>
                        <input type="password" class="form-control" placeholder="Enter Password" name="pass"/>
                    </div>   
                    <!-- <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div> -->
                     <h5><font color=red><?php
                    if (isset($_SESSION['systemMessage']))
                    {
                        echo $_SESSION['systemMessage'];
                        unset($_SESSION['systemMessage']);
                    }
                ?>  </font></h5>
                    <hr/>     

                   <center> <input type="submit" name="login_btn" value="&nbsp;&nbsp;&nbsp;&nbsp;OK&nbsp;&nbsp;&nbsp;&nbsp;" class="btn bg-black" /></center>
                    
                    </div> 
                    
               
            </form>

            
        </div>

    </body>
</html>