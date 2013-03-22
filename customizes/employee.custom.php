<?php
	class employee_custom extends employee{
		function Get_Combobox_employee(){
			global $db;
			$sql = " select * from employee /*e inner join tapping t 
on e.employee_id = t.employee_id order by e.employee_name*/  ";
			$dr = $db->Execute($sql); 
			return $dr;
		}	
		function Get_Combobox_employee_type_clerk(){
			global $db;
			$sql = "select * from employee where position=3";
			$dr = $db->Execute($sql); 
			return $dr;
		}	
	}
?>