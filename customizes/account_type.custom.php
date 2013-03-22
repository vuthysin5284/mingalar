<?php
	class account_types_custom extends account_type{
		function Get_Combobox_accout_types(){
			global $db;
			$sql = "select * from account_type  ";
			$dr = $db->Execute($sql); 
			return $dr;
		}
		
	}
	
?>