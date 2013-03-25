<?php
	//include_once('models/act/login_m.php');
	
	if(isset($_POST['is_submit'])) {
	
		$obj->username = isset($_POST['txtuser_name']) ? $_POST['txtuser_name'] : '';
		$obj->password = isset($_POST['txtpwd']) ? $_POST['txtpwd'] : ''; 
	 
		if(empty($obj->username) ||
			empty($obj->password) ||
			strlen($obj->password) < 6 //||
			//!User::id_exist($obj->username)
			)
			//$_msg->set_msg(_t('login_invalid'), 0);
	echo 'etst';
	
		//if(!$_msg->has_msg)
		if(user::login($obj->username, $obj->password)) {  
			echo 'seccude';
			$success = true;
		} else {echo 'test';}//$_msg->set_msg(_t('login_fail'), 0);
		
		if($success) util::redirect('index.php');
		unset($success);
		
	}


	include_once('views/act/login_v.php');
?>