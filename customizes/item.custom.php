<?php
	class item_custom extends item{
		
		function __contract(){}
		
		function update_is_inactive($objInfo){
		
			global $db;
			$detector = false;
			
			$sql = " UPDATE `item` " .
 						"SET " . 
 						"`is_inactive`= '".$objInfo->is_inactive."'" . 
						" WHERE item_id = '".$objInfo->item_id ."'";
 			if($db->Execute($sql)){
				$detector = true;
			}
			return $detector;
		}
		
		function GetItemCombo($item_id){
			
			$str_option = "<option value='0'></option>";
			
			$rs = $this->getAllItems();
			
			while($dr = $rs->FetchRow()){
				if($dr["item_id"] == $item_id){
					$str_option .= "<option value='".$dr["item_id"]."' selected>".$dr["item_description_en"]."-".$dr["price_kh"]."</option>";
				}else{
					$str_option .= "<option value='".$dr["item_id"]."'>".$dr["item_description_en"]."-".$dr["price_kh"]."</option>";
				}
			}
			return $str_option;
		}
			
	}
?>