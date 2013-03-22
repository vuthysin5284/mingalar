<?php  class vendor_custom extends vendor{  
			function Get_Combobox_vendor(){   
				global $db;   
				$sql = "select * from vendor";   
				$dr = $db->Execute($sql);    
				return $dr;  
			}  
	}
?>