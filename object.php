<?php 
$newObj = '';
$_service='';

$_user = new user();

if(isset($_SESSION['u'])) {  
	$newObj = $_user->get_user($_SESSION['u']);
	$_service = $_user->service($newObj);
}
