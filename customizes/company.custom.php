<?php
	class company_custom extends company{
		function Get_Combobox_company(){
			global $db;
			$sql = "select * from company ";
			$dr = $db->Execute($sql); 
			return $dr;
		}	
	}
?>