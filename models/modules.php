<?php
	
	class modules extends Paging{
	

		var $module_id;
		var $module_name;
		var $active;
		var $form_name;
		function GetmodulesInfoBymodule_id($obj){
			global $db;
			$sql = "select top(1)* from modules where module_id = '".$obj->module_id."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetmodulesInfoBymodule_name($obj){
			global $db;
			$sql = "select top(1)* from modules where module_name = '".$obj->module_name."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetmodulesInfoByactive($obj){
			global $db;
			$sql = "select top(1)* from modules where active = '".$obj->active."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}

		function GetmodulesInfoByform_name($key){
			global $db;
			$sql = "select top(1)* from modules where form_name = '".$key."'  ";
			$dr = $db->Execute($sql); 
			return $this->ReadData($dr);
		}


		function ReadData($dr){
		

			 while($rs = $dr->FetchRow()){
				$this->module_id = $rs["module_id"];
				$this->module_name = $rs["module_name"];
				$this->active = $rs["active"];
				$this->form_name = $rs["form_name"];
			}
			return $this;
		}


		function Update($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE modules " .
 						"SET " . 
 						"module_name = '".$objInfo->module_name."'," . 
						"active= '".$objInfo->active."'," . 
						"form_name= '".$objInfo->form_name."'" .
						" WHERE module_id = $objInfo->module_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}


		function Insert($objInfo){ 
		
			global $db;
			$detector = false;
			$sql = "INSERT INTO modules" .
						"(module_name," . 
							"active," . 
							"form_name)" . 
						" VALUES" . 
						"(	'".$objInfo->module_name."'," . 
							"'".$objInfo->active."'," . 
							"'".$objInfo->form_name."')";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}


		function Delete($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = "DELETE FROM modules WHERE module_id='".$objInfo->module_id."' ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}


		function GetmodulesList($current_record,$q){
		
			global $db;
			
			$result = '';

			$sql = "SELECT * FROM(SELECT ROW_NUMBER() OVER(ORDER BY module_name) as ROW_NUMBER,module_id,module_name,form_name,[active] FROM modules)
		   as A	WHERE ROW_NUMBER between $current_record and ".($this->RECORD+$current_record)." ORDER BY ROW_NUMBER
			";
			
				$search = "SELECT count(*) ROW_NUMBER FROM modules";
			
			if($q != ""){
			$sql = "SELECT * FROM(SELECT ROW_NUMBER() OVER(ORDER BY module_name) as ROW_NUMBER,module_id,replace(module_name,'$q','<strong>$q</strong>') as module_name,replace(form_name,'$q','<strong>$q</strong>') as form_name,[active]  FROM modules where module_name+form_name like '%$q%')
		as A	WHERE ROW_NUMBER between $current_record and ".($this->RECORD+$current_record)." ORDER BY ROW_NUMBER ";
			
			$sql = "SELECT count(*) ROW_NUMBER  FROM modules where module_name+form_name like '%$q%' ";
			
			}
			$rs = $db->Execute($sql);
			
			$dt = $db->Execute($search);
			$rowCount = $dt->FetchRow();
			$this->ROWS = $rowCount["ROW_NUMBER"];
			
			$result .="<table border='1' cellspacing='0' cellpadding='3' id='tz-table' align='center'>".
						"<thead height='30'><tr><th><input type='checkbox' name='toggle' onclick='checkAll(this.checked,\"module_group\");' /></th>".
							"<th>". ucwords(str_replace("_"," ","No"))."</th>".
							"<th>". ucwords(str_replace("_"," ","module_name"))."</th>".							
							"<th>". ucwords(str_replace("_"," ","Key"))."</th>"."<th>". ucwords(str_replace("_"," ","Deactivate"))."</th></tr></thead><tbody>"; 
			$i=1;$j=0;$k=$current_record+1;
			while($dr = $rs->FetchRow()){ 
				
				$result .="<tr class='rowhover'>".
						"<td class='center'><input type='checkbox' id='cb".$j."' name='module_group' value='".$dr["module_id"]."' onclick=\"isChecked(this.checked,'".$dr["module_id"]."');\" /></td>".
							"<td>".$k."</td>".
							"<td class='left'>".$dr["module_name"]."</td>";
				$result.="<td class='left'>".$dr["form_name"]."</td>";
				if($dr["active"]==1){
				$result.="<td style='text-align:center'><input type='checkbox' value='' onclick=\"click_check(".$dr["module_id"].",this);\" checked /></td>";
				}
				else{
				$result.="<td style='text-align:center'><input type='checkbox' value='' onclick=\"click_check(".$dr["module_id"].",this);\" /></td>";
				}	
							
			$result.="</tr>";
 				$i++;$j++;$k++; 
 			}
			$result .="</tbody></table>";
			echo $result;
			$this->pagingLayout($current_record,$q);
		}
		
		function Getmodule_id(){ 
			global $db;
			$result = "";
			$sql = "select max(module_id) as autonumber from modules";
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
