<?php
	class permission_custom extends permission{	
	
	function DeletePermission($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = " UPDATE [permission] " .
 						" SET " . 
 						"[delete]= '".$objInfo->delete."'" .
						" WHERE [profile_id] = $objInfo->profile_id and [module_id] = $objInfo->module_id ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
	}
	
	
	
	function AddPermission($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = " UPDATE [permission] " .
 						" SET " . 
 						"[add]= '".$objInfo->add."'" .
						" WHERE [profile_id] = $objInfo->profile_id and [module_id] = $objInfo->module_id ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
	}
	
	function ListPermission($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = " UPDATE [permission] " .
 						" SET " . 
 						"[list]= '".$objInfo->list."'" .
						" WHERE [profile_id] = $objInfo->profile_id and [module_id] = $objInfo->module_id ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
	}
	
	function EditPermission($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE [permission] " .
 						"SET " . 
 						"[edit]= '".$objInfo->edit."'" .
						" WHERE [profile_id] = $objInfo->profile_id and [module_id] = $objInfo->module_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
		function FullPermission($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE [permission] " .
 						"SET " . 
 						"[full]= '".$objInfo->full."'" .
						" WHERE [profile_id] = $objInfo->profile_id and [module_id] = $objInfo->module_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
		function CheckPermmission($profile_id = 0, $user_id = 0 , $module_id){
			global $db;
			$detector = false;
			$sql = "SELECT * from [permission] where ([profile_id]=$profile_id and [user_id] = $user_id) and [module_id] =$module_id";
			
 			$rs = $db->Execute($sql);
				if($rs->RowCount() > 0){
					$detector = true;
				}
			
			return $detector;
		}
		
		function uDeletePermission($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = " UPDATE [permission] " .
 						" SET " . 
 						"[delete]= '".$objInfo->delete."'" .
						" WHERE [user_id] = $objInfo->user_id and [module_id] = $objInfo->module_id ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
	}
	
	
	
	function uAddPermission($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = " UPDATE [permission] " .
 						" SET " . 
 						"[add]= '".$objInfo->add."'" .
						" WHERE [user_id] = $objInfo->user_id and [module_id] = $objInfo->module_id ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
	}
	
	function uListPermission($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = " UPDATE [permission] " .
 						" SET " . 
 						"[list]= '".$objInfo->list."'" .
						" WHERE [user_id] = $objInfo->user_id and [module_id] = $objInfo->module_id ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
	}
	
	function uEditPermission($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE [permission] " .
 						"SET " . 
 						"[edit]= '".$objInfo->edit."'" .
						" WHERE [user_id] = $objInfo->user_id and [module_id] = $objInfo->module_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
		function uFullPermission($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE [permission] " .
 						"SET " . 
 						"[full]= '".$objInfo->full."'" .
						" WHERE [user_id] = $objInfo->user_id and [module_id] = $objInfo->module_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
	
	}
?>