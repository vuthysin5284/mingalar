<?php
class shift_custom extends shift{
		function Get_Combobox_shift(){
			global $db;
			$sql = "select * from shift where active = 0 order by `shift`";
			$dr = $db->Execute($sql); 
			return $dr;
		}	
		
		function update_active($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE `shift` " .
 						"SET " . 
 						"`active`= '".$objInfo->active."'" .
						" WHERE shift_id = $objInfo->shift_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
}
?>