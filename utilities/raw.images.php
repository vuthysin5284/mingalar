<?php
include_once('../adodb/adodb.inc.php');
include_once("../utilities/db.config.php");
if(isset($_REQUEST['item_id'])){
	global $db;
	$sql = "SELECT item_photo FROM `item` where item_id='".$_REQUEST['item_id']."'";
	$rs = $db->Execute($sql);
	$row = $rs->FetchRow();	
	header('Content-Type: image/png');
	$image_data =  $row["item_photo"];
	echo $image_data;	
}
?>