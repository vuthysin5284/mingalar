<?php
class category_custom extends category{
		function Get_Combobox_category(){
			global $db;
			$sql = "select * from category ";
			$dr = $db->Execute($sql); 
			return $dr;
		}	
		
		function update_item_status($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE category " .
 						"SET " . 
 						"item_status= '".$objInfo->item_status."'" .
						" WHERE category = '".$objInfo->category."' ";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
}
?>