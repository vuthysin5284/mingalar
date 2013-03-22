<?php
	
	class user extends Paging{

		var $user_name;
		var $old_user_name;
		var $full_name;
		var $description;
		var $password;
		var $employee_id;
		var $diabled;
		var $expired_date;
		var $profile_id;
		var $language;
		var $new_user;
		var $shift_id;
		var $company_id;
		
		function GetuserInfoByuser_name($obj){
			global $db;
			$db->debug = 1;
			$sql = "select [user_id]
      ,[user_name]
      ,[full_name]
      ,[description]
      ,[password]
      ,[employee_id]
      ,[profile_id]
      ,[diabled]
      ,[expired_date]
      ,[language],company_id from [user] where [user_name] = '".$obj->user_name."'  "; 
			$rs = $db->Execute($sql); 
			
			return $this->ReadData($rs);
		}
		function GetExpiredUsername($obj){
			global $db;
			$sql = "select * from [user] where [user_name] = '".$obj->user_name."' and diabled=0 and expired_date > now()  "; 
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}
		function GetuserInfoByfull_name($obj){
			global $db;
			$sql = "select * from [user] where full_name = '".$obj->full_name."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetuserInfoBydescription($obj){
			global $db;
			$sql = "select * from [user] where description = '".$obj->description."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetuserInfoBypassword($obj){
			global $db;
			$sql = "select * from [user] where [password] = '".$obj->password."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}
		function GetuserInfoByemployee_id($obj){
			global $db;
			$sql = "select * from [user] where employee_id = '".$obj->employee_id."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetuserInfoBydiabled($obj){
			global $db;
			$sql = "select * from [user] where diabled = '".$obj->diabled."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetuserInfoByexpired_date($obj){
			global $db;
			$sql = "select * from [user] where expired_date = '".$obj->expired_date."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetuserInfoByprofile_id($obj){
			global $db;
			$sql = "select * from [user] where [profile_id] = '".$obj->profile_id."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}
		function CheckExistingUser($obj){
			global $db;
			
			$sql = "select * from [user] where [user_name] = '".$obj->user_name."'  ";
			$dr = $db->Execute($sql)->Fetchrow(); 
			return $dr['user_name'];
			
		}
		function GetAllUserInfo($obj){
			global $db;
			$sql = "select * from [user]";
			$dr = $db->Execute($sql); 
			return $dr;
		}


		function ReadData($rs){
			
			 while($dr = $rs->FetchRow()){
				
				$this->user_name = $dr["user_name"];
				$this->full_name = $dr["full_name"];
				$this->description = $dr["description"];
				$this->password = $dr["password"];
				$this->employee_id = $dr["employee_id"];
				$this->diabled = $dr["diabled"];
				$this->expired_date = $dr["expired_date"];
				$this->profile_id = $dr["profile_id"];
				$this->language = $dr["language"];
				$this->company_id = $dr["company_id"];
			}

			return $this;
		}

		
		function Update($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE [user] " .
 						"SET " . 
 						"[full_name] = '".$objInfo->full_name."'," . 
						"[description]= '".$objInfo->description."'," . 
						"[password]= '".$objInfo->password."'," . 
						"employee_id= '".$objInfo->employee_id."'," . 
						"diabled= '".$objInfo->diabled."'," . 
						"expired_date= '".$objInfo->expired_date."'," . 
						"[language]= '".$objInfo->language."'," .
						"profile_id= '".$objInfo->profile_id."', [user_name] = '".$objInfo->new_user."', [company_id] = '".$objInfo->company_id."' " .
						" WHERE [user_name] = '".$objInfo->user_name."' ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}


		function Insert($objInfo){ 
		
			global $db;
			$detector = false;
			$sql = "INSERT INTO [user]" .
						"([user_name]," .
							"full_name," . 
							"[description]," . 
							"[password]," . 
							"employee_id," . 
							"diabled," . 
							"expired_date," . "language," . 
							"profile_id,company_id)" . 
						" VALUES" . 
						"(	'".$objInfo->user_name."','".$objInfo->full_name."'," . 
							"'".$objInfo->description."'," . 
							"'".$objInfo->password."'," . 
							"'".$objInfo->employee_id."'," . 
							"'".$objInfo->diabled."'," . 
							"'".$objInfo->expired_date."'," . "'".$objInfo->language."'," . 
							"'".$objInfo->profile_id."','".$objInfo->company_id."')";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}


		function Delete($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = "DELETE FROM [user] WHERE [user_name]='".$objInfo->user_name."' ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}


		function GetuserList($current_record,$q){
		
			global $db;
			$result = '';
			$sql = "SELECT * FROM(SELECT ROW_NUMBER() OVER(ORDER BY user_name) as ROW_NUMBER,u.*,e.seller_name, c.company_name FROM [user] u INNER JOIN employee e ON u.employee_id=e.employee_id INNER JOIN profiles p ON p.profile_id=u.profile_id inner join company c on c.company_id = e.company_id)
		   as A	WHERE ROW_NUMBER between $current_record and ".($this->RECORD+$current_record)." ORDER BY ROW_NUMBER ,[user_name],expired_date,seller_name ";
		   
		   $search = "SELECT count(*) ROW_NUMBER FROM [user] u INNER JOIN employee e ON u.employee_id=e.employee_id INNER JOIN profiles p ON p.profile_id=u.profile_id";
		   
			if($q != ""){
				$sql = "SELECT * FROM(SELECT ROW_NUMBER() OVER(ORDER BY user_name) as ROW_NUMBER,u.*,replace(e.seller_name,'$q','<strong>$q</strong>') as seller_name, c.company_name FROM [user] u INNER JOIN employee e ON u.employee_id=e.employee_id INNER JOIN profiles p ON p.profile_id=u.profile_id inner join company c on c.company_id = e.company_id where CONCAT(LCASE(u.user_name),LCASE(u.full_name),LCASE(u.description),u.expired_date,LCASE(e.seller_name),LCASE(p.profile_name)) like '%".strtolower($q)."%' ) as A	WHERE ROW_NUMBER between $current_record and ".($this->RECORD+$current_record)." ORDER BY ROW_NUMBER ,[user_name],expired_date,seller_name ";
				$search = "SELECT count(*) ROW_NUMBER FROM [user] u INNER JOIN employee e ON u.employee_id=e.employee_id INNER JOIN profiles p ON p.profile_id=u.profile_id where CONCAT(LCASE(u.user_name),LCASE(u.full_name),LCASE(u.description),u.expired_date,LCASE(e.seller_name),LCASE(p.profile_name)) like '%".strtolower($q)."%'";
			}
			$rs = $db->Execute($sql);
			
			$dt = $db->Execute($search);
			$rowCount = $dt->FetchRow();
			$this->ROWS = $rowCount["ROW_NUMBER"];
			
			$result .="<table border='1' cellspacing='0' cellpadding='3' id='tz-table' align='center'>".
						"<thead height='30'><tr><th><input type='checkbox' name='toggle' onclick='checkAll(this.checked,\"user_group\");' /></th>".
							"<th>". ucwords(str_replace("_"," ","No"))."</th>".
							"<th>". ucwords(str_replace("_"," ","User name"))."</th>".
							"<th>". ucwords(str_replace("_"," ","Full name"))."</th>".
							"<th>". ucwords(str_replace("_"," ","Description"))."</th>".
							"<th>". ucwords(str_replace("_"," ","Password"))."</th>".
							"<th>". ucwords(str_replace("_"," ","Company"))."</th>".
							"<th>". ucwords(str_replace("_"," ","department"))."</th>".
							"<th>". ucwords(str_replace("_"," ","Employee"))."</th>".
							
							"<th>". ucwords(str_replace("_"," ","Expired Date"))."</th>".
							"<th>". ucwords(str_replace("_"," ","Deactivate"))."</th>".
							"<th>". ucwords(str_replace("_"," ","Action"))."</th>".
						"</tr></thead><tbody>"; 
			$i=1;$j=0;$k=$current_record+1;
			while($dr = $rs->FetchRow()){ 
				
				$em = "SELECT * FROM employee where employee_id='{$dr['employee_id']}'";
				$rsem = $db->Execute($em)->FetchRow();
				$pro = "SELECT * FROM profiles where profile_id='{$dr['profile_id']}'";
				$rspro = $db->Execute($pro)->FetchRow();
				
				$password = "**********";
				
				if(strtolower($_SESSION["username"]) == strtolower(default_user)){
					$password = $dr["password"];
				}
				
				$result .="<tr class='rowhover'>".
						"<td class='center'><input type='checkbox' id='cb".$j."' name='user_group' value='".$dr["user_name"]."' onclick=\"isChecked(this.checked,'".$dr["user_name"]."');\" /></td>".
							"<td>".$k."</td>".
							"<td class='left'>".$dr["user_name"]."</td>".
							"<td class='left'>".$dr["full_name"]."</td>".
							"<td class='left'>".$dr["description"]."</td>".
							"<td class='left'>".$password."</td>".
							"<td class='left'>".$dr["company_name"]."</td>".
							"<td class='left'>".$rspro["profile_name"]."</td>".
							"<td class='left'>".$dr["seller_name"]."</td>".
							
							"<td>".formatDate($dr["expired_date"],2)."</td>";
							if($dr["diabled"]==1){
							$result.="<td style='text-align:center'><input type='checkbox'  value='' onclick=\"click_check('".$dr["user_name"]."',this);\" checked /></td>";
							}
							else{
							$result.="<td style='text-align:center'><input type='checkbox'  value='' onclick=\"click_check('".$dr["user_name"]."',this);\" /></td>";
							}
							
			$result.="<td style='text-align:center'><a href='javascript:gotoEdit(\"".$dr["user_name"]."\")'>Edit</a></td></tr>";
 				$i++;$j++;$k++; 
 			}
			$result .="</tbody></table>".
					"";
					
			echo $result;
			
			$this->pagingLayout($current_record,$q);
		}
		
		function Getemployee_idByuser_name($obj){
			global $db;
			$result = "";
			$sql = "select employee_id from [user] where [user_name]='".$obj->user_name."'";
			$rs = $db->Execute($sql);
			return $rs;
		}

	}
?>
