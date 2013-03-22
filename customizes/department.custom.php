<?php
class profiles_custom extends profiles{
		function Get_Combobox_profiles(){
			global $db;
			$sql = "select * from profiles where profile_status=0";
			$dr = $db->Execute($sql); 
			return $dr;
		}	
	
	function GetprofilesTree($company_id){
			global $db;
			$result = "";
			$sql = "SELECT * FROM profiles p inner join company c on c.company_id = p.company_id where profile_status=0 and p.company_id = $company_id order by company_name, profile_name";
			if($company_id ==""){
				$sql = "SELECT * FROM profiles p inner join company c on c.company_id = p.company_id  where p.profile_status=0 order by company_name,p.profile_name";
			}
			$rs = $db->Execute($sql);
			return $rs;
	}
	
	function update_profile_status($objInfo){
			global $db;
			$detector = false;
			$sql = " UPDATE profiles " .
 						"SET " . 
 						"profile_status= '".$objInfo->profile_status."'" .
						" WHERE profile_id = $objInfo->profile_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
}
	
?>