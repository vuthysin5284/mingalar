<?php
	class exchange_custom extends exchange{
		function update_inactive($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE `exchange` " .
 						"SET " . 
 						"`inactive`= '".$objInfo->inactive."'" . 
						" WHERE exchange_id = $objInfo->exchange_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}	
		function update_inactive_zero($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE `exchange` " .
 						"SET " . 
						"`inactive`= '0'" .
						" WHERE exchange_id <> $objInfo->exchange_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		function get_exchange_default(){
			global $db;
			$sql = "select * from exchange where inactive = 1 limit 1 ";
			$dr = $db->Execute($sql);
            return $this->ReadData($dr);
		}
	}
?>