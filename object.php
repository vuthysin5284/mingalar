<?php 
$newObj = '';

$_user = new user();

if(isset($_SESSION['u'])) {  
	$newObj = $_user->get_user($_SESSION['u']);
}
