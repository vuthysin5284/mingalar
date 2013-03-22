<?php
	class country_custom extends country{
		
		function Get_Combobox_country(){
			global $db;
			$sql = "select * from country c inner join currency cu on cu.country_id = c.country_id and c.inactive = 0 and cu.set_default = 0 ";
			$dr = $db->Execute($sql); 
			return $dr;
		}	
		function update_inactive($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE `country` " .
 						"SET " . 
 						"`inactive`= '".$objInfo->inactive."'" .
						" WHERE country_id = $objInfo->country_id ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
		
		
	}
?>