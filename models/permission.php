<?php
	class permission extends Paging{

		var $permission_id;
		var $profile_id;
		var $module_id;
		var $full;
		var $list;
		var $add;
		var $edit;
		var $delete;
		var $user_id;
		
		function __contructor(){
			$this->full = false;
			$this->list = false;
			$this->add = false;
			$this->edit = false;
			$this->delete = false;
			$this->profile_id = 0;
			$this->user_id = 0;
		}

		
		function GetpermissionInfoBypermission_id($obj){
			global $db;
			$sql = "select * from [permission] where [permission_id] = '".$obj->permission_id."' limit 1 ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetpermissionInfoByprofile_id($obj){
			global $db;
			$sql = "select * from [permission] where [profile_id] = '".$obj->profile_id."' limit 1 ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetpermissionInfoBymodule_id($obj){
			global $db;
			$sql = "select * from [permission] where [module_id] = '".$obj->module_id."' limit 1 ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetpermissionInfoByaccess_modify($obj){
			global $db;
			$sql = "select * from [permission] where [access_modify] = '".$obj->access_modify."' limit 1 ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}
		
		function GetpermissionInfo($user_name, $module_id){
			
			global $db;
			if(strtolower($user_name) == strtolower(default_user)){
				
				$obj = $this;
				$obj->add = 1;
				$obj->list = 1;
				$obj->edit = 1;
				$obj->delete = 1;
				$obj->full = 1;
				return $obj;
			}
			
			$sql = "select  p.* from [permission] p inner join [user] u on u.[user_id] = p.[user_id] inner join [modules] m on m.[module_id] = p.[module_id] where u.[user_name] =? and m.[form_name] = ? ";
			$rs = $db->Execute($sql,array($user_name,$module_id));
			if($rs->_numOfRows==0){
				if($_SESSION["profile_id"] > 0 and $_SESSION["profile_id"] != ""){
					$sql = "select  p.* from [permission] p inner join [modules] m on m.[module_id] = p.[module_id] where p.[profile_id] = ? and m.[form_name] = ? ";
					$rs = $db->Execute($sql,array($_SESSION["profile_id"],$module_id)); 
				}else{
					
					$obj = $this;
					$obj->add = 0;
					$obj->list = 0;
					$obj->edit = 0;
					$obj->delete = 0;
					$obj->full = 0;
					return $obj;				
				}
			}
			/*if user is equal default user has full permission automatic*/
			$obj = $this->ReadData($rs);
			return $obj;
		}
		
		function ReadData($dr){
		
			$obj = $this;
			
			 while($rs = $dr->FetchRow()){
				$obj->permission_id = $rs["permission_id"];
				$obj->profile_id = $rs["profile_id"];
				$obj->module_id = $rs["module_id"];
				$obj->user_id = $rs["user_id"];
				$obj->add = $rs["add"];
				$obj->list = $rs["list"];
				$obj->edit = $rs["edit"];
				$obj->delete = $rs["delete"];
				$obj->full = $rs["full"];
			}
			return $obj;
		}

		function Insert($objInfo){ 
		
			global $db;
			$detector = false;
			
			$sql = "INSERT INTO [permission]" .
						"([profile_id]," . 
							"[module_id]," .
							"[user_id]," .
							"[add]," .
							"[list]," .
							"[edit]," .
							"[delete]," .
							"[full])" .
						" VALUES" . 
						"(	'".$objInfo->profile_id."'," . 
							"'".$objInfo->module_id."'," . 
							"'".$objInfo->user_id."'," . 
							"'".$objInfo->add."'," . 
							"'".$objInfo->list."'," . 
							"'".$objInfo->edit."'," . 
							"'".$objInfo->delete."'," . 
							"'".$objInfo->full."')";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}


		function Delete($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = "DELETE FROM [permission] WHERE module_id='".$objInfo->module_id."' and profile_id='".$objInfo->profile_id."' ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
		function GetpermissionObject($obj){
		
			global $db;
			
			$result = "";
			$sql = "select ps.[permission_id] , ps.[full], ps.[add] , ps.[edit], ps.[delete] ,ps.[list] , m.[module_name] , m.[module_id] , ps.[profile_id], ps.[user_id] from [permission]  ps right join [modules] m on m.[module_id] = ps.[module_id] and ps.[profile_id] = '".$obj->profile_id."' where m.[active] = 0 order by  m.[module_name] ";
			$rs = $db->Execute($sql);
			return $rs;
		}
		
		function GetpermissionObjectbyUser($user_id){
		
			global $db;
			$result = "";
			$sql = "select ps.[permission_id] , ps.[full], ps.[add] , ps.[edit], ps.[delete] ,ps.[list] , m.[module_name] , m.[module_id] , ps.[profile_id], ps.[user_id] from [permission]  ps right join [modules] m on m.[module_id] = ps.[module_id] and ps.[user_id] = '".$user_id."' where m.[active] = 0 order by  m.[module_name] ";
			$rs = $db->Execute($sql);
			return $rs;
		}
		
}
?>