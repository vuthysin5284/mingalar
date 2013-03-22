<?php
class convertor_custom extends convertor{
		function update_active($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE `convertor` " .
 						"SET " . 
 						"`active`= '".$objInfo->active."'" . 
						" WHERE convertor_id = $objInfo->convertor_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
}
?>