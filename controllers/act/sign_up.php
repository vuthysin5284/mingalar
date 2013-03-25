<?php 
	include_once('models/act/sign_up_m.php'); 
	
	$obj->user_name = isset($_POST["user_name"])?$_POST["user_name"]:'';
	$obj->pwd = isset($_POST["pwd"])?$_POST["pwd"]:'';
	$obj->last_name = isset($_POST["last_name"])?$_POST["last_name"]:'';
	$obj->first_name = isset($_POST["first_name"])?$_POST["first_name"]:'';
	$obj->email_adr = isset($_POST["email_adr"])?$_POST["email_adr"]:''; 
	if(isset($_POST["btncreateaccount"])){
		if(sign_up::Insert($obj)==true){ 
			//$erro= "<div class='error'>Your account have been created, do you want login? </div>";
			header('location:index.php?f=act&p=list_user');
		}else{
			$erro= "<div class='error'>You not have permission for create user login.</div>";
		}
	}
	 
	
	include_once('views/act/sign_up_v.php');
?>