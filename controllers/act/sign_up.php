<?php define('_username','');
	include_once('models/act/sign_up_m.php'); 
	
	$obj->user_name = isset($_POST["user_name"])?$_POST["user_name"]:'';
	$obj->pwd = isset($_POST["pwd"])?$_POST["pwd"]:'';
	$obj->con_pwd = isset($_POST["con_pwd"])?$_POST["con_pwd"]:'';
	$obj->service = isset($_POST["service"])?$_POST["service"]:'';
	
	$obj->last_name = isset($_POST["last_name"])?$_POST["last_name"]:'';
	$obj->first_name = isset($_POST["first_name"])?$_POST["first_name"]:'';
	$obj->email_adr = isset($_POST["email_adr"])?$_POST["email_adr"]:''; 
	
	if(isset($_POST["btncreateaccount"])){
		if(sign_up::Insert($obj)==true){ 
			$erro= "<div class='error'>Your account have been created, do you want login? </div>";
			if(_username=='Admin'){
				echo ('<script>window.location.replace("index.php?f=act&p=list_user");</script>'); 
			}else{
			 	echo ('<script>window.location.replace("index.php?f=act&p=signup_succeed");</script>'); 
			}
		}else{
			$erro= "<div class='error'>You not have permission for create user login.</div>";
		}
	} 
	
	include_once('views/act/sign_up_v.php');
?>