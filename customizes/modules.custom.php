<?php
	class modules_custom extends modules{
		function update_active($objInfo){
			global $db;
			$detector = false;
			$sql = " UPDATE [modules] " .
 						"SET " . 
						"[active]= '".$objInfo->active."'" . 
						" WHERE module_id = $objInfo->module_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
	}
?>