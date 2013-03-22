<?php
	
	class session extends Paging{


		var $session_id;
		var $user_name;
		var $ip_address;
		var $date_login;
		var $date_logout;
		var $session_number;
		var $session_status;
		function GetsessionInfoBysession_id($obj){
			global $db;
			$sql = "select * from session where session_id = '".$obj->session_id."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetsessionInfoByuser_name($obj){
			global $db;
			$sql = "select * from [session] where [user_name] = '".$obj->user_name."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetsessionInfoByip_address($obj){
			global $db;
			$sql = "select * from session where ip_address = '".$obj->ip_address."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetsessionInfoBydate_login($obj){
			global $db;
			$sql = "select * from session where date_login = '".$obj->date_login."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetsessionInfoBydate_logout($obj){
			global $db;
			$sql = "select * from session where date_logout = '".$obj->date_logout."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetsessionInfoBysession_number($obj){
			global $db;
			$sql = "select * from session where session_number = '".$obj->session_number."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetsessionInfoBysession_status($obj){
			global $db;
			$sql = "select * from session where session_status = '".$obj->session_status."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}


		function ReadData($dr){
		
			$obj = $this;
			 while($rs = $dr->FetchRow()){
				$obj->session_id = $rs["session_id"];
				$obj->user_name = $rs["user_name"];
				$obj->ip_address = $rs["ip_address"];
				$obj->date_login = $rs["date_login"];
				$obj->date_logout = $rs["date_logout"];
				$obj->session_number = $rs["session_number"];
				$obj->session_status = $rs["session_status"];
			}
			return $obj;
		}

		
		function Update($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE session " .
 						"SET " . 
 						"user_name = '".$objInfo->user_name."'," . 
						"ip_address= '".$objInfo->ip_address."'," . 
						"date_login= '".$objInfo->date_login."'," . 
						"date_logout= '".$objInfo->date_logout."'," . 
						"session_number= '".$objInfo->session_number."'," . 
						"session_status= '".$objInfo->session_status."'" .
						" WHERE session_id = $objInfo->session_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		
		function Insert($objInfo){ 
		
			global $db;
			$detector = false;
			$sql = "INSERT INTO session" .
						"(user_name," . 
							"ip_address," . 
							"date_login," . 
							"date_logout," . 
							"session_number," . 
							"session_status)" . 
						" VALUES" . 
						"(	'".$objInfo->user_name."'," . 
							"'".$objInfo->ip_address."'," . 
							"'".$objInfo->date_login."'," . 
							"'".$objInfo->date_logout."'," . 
							"'".$objInfo->session_number."'," . 
							"'".$objInfo->session_status."')";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		
		function Delete($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = "DELETE FROM session WHERE session_id='".$objInfo->session_id."' ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		
		function GetsessionList($current_record){
		
			global $db;
			$result = "";
			$sql = "SELECT * FROM session";
			$rs = $db->Execute($sql . " limit $current_record,".$this->RECORD."");
			$checkNum = $rs->RowCount();
			$result .="<table border='1' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center' id='tz-table'>".
						"<thead height='30'><tr>".
							"<th>". ucwords(str_replace("_"," ","session_id"))."</th>".
							"<th>". ucwords(str_replace("_"," ","user_name"))."</th>".
							"<th>". ucwords(str_replace("_"," ","ip_address"))."</th>".
							"<th>". ucwords(str_replace("_"," ","date_login"))."</th>".
							"<th>". ucwords(str_replace("_"," ","date_logout"))."</th>".
							"<th>". ucwords(str_replace("_"," ","session_number"))."</th>".
							"<th>". ucwords(str_replace("_"," ","session_status"))."</th>".
"<th>Action</th></tr></thead>"; 
			$i=1;$j=0;
			while($dr = $rs->FetchRow()){ 
				
				$result .="<tr class='rowhover' id='$j'>";
							$result .="<td>".$dr["session_id"]."</td>";
							$result .="<td>".$dr["user_name"]."</td>";
							$result .="<td>".$dr["ip_address"]."</td>";
							$result .="<td>".$dr["date_login"]."</td>";
							$result .="<td>".$dr["date_logout"]."</td>";
							$result .="<td>".$dr["session_number"]."</td>";
							$result .="<td>".$dr["session_status"]."</td>";
			$result .="<td style='text-align:center'> <a href='javascript:gotoEdit(".$dr["session_id"].")'>Edit</a> | <a href='javascript:gotoDelete(".$dr["session_id"].",$j)'>Delete</a></td></tr></tr>";
 				$i++;$j++; 
 			}
			$result .="</tbody></table>";
			echo $result;
			$this->STATEMENT = $sql;
			$this->pagingLayout($current_record);
		}
		function Getsession_id(){ 
			global $db;
			$result = "";
			$sql = "select max(session_id) as autonumber from session";
			$rs = $db->Execute($sql);
			$checkNum = $rs->RowCount();
			if($checkNum==0){
				$result = str_pad(1,3,"0",STR_PAD_LEFT);
			}else{
				$row = $rs->FetchRow();
				$maxId = $row["autonumber"];
				 $result = str_pad($maxId+1,3,"0",STR_PAD_LEFT);
			}
			return $result;
		}

	}
?>
