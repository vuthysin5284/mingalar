<?php 
	session_start();
	require_once('../adodb/adodb.inc.php');
	require_once("../utilities/db.config.php");
	require_once("../utilities/functions.php");
	require_once("../utilities/class.paging.php");
	require_once("../models/permission.php");
	require_once("../customizes/permission.custom.php");
	
	require_once("../models/tracks.php");$tracks = new tracks(20,"tracks",3);
	$permission_custom = new permission_custom(20,"permission",3);
	$permission = new permission(20,"permission",3);
	$a = $_REQUEST["a"];
	
	if($a == "full"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->profile_id = $_REQUEST["profile_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->full = $_REQUEST["full"];
			
			if($permission_custom->CheckPermmission($permission->profile_id,0, $permission->module_id)){
			
				if($permission_custom->FullPermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date = date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Full Permission";
					$tracks->operate_date = date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "add"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->profile_id = $_REQUEST["profile_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->add = $_REQUEST["add"];
			
			if($permission_custom->CheckPermmission($permission->profile_id,0, $permission->module_id)){
			
				if($permission_custom->AddPermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Add Permission";
					$tracks->operate_date = date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "delete"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->profile_id = $_REQUEST["profile_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->delete = $_REQUEST["delete"];
			
			if($permission_custom->CheckPermmission($permission->profile_id,0, $permission->module_id)){
			
				if($permission_custom->DeletePermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Delete Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "list"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->profile_id = $_REQUEST["profile_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->list = $_REQUEST["list"];
			
			if($permission_custom->CheckPermmission($permission->profile_id, 0 , $permission->module_id)){
			
				if($permission_custom->ListPermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign List Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "edit"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->profile_id = $_REQUEST["profile_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->edit = $_REQUEST["edit"];
			
			if($permission_custom->CheckPermmission($permission->profile_id, 0,$permission->module_id)){
			
				if($permission_custom->EditPermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Edit Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "ufull"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->user_id = $_REQUEST["user_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->full = $_REQUEST["full"];
			
			if($permission_custom->CheckPermmission(0,$permission->user_id, $permission->module_id)){
			
				if($permission_custom->uFullPermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date = date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Full Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  "Assign Full Permission";
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "uadd"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->user_id = $_REQUEST["user_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->add = $_REQUEST["add"];
			
			if($permission_custom->CheckPermmission(0,$permission->user_id, $permission->module_id)){
			
				if($permission_custom->uAddPermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Add Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "udelete"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->user_id = $_REQUEST["user_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->delete = $_REQUEST["delete"];
			
			if($permission_custom->CheckPermmission(0,$permission->user_id, $permission->module_id)){
			
				if($permission_custom->uDeletePermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Delete Permission";
					$tracks->operate_date = date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "ulist"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->user_id = $_REQUEST["user_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->list = $_REQUEST["list"];
			
			if($permission_custom->CheckPermmission(0,$permission->user_id, $permission->module_id)){
			
				if($permission_custom->uListPermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign List Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}else if($a == "uedit"){
			
			$permission->permission_id = $_REQUEST["permission_id"];
			$permission->user_id = $_REQUEST["user_id"];
			$permission->module_id = $_REQUEST["module_id"];
			$permission->edit = $_REQUEST["edit"];
			
			if($permission_custom->CheckPermmission(0,$permission->user_id, $permission->module_id)){
			
				if($permission_custom->uEditPermission($permission)){
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						echo "success";
					}
					
				}
			
			}else{
			
				if($permission->Insert($permission))
				{
					$tracks->truck_id = 0;
					$tracks->username = $_SESSION["username"];
					$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
					$tracks->operation = "Assign Edit Permission";
					$tracks->operate_date =  date('Ymd h:i:s');
					$tracks->description =  json_encode($permission);
					
					if($tracks->Insert($tracks)){
						
					}
				echo "success";
				}
			}
		}
?>