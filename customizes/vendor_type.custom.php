<?php  class vendor_type_custom extends vendor_type{  function Get_Combobox_vendor_type(){   global $db;   $sql = "select * from vendor_type where active=0 order by vendor_type";   $dr = $db->Execute($sql);    return $dr;  }   function update_active($objInfo){     global $db;   $detector = false;   $sql = " UPDATE `vendor_type` " .       "SET " .        "`active`= '".$objInfo->active."'" .      " WHERE vendor_type_id = $objInfo->vendor_type_id ";    if($db->Execute($sql)){    $detector = true;   }   return $detector;  }   }?>