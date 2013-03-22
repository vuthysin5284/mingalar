<?php  

	$_f = isset($_GET["f"])?$_GET["f"]:'act';
	$_page= isset($_GET["p"])?$_GET["p"]:'home'; 
	
	$menu = array('User','Login');
	if(strpos($_page,'ser')){ 		$_page = 'user';}
	elseif(strpos($_page,'ome')){ 	$_page = 'home';} 
	elseif(strpos($_page,'ogin')){ 	$_page = 'login';} 
	 