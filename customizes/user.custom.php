<?php
class user_custom extends user{
		function update_diabled($objInfo){
		
			global $db;
			$detector = false;
			$sql = " UPDATE [user] " .
 						"SET " . 
 						"[diabled]= '".$objInfo->diabled."'" . 
						" WHERE [user_name] = '".$objInfo->user_name."' ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		function Get_Combobox_allUser(){
			global $db;
			$sql = "SELECT * FROM [user]";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
		function GetUserTree(){
			global $db;
			$result = "";
			$sql = "SELECT * FROM [user] u inner join employee e on e.employee_id = u.employee_id inner join profiles p on u.profile_id = p.profile_id inner join company c on c.company_id = p.company_id where diabled=0 order by company_name, profile_name, [user_name]";
			$rs = $db->Execute($sql);
			return $rs;
	}
}
?>