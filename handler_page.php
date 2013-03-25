<?php  

	$_f = isset($_GET["f"])?$_GET["f"]:'act';
	$_page= isset($_GET["p"])?$_GET["p"]:'home'; 
	
	if(strpos($_page,'ome')){				$_page = 'home';} 
	elseif(strpos($_page,'ogin')){			  $_page = 'login';} 
	elseif(strpos($_page,'orgot_password')){ 	$_page = 'pwd_4got';} 
	elseif(strpos($_page,'ign_up')){ 	 		$_page = 'sign_up';} 
	elseif(strpos($_page,'ist_user')){ 	 	$_page = 'list_user';} 
	
	elseif(strpos($_page,'tore')){ 	 		$_page = 'store';} 
	elseif(strpos($_page,'ob')){ 	 		$_page = 'jobs';} 
	 