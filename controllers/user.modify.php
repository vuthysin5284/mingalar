<?php 
	session_start();
	require_once("../adodb/adodb.inc.php");
	require_once("../utilities/db.config.php");
	require_once("../utilities/functions.php");
	require_once("../utilities/class.paging.php");
	require_once("../models/user.php");
	require_once("../customizes/user.custom.php");
	require_once("../models/tracks.php");
	$tracks = new tracks(20,"tracks",3);
	
	$user_custom = new user_custom(20,"user",3);
	$user = new user(19,"user",3);
	$a = $_REQUEST["a"];
	
	if($a == "view"){
		
		$position = empty($_REQUEST["position"])?0:$_REQUEST["position"];
		$q = empty($_REQUEST["q"])?"":$_REQUEST["q"];
		echo $user->GetuserList($position,$q);
		
	}else if($a=="Edit"){
		
		$user->user_name = $_REQUEST["user_name"];
		$user->full_name = $_REQUEST["full_name"];
		$user->description = $_REQUEST["description"];
		$user->password = $_REQUEST["password"];
		$user->employee_id = $_REQUEST["employee_id"];
		$user->diabled = $_REQUEST["diabled"];
		$user->expired_date = formatDate($_REQUEST["expired_date"],6);
		$user->profile_id = $_REQUEST["profile_id"];
		$user->language = $_REQUEST["language"];
		$user->new_user = $_REQUEST["new_user"];
		$user->company_id = $_REQUEST["company_id"];
		
		if($user->Update($user)){
			$tracks->truck_id = 0;
			$tracks->username = $_SESSION["username"];
			$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
			$tracks->operation = "Edit User";
			$tracks->operate_date = date('Ymd h:i:s');
			$tracks->description = json_encode($user);
			$tracks->Insert($tracks);
			echo "success";
		}
		
	}else if($a == "New"){
		$user->user_name = $_REQUEST["new_user"];
		$user->full_name = $_REQUEST["full_name"];
		$user->description = $_REQUEST["description"];
		$user->password = $_REQUEST["password"];
		$user->employee_id = $_REQUEST["employee_id"];
		$user->diabled = $_REQUEST["diabled"];
		$user->expired_date = formatDate($_REQUEST["expired_date"],6);
		$user->profile_id = $_REQUEST["profile_id"];
		$user->language = $_REQUEST["language"];
		$user->company_id = $_REQUEST["company_id"];
		if($user->Insert($user))
		{
			$tracks->truck_id = 0;
			$tracks->username = $_SESSION["username"];
			$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
			$tracks->operation = "Insert New User";
			$tracks->operate_date = date('Ymd h:i:s');
			$tracks->description = json_encode($user);
			$tracks->Insert($tracks);
			echo "success";
		}
	}else if($a=="delete"){
		
		$user_name_array = explode(',',$_REQUEST["user_name"]);
		
		$detector = false;
		
		for($i = 0; $i< count($user_name_array); $i++){
			
			$user->user_name = $user_name_array[$i];
			
			$user = $user->GetuserInfoByuser_name($user);
			
			if($user->Delete($user))
			{
				$tracks->truck_id = 0;
				$tracks->username = $_SESSION["username"];
				$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
				$tracks->operation = "Delete User";
				$tracks->operate_date = date('Ymd h:i:s');
				$tracks->description = json_encode($user);
				$tracks->Insert($tracks);
				$detector = true;
				
			}else{
				$detector = false;
				break;
			}
		
		}
		
		if($detector == true){
			echo "success";
		}else{
			echo "Cannot delete this companies, because it is using other table!";
		}
		
	}
	else if($a=="check"){
		$user_custom->user_name = $_REQUEST["user_name"];
		$user_custom->diabled = $_REQUEST["diabled"];
		if($user_custom->update_diabled($user_custom))
		{
			$tracks->truck_id = 0;
				$tracks->username = $_SESSION["username"];
				$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
				$tracks->operation = "Set Activate User";
				$tracks->operate_date = date('Ymd h:i:s');
				$tracks->description = json_encode($user);
				$tracks->Insert($tracks);
			echo "success";
		}
	}else if($a == "valid"){
		$user->user_name = $_REQUEST["user_name"];
		$user->old_user_name = $_REQUEST["olduser_name"];
		$user = $user->CheckExistingUser($user);
		
		if($user["user_name"] != ""){
			echo "1";
		}else{
			echo "0";
		}
	}else if($a=="change_lang"){
		$user->user_name = $_GET["username"];
		$user = $user->GetuserInfoByuser_name($user);
		
		$user->language = $_GET["lang"];
		
		if($user->Update($user)){
			
			$_SESSION["lang"] = $user->language;
			$url = PathRoot()."/views/index.php";		
			header("location:$url");
		}
		
	}
?>
