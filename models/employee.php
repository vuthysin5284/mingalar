<?php

	class employee extends Paging{

		var $abbreviation;
		var $employee_id;
		var $seller_name;
		var $position;
		var $department;
		var $tel;
		var $extension;
		var $email;
		var $company_id ;
		
		function GetemployeeInfoByabbreviation($obj){
			global $db;
			$sql = "select * from employee where abbreviation = '".$obj->abbreviation."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetemployeeInfoByemployee_id($obj){
			global $db;
			$sql = "select * from employee where employee_id = '".$obj->employee_id."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetemployeeInfoByseller_name($obj){
			global $db;
			$sql = "select * from employee where seller_name = '".$obj->seller_name."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetemployeeInfoByposition($obj){
			global $db;
			$sql = "select * from employee where position = '".$obj->position."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetemployeeInfoBydepartment($obj){
			global $db;
			$sql = "select * from employee where department = '".$obj->department."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetemployeeInfoBytel($obj){
			global $db;
			$sql = "select * from employee where tel = '".$obj->tel."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetemployeeInfoByextension($obj){
			global $db;
			$sql = "select * from employee where extension = '".$obj->extension."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetemployeeInfoByemail($obj){
			global $db;
			$sql = "select * from employee where email = '".$obj->email."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}
	
		function GetemployeeCombo(){
			global $db;
			$sql = "select * from employee";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
		function GetEmployeeByDepartment($company_id,$department_id){
			global $db;
			$sql = "select * from employee where department = $department_id and company_id = $company_id";
			$rs = $db->Execute($sql); 
			return $rs;
		}
		
		function GetemployeeInfoByUsername($username){
			global $db;
			$sql = "select s.* from user u inner join employee s on u.employee_id = s.employee_id
where u.user_name = '".$username."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function ReadData($dr){
		
			$obj = $this;
			 while($rs = $dr->FetchRow()){
				$obj->abbreviation = $rs["abbreviation"];
				$obj->employee_id = $rs["employee_id"];
				$obj->seller_name = $rs["seller_name"];
				$obj->position = $rs["position"];
				$obj->department = $rs["department"];
				$obj->tel = $rs["tel"];
				$obj->extension = $rs["extension"];
				$obj->email = $rs["email"];
				$obj->company_id = $rs["company_id"];
			}
			return $obj;
		}
		
		function Update($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE employee " .
 						"SET " . 
 						"abbreviation = '".$objInfo->abbreviation."'," . 
						"seller_name= '".$objInfo->seller_name."'," . 
						"position= '".$objInfo->position."'," . 
						"department= '".$objInfo->department."'," . 
						"tel= '".$objInfo->tel."'," . 
						"extension= '".$objInfo->extension."'," . 
						"company_id= '".$objInfo->company_id."'," . 
						"email= '".$objInfo->email."'" .
						" WHERE employee_id = $objInfo->employee_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		function Insert($objInfo){ 
		
			global $db;
			$detector = false;
			$sql = "INSERT INTO employee" .
						"(abbreviation," . 
							"seller_name," . 
							"position," . 
							"department," . 
							"tel," . 
							"extension," . 
							"email,company_id)" . 
						" VALUES" . 
						"(	'".$objInfo->abbreviation."'," . 
							"'".$objInfo->seller_name."'," . 
							"'".$objInfo->position."'," . 
							"'".$objInfo->department."'," . 
							"'".$objInfo->tel."'," . 
							"'".$objInfo->extension."'," . 
							"'".$objInfo->email."','".$objInfo->company_id."')";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		function Delete($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = "DELETE FROM employee WHERE employee_id='".$objInfo->employee_id."' ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		function GetemployeeList($current_record){
		
			global $db;
			$result = "";
			$sql = "SELECT e.*,c.company_name FROM employee e inner join company c on c.company_id = e.company_id";
			$rs = $db->Execute($sql ." order by e.abbreviation limit $current_record,".$this->RECORD."");
			
			$result .="<table border='1' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center' id='tz-table'>".
						"<thead height='30'><tr><th><input type='checkbox' name='toggle' onclick='checkAll(this.checked,\"employee_group\");' /></th>".
							"<th>No</th>".
							"<th>Abbreviation</th>".
							"<th>Seller Name</th>".
							"<th>Position</th>".
							"<th>Comopany</th>".
							"<th>Department</th>".
							"<th>Tel</th>".
							"<th>Extension</th>".
							"<th>Email</th>".
							"<th>Action</th>".
						"</tr></thead>"; 
			$i=1;$j=0;
			while($dr = $rs->FetchRow()){ 
					
				$result .="<tr class='rowhover'>".
						"<td class='center'><input type='checkbox' id='cb".$j."' name='employee_group' value='".$dr["employee_id"]."' onclick=\"isChecked(this.checked,'".$dr["employee_id"]."');\" /></td>".
							"<td>".$i."</td>".
							"<td>".$dr["abbreviation"]."</td>".
							"<td>".$dr["seller_name"]."</td>".
							"<td>".$dr["position"]."</td>".
							"<td>".$dr["company_name"]."</td>".
							"<td>".$dr["department"]."</td>".
							"<td>".$dr["tel"]."</td>".
							"<td>".$dr["extension"]."</td>".
							"<td>".$dr["email"]."</td>".
			"<td style='text-align:center'><a href='javascript:gotoEdit(\"".$dr["employee_id"]."\")'>Edit</a></td></tr>";
 				$i++;$j++; 
 			}
			$result .="</tbody></table>";
			echo $result;
			$this->STATEMENT = $sql;
			$this->pagingLayoutList($current_record,""); 
		}
		
		function GetemployeeProfile($department){
		
			global $db;
			$result = "<ul id='".$department."'>";
			$sql = "select employee_id, seller_name, abbreviation from employee where lower(department) = lower(?) order by lower(seller_name) ";

			$rs = $db->Execute($sql, array($department));

			$i=1;$j=0;
			while($dr = $rs->FetchRow()){ 
					
				$result .=" <li><a href='javascript:SetEmployeeID(".$dr["employee_id"].",\"".$dr["seller_name"]."\")'><span class='file' id='".$dr["employee_id"]."'>" . $dr["seller_name"]."</span></a></li>";
				
 				$i++;$j++; 
 			}
			return $result."</ul>";
			
		}
		
		function GetDepartmentProfile(){
		
			global $db;
			$result = "";
			$sql_department = "select DISTINCT department from employee where department is not null or department !=' ' order by lower(department) ";
			
			$rs = $db->Execute($sql_department);

			$i=1;$j=0;
			while($dr = $rs->FetchRow()){ 
					
				$result .=" <li><a href='javascript:SetDepartment(\"".$dr["department"]."\")'><span class='folder'>".$dr["department"]."</span></a>";
				$result .= $this->GetemployeeProfile($dr["department"]);
				$result .="</li>";
 				$i++;$j++; 
 			}
			return $result;
			
		}
		
		function GetemployeeSearchList($current_record,$q){
		
			global $db;
			
			$nq = explode(" ",$q);
			$search = "";
			$result = "";
			
			if(count($nq)>0){
			foreach($nq as $v){
				
			$search .="or s.abbreviation like '%$v%' or s.employee_id like '%$v%' or s.seller_name like '%$v%' or s.position like '%$v%' or s.department like '%$v%' or s.tel like '%$v%'  or s.extension like '%$v%'  or s.email like '%$v%' ";
		} }else{
			$search .="or s.abbreviation like '%$q%' or s.employee_id like '%$q%' or s.seller_name like '%$q%' or s.position like '%$q%' or s.department like '%$q%' or s.tel like '%$q%' or s.extension like '%$q%' or s.email like '%$q%' ";				 
		}
			
			$sql = "SELECT * FROM(SELECT ROW_NUMBER() OVER(ORDER BY s.employee_id) as ROW_NUMBER,replace(s.abbreviation,'$q','<strong>$q</strong>') as abbreviation ,s.employee_id,replace(s.seller_name,'$q','<strong>$q</strong>') as seller_name ,replace(s.position,'$q','<strong>$q</strong>') as position ,replace(p.profile_name,'$q','<strong>$q</strong>') as department ,replace(s.tel,'$q','<strong>$q</strong>') as tel ,replace(s.extension,'$q','<strong>$q</strong>') as extension ,replace(s.email,'$q','<strong>$q</strong>') as email, c.company_name FROM employee s inner join company c on c.company_id = s.company_id inner join profiles p on p.profile_id = s.department where ".substr($search,3,strlen($search)).")
		   as A	WHERE ROW_NUMBER between $current_record and ".($this->RECORD+$current_record)." ORDER BY ROW_NUMBER ";
 
			$rs = $db->Execute($sql);
			
			$search = "SELECT count(*) ROW_NUMBER FROM employee s where ".substr($search,3,strlen($search))."";
			
			$dt = $db->Execute($search);
			$rowCount = $dt->FetchRow();
			$this->ROWS = $rowCount["ROW_NUMBER"];
			
			
			$result .="<table border='1' id='tz-table' cellpadding=3 style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center'>".
						"<thead height='30'><tr><th><input type='checkbox' name='toggle' onclick='checkAll(this.checked,\"employee_group\");' /></th>".
							"<th>No</th>".
							"<th>Abbreviation</th>".
							"<th>Employee Name</th>".
							"<th>Position</th>".
							"<th>Company</th>".
							"<th>Department</th>".
							"<th>Tel</th>".
							"<th>Extension/ID</th>".
							"<th>Email</th>".
							"<th>Action</th>".
						"</tr></thead>"; 
			$i=1;$j=0;
			while($dr = $rs->FetchRow()){ 
					
				$result .="<tr class='rowhover'>".
						"<td class='center'><input type='checkbox' id='cb".$j."' name='employee_group' value='".$dr["employee_id"]."' onclick=\"isChecked(this.checked,'".$dr["employee_id"]."');\" /></td>".
							"<td>".$i."</td>".
							"<td>".$dr["abbreviation"]."</td>".
							"<td class='left'>".$dr["seller_name"]."</td>".
							"<td class='left'>".$dr["position"]."</td>".
							"<td class='left'>".$dr["company_name"]."</td>".
							"<td class='left'>".$dr["department"]."</td>".
							"<td class='left'>".$dr["tel"]."</td>".
							"<td class='left'>".$dr["extension"]."</td>".
							"<td class='left'>".$dr["email"]."</td>".
			"<td style='text-align:center'><a href='javascript:gotoEdit(\"".$dr["employee_id"]."\")'>Edit</a></td></tr>";
 				$i++;$j++; 
 			}
			$result .="</tbody></table>";
			echo $result;
			
			$this->pagingLayout($current_record,$q); 
			
		}

		function Getemployee_id(){ 
			global $db;
			$result = "";
			$sql = "select max(employee_id) as autonumber from employee";
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