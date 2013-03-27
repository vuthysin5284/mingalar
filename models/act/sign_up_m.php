<?php

class sign_up{
	
	function Insert($objInfo){ 
		global $db; 
		$detector = false; 
		$sql = " INSERT INTO m_account " .
					"SET " . 
					"user_name = '".$objInfo->user_name."'," . 
					"name= '".$objInfo->last_name .' '. $objInfo->first_name."'," .  
					"password= '".md5($objInfo->pwd)."'," . 
					"insert_date=now(),".   
					"email= '".$objInfo->email_adr."'";
		if($db->Execute($sql)){
			$detector = true; 
			
			$obj->account_id = $db->Insert_ID('m_account','account_id');
			$obj->service_id = $objInfo->service;
			sign_up::insert_account_service($obj);
		}
		return $detector;
	}
	
	static function insert_account_service($obj){
		global $db;   
		$sql = " INSERT INTO account_service " .
					"SET " . 
					"service_id = '".$obj->service_id."'," . 
					"account_id= '".$obj->account_id."'," . 
					"insert_date=now()";
		$db->Execute($sql);
	}
	
	function Update($objInfo){ 
		global $db;
		$detector = false; 
		$sql = " Update m_account " .
					"SET " . 
					"user_name = '".$objInfo->user_name."'," . 
					"name= '".$objInfo->last_name .' '. $objInfo->first_name."'," .  
					"password= '".md5($objInfo->pwd)."'," .   
					"email= '".$objInfo->email_adr."'".
					"update_date=now(),".  
					" WHERE account_id = $objInfo->account_id ";
		if($db->Execute($sql)){
			$detector = true;
		}
		return $detector;
	}
	
	function Delete($objInfo){ 
		global $db;
		$detector = false; 
		$sql = " Update m_account " .
					"SET " .
					"deleted_date=now(),".  
					"active= 0".
					" WHERE account_id = $objInfo->account_id ";
		if($db->Execute($sql)){
			$detector = true;
		}
		return $detector;
	}
	
	function UserInfo(){  
		global $db;
		$result = "";
		$sql = "select * from m_account";
		$rs = $db->Execute($sql); 
		$result .="<table border='1' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center' id='tz-table'>".
					"<thead height='30'><tr>".
						"<th>No</th>". 
						"<th>User Name</th>".
						"<th>Last name</th>".
						"<th>First name</th>".
						"<th>Email</th>". 
						"<th>Action</th>".
					"</tr></thead>"; 
		$i=1;$j=0;
		while($dr = $rs->FetchRow()){ 
				
			$result .="<tr class='rowhover'>". 
						"<td>".$i."</td>". 
						"<td>".$dr["user_name"]."</td>".
						"<td>".$dr["last_name"]."</td>".
						"<td>".$dr["first_name"]."</td>".
						"<td>".$dr["email"]."</td>". 
		"<td style='text-align:center'><a href='javascript:gotoEdit(\"".$dr["employee_id"]."\")'>Edit</a></td></tr>";
			$i++;$j++; 
		}
	$result .="</tbody></table>";
	return $result;
	//$this->STATEMENT = $sql;
	//$this->pagingLayoutList($current_record,""); 
	}
	function UserList(){  
		global $db;
		$result = "";
		$sql = "select * from m_account where active!=0";
		$rs = $db->Execute($sql); 
		$result .="<table border='1' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center' id='tz-table'>".
					"<thead height='30'><tr>".
						"<th>No</th>". 
						"<th>User Name</th>".
						"<th>Full Name</th>". 
						"<th>Email</th>". 
						"<th>Action</th>".
					"</tr></thead>"; 
		$i=1;$j=0;
		while($dr = $rs->FetchRow()){ 
				
			$result .="<tr class='rowhover'>". 
						"<td align='center'>".$i."</td>". 
						"<td align='center'>".$dr["user_name"]."</td>".
						"<td align='center'>".$dr["name"]."</td>". 
						"<td align='center'>".$dr["email"]."</td>". 
		"<td style='text-align:center'><a onclick='return gotoDelete(\"".$dr["account_id"]."\"); false'>Delete</a></td></tr>";
			$i++;$j++; 
		}
	$result .="</tbody></table>";
	return $result;
	//$this->STATEMENT = $sql;
	//$this->pagingLayoutList($current_record,""); 
	} 
	
	// select service
	function ServiceList(){
		global $db;
		$sql = "select * from m_service where active=1";
		$result = $db->Execute($sql);
		while($dr = $result->FetchRow()){
			echo "<option value='".$dr["service_id"]."'>".$dr["service_name"]."</option>";
		}
	}
}