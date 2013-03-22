<?php

	class tracks extends Paging{


		var $track_id;
		var $username;
		var $ip_address;
		var $operation;
		var $operate_date;
		var $description;
		
		function GettracksInfoBytrack_id($obj){
			global $db;
			$sql = "select * from tracks where track_id = '".$obj->track_id."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GettracksInfoByusername($obj){
			global $db;
			$sql = "select * from tracks where username = '".$obj->username."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GettracksInfoByip_address($obj){
			global $db;
			$sql = "select * from tracks where ip_address = '".$obj->ip_address."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GettracksInfoByoperation($obj){
			global $db;
			$sql = "select * from tracks where operation = '".$obj->operation."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GettracksInfoByoperate_date($obj){
			global $db;
			$sql = "select * from tracks where operate_date = '".$obj->operate_date."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GettracksInfoBydescription($obj){
			global $db;
			$sql = "select * from tracks where description = '".$obj->description."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}


		function ReadData($dr){
		
			$obj = $this;
			 while($rs = $dr->FetchRow()){
				$obj->track_id = $rs["track_id"];
				$obj->username = $rs["username"];
				$obj->ip_address = $rs["ip_address"];
				$obj->operation = $rs["operation"];
				$obj->operate_date = $rs["operate_date"];
				$obj->description = $rs["description"];
			}
			return $obj;
		}

		function Update($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE tracks " .
 						"SET " . 
 						"username = '".$objInfo->username."'," . 
						"ip_address= '".$objInfo->ip_address."'," . 
						"operation= '".$objInfo->operation."'," . 
						"operate_date= '".$objInfo->operate_date."'," . 
						"description= '".$objInfo->description."'" .
						" WHERE track_id = $objInfo->track_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		function Insert($objInfo){ 
		
			global $db;
			$detector = false;
			$sql = "INSERT INTO tracks" .
						"(username," . 
							"ip_address," . 
							"operation," . 
							"operate_date," . 
							"[description])" . 
						" VALUES" . 
						"('".$objInfo->username."'," . 
							"'".$objInfo->ip_address."'," . 
							"'".$objInfo->operation."'," . 
							"'".$objInfo->operate_date."'," . 
							"'".$objInfo->description."')";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		function Delete($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = "DELETE FROM tracks WHERE track_id='".$objInfo->track_id."' ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}


		function GettracksList($current_record){
		
			global $db;
			$result = "";
			$sql = "SELECT * FROM tracks order by operate_date desc ";
			$rs = $db->Execute($sql . " limit $current_record,".$this->RECORD."");
			$checkNum = $rs->RowCount();
			$result .="<table border='1' id='tz-table' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center'>".
						"<thead height='30'><tr>".
							"<th>Truck No</th>".
							"<th>Username</th>".
							"<th>IP Address</th>".
							"<th>Operation</th>".
							"<th>Date</th>".
							"<th>Description</th>".
						"</tr></thead>"; 
			$i=1;$j=0;
			while($dr = $rs->FetchRow()){ 
				$dot = "";
				if(strlen($dr["description"])>100){
					$dot = "...";
				}
				$result .="<tr class='rowhover'>".

							"<td class='center'>".$dr["track_id"]."</td>".
							"<td>".$dr["username"]."</td>".
							"<td>".$dr["ip_address"]."</td>".
							"<td class='left'>".$dr["operation"]."</td>".
							"<td class='center'>".formatDate($dr["operate_date"],10)."</td>".
							"<td class='left'>".substr($dr["description"],0,100)."$dot</td>".
			"</tr>";
 				$i++;$j++; 
 			}
			$result .="</tbody></table>";
			echo $result;
			$this->STATEMENT = $sql;
			$this->pagingLayoutList($current_record,""); 
			
		}
		
		function GettracksListByEmployeeID($current_record,$employee_id){
		
			global $db;
			$result = "";
			$sql = "select * from tracks t inner join user u on u.user_name = t.username
where u.employee_id='".$employee_id."' order by operate_date desc ";
			$rs = $db->Execute($sql);
			$checkNum = $rs->RowCount();
			$result .="<table border='1' id='tz-table' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center'>".
						"<thead height='30'><tr>".
							"<th>Truck No</th>".
							"<th>Username</th>".
							"<th>IP Address</th>".
							"<th>Operation</th>".
							"<th>Date</th>".
							"<th>Description</th>".
						"</tr></thead>"; 
			$i=1;$j=0;
			while($dr = $rs->FetchRow()){ 
				$dot = "";
				if(strlen($dr["description"])>100){
					$dot = "...";
				}
				$result .="<tr class='rowhover'>".

							"<td class='center'>".$dr["track_id"]."</td>".
							"<td>".$dr["username"]."</td>".
							"<td>".$dr["ip_address"]."</td>".
							"<td class='left'>".$dr["operation"]."</td>".
							"<td class='center'>".formatDate($dr["operate_date"],10)."</td>".
							"<td class='left'>".substr($dr["description"],0,100)."$dot</td>".
			"</tr>";
 				$i++;$j++; 
 			}
			$result .="</tbody></table>";
			echo $result;
			$this->STATEMENT = $sql;
			$this->pagingLayoutList($current_record,""); 
			
		}
		
		function GettracksSearchListByDate($current_record,$start,$end){
		
			global $db;
			$result = "";
			
			$sql = "SELECT * FROM tracks where operate_date between '".$start."' and '".$end."' ";
			$rs = $db->Execute($sql);
			$checkNum = $rs->RowCount();
			$result .="<table border='1' id='tz-table' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center'>".
						"<thead height='30'><tr>".
							"<th>Truck No</th>".
							"<th>Username</th>".
							"<th>IP Address</th>".
							"<th>Operation</th>".
							"<th>Date</th>".
							"<th>Description</th>".
						"</tr></thead>"; 
			$i=1;$j=0;
			while($dr = $rs->FetchRow()){ 
					$dot = "";
				if(strlen($dr["description"])>100){
					$dot = "...";
				}
				$result .="<tr class='rowhover'>".

							"<td class='center'>".$dr["track_id"]."</td>".
							"<td>".$dr["username"]."</td>".
							"<td>".$dr["ip_address"]."</td>".
							"<td>".$dr["operation"]."</td>".
							"<td>".formatDate($dr["operate_date"],10)."</td>".
							"<td>".substr($dr["description"],0,100)."$dot</td>".
			"</tr>";
 				$i++;$j++; 
 			}
			$result .="</tbody></table>";
			echo $result;
			//$this->STATEMENT = $sql;
			//$this->pagingLayoutList($current_record,""); 
		}
		
		function GettracksSearchList($current_record,$q,$t){
		
			global $db;
			
			$result = "";
			$sql = "SELECT top(100) s.track_id,
					 , (s.username) as username
					 , (s.ip_address) as ip_address
					 , (s.operation) as operation
					 , (s.operate_date) as operate_date
					 , (s.description) as description FROM tracks s ";
			if($t==1){
			$sql = "SELECT top(100) s.track_id
					 , (s.username) as username
					 , (s.ip_address) as ip_address
					 , (s.operation) as operation
					 , (s.operate_date) as operate_date
					 , (s.description) as description FROM tracks s where  s.username like '%$q%'
					 ";
			}else if($t==3){
				$sql = "SELECT top(100) s.track_id
					 , (s.username) as username
					 , (s.ip_address) as ip_address
					 , (s.operation) as operation
					 , (s.operate_date) as operate_date
					 , (s.description) as description FROM tracks s where s.ip_address like '%$q%'
					 ";	
			}else if($t==4){
				
				$sql = "SELECT top(100) s.track_id
					 , (s.username) as username
					 , (s.ip_address) as ip_address
					 , (s.operation) as operation
					 , (s.operate_date) as operate_date
					 , (s.description) as description FROM tracks s where s.description like '%$q%' ";	
			}
					 
			$rs = $db->Execute($sql ." order by s.track_id desc" );
			$checkNum = $rs->RowCount();
			$result .="<table border='1' id='tz-table' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center'>".
						"<thead height='30'><tr>".
							"<th width='70'>Truck No</th>".
							"<th width='100'>Username</th>".
							"<th width='100'>IP Address</th>".
							"<th width='120'>Operation</th>".
							"<th width='100'>Date</th>".
							"<th width='400'>Description</th>".
						"</tr></thead>"; 
			$i=1;$j=0;
			while($dr = $rs->FetchRow()){
					
				$result .="<tr class='rowhover'>".
							"<td class='center'>".$dr["track_id"]."</td>".
							"<td>".$dr["username"]."</td>".
							"<td>".$dr["ip_address"]."</td>".
							"<td>".$dr["operation"]."</td>".
							"<td>".formatDate($dr["operate_date"],9)."</td>".
							"<td style='word-wrap:break-word;text-wrap:normal;' class='left'>".substr($dr["description"],0,100)."....</td>".
						"</tr>";
 				$i++;$j++; 
 			}
			$result .="</tbody></table>";
			echo $result;
			//$this->STATEMENT = $sql;
			//$this->pagingLayoutList($current_record,""); 
		}

		function Gettrack_id(){ 
			global $db;
			$result = "";
			$sql = "select max(track_id) as autonumber from tracks";
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