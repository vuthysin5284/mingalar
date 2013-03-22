<?php 
	/*Code Generator: V.1
	 Developed by Bunthoeurn 
	 Date: 18/07/2012 03:54 */

	class term_condition extends Paging{
	

		var $term_id;
		var $description;
		var $order_no;
		var $term_name;
		var $default;

		 function Getterm_conditionInfoByterm_id($obj){
			 global $db;
			 $sql = "select top(1)* from term_condition where term_id = '".$obj->term_id."' ";
			 $rs = $db->Execute($sql); 
			 return $this->ReadData($rs);
		 }
		 
		 function Getterm_conditionInfoByDefault(){
			 global $db;
			 $sql = "select top(1)* from term_condition where [default] =1 ";
			 $rs = $db->Execute($sql); 
			 return $this->ReadData($rs);
		 }
		 
		 function ReadData($rs){
			 while($dr = $rs->FetchRow()){
				$this->term_id = $dr["term_id"];
				$this->description = $dr["description"];
				$this->term_name = $dr["term_name"];
				$this->order_no = $dr["order_no"];
				$this->default = $dr["default"];
			 }
			 return $this;
		 } 

		 function Update($objInfo){
			 global $db;
			 $detector = false;
			 $sql = " UPDATE [term_condition] " .
 						 "SET " . 
 						"[description] = '".$objInfo->description."', " .
						"[term_name] = '".$objInfo->term_name."', " .
						"[default] = '".$objInfo->default."', " .
						"[order_no] = '".$objInfo->order_no."' " .
						 " WHERE [term_id] = '".$objInfo->term_id."' ";
 			 if($db->Execute($sql)){
				 $detector = true;
			 }
			 return $detector;
		 } 
		 function SetState(){
			 global $db;
			 $detector = false;
			 $sql = " UPDATE [term_condition] " .
				 " SET [default] = 0 " ;
			 if($db->Execute($sql)){ 
				 $detector = true; 
			 }
			 return $detector; 
		}
		 function Insert($objInfo){ 
			 global $db;
			 $detector = false;
			 $sql = "INSERT INTO term_condition" .
				 "(".
					"[description],".
					"[term_name],".
					"[order_no],".
					"[default]".
					 ")".
				 " VALUES( '".$objInfo->description."','".$objInfo->term_name."','".$objInfo->order_no."' ,'".$objInfo->default."')";
			 if($db->Execute($sql)){
				 $detector = true;
			 }
			 return $detector;
		 }

		function Delete($objInfo){ 
 		
			global $db;
			$detector = false;
			$sql = "DELETE FROM [term_condition] WHERE [term_id]= '".$objInfo->term_id."'  ";
			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}

		 function Getterm_conditionList($current_record){ 
			 global $db;  
			
			 $result = ""; 
			 $sql = "SELECT * FROM [term_condition] order by [order_no] "; 
			 $rs = $db->Execute($sql);
			 
			 $result .=  "<table border='1' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center' id='tz-table'>".
				 "<thead height='30'><tr><th><input type='checkbox' id='checkall' name='checkall' onchange='checkAll(this.checked,\"term_group\")'></th><th>#</th>".
				 "<th>Term Name</th>".
				 "<th>description</th><th>Action</th></tr></thead><tbody>";
			 $i=$current_record+1;$j=0;
			 
			 while($dr = $rs->FetchRow()){
				 $result .="<tr class='rowhover' id='".$dr["term_id"]."'>";
				 $result .= "<td class='center'><input type='checkbox' name='term_group' id='cb".$j."' value='".$dr["term_id"]."' onclick='isChecked(this.checked,".$dr["term_id"].");' /></td>";
				 $result .= "<td class='center'>".$dr["order_no"]."</td>";
				 $result .="<td class='center'>".$dr["term_name"]."</td>";
				 $result .="<td class='left'>". html_entity_decode( $dr["description"])."</td>";
 				 $result .="<td style='text-align:center'><a href='javascript:gotoEdit(".$dr["term_id"].")'>Edit</a></td></tr>";
				 $i++; 
				 $j++; 
			 } 
 			 $result .= "</tbody></table>";
			 echo $result; 
			 /*$this->STATEMENT = $sql;
			 $this->pagingLayoutList($current_record,"");*/ 
		 }
		 function Getterm_id(){ 
			 global $db;
			 $result = "";
			 $sql = "select max(term_id) as autonumber from term_condition";
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
