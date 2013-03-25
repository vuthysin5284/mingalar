<?php

include_once("agent_ado.php");

include_once("functions.php");
 

class UserADO{
	
	/*
	Declaration 
	*/
	
	var $USER_ID;
	var $USER_NAME;
	var $FULL_NAME;
	var $PASSWORD;
	var $DESCRIPTION;
	var $EMAIL;
	var $PHONE;
	var $STATUS_ID;
	var $CREATED_DATE;
	var $CREATED_BY;
	var $MODIFY_DATE;
	var $MODIFY_BY;
	var $JOB_TITLE;
	var $TICKET_USERNAME;
	var $TICKET_PASSWORD;
	
	
	function GetByUsername($uname){
		global $db;
		$strsql="select * from tbluser where user_name = '$uname'";
		$result=$db->Execute($strsql);	

		$objInfo = new UserADO();
		while($row=$result->FetchRow()){
			$objInfo->USER_ID = $row["USER_ID"];
			$objInfo->USER_NAME = $row["USER_NAME"];
			$objInfo->FULL_NAME = $row["FULL_NAME"];
			$objInfo->PASSWORD = $row["PASSWORD"];
			$objInfo->DESCRIPTION = $row["DESCRIPTION"];
			$objInfo->EMAIL = $row["EMAIL"];
			$objInfo->PHONE = $row["PHONE"];
			$objInfo->STATUS_ID = $row["STATUS_ID"];
			$objInfo->CREATED_DATE = $row["CREATED_DATE"];
			$objInfo->CREATED_BY = $row["CREATED_BY"];
			$objInfo->MODIFY_DATE = $row["MODIFY_DATE"];
			$objInfo->MODIFY_BY = $row["MODIFY_BY"];
			$objInfo->JOB_TITLE = $row["JOB_TITLE"];
			$objInfo->TICKET_USERNAME = $row["TICKET_USERNAME"];
			$objInfo->TICKET_PASSWORD = $row["TICKET_PASSWORD"];
		}	
		return $objInfo;
	}

	//Add new
	function Add($obj, &$iserror){
		global $db;
		
		$eff=""; $exp="";
		if($obj->EFFECTIVE_DATE!=""){
			$eff_v = " '$obj->EFFECTIVE_DATE',";
		}else{
			$eff_v = " NULL,";
		}
		
		if($obj->EXPIRY_DATE!=""){
			$exp_v = " '$obj->EXPIRY_DATE',";
		}else{
			$exp_v = " NULL,";
		}
		
		$sql = "
			INSERT INTO tbluser(
				USER_ID, USER_NAME, FULL_NAME, PASSWORD,
				DESCRIPTION, EMAIL, PHONE, STATUS_ID,
				CREATED_DATE, CREATED_BY, MODIFY_DATE, MODIFY_BY,
				JOB_TITLE, TICKET_USERNAME, TICKET_PASSWORD
			)
			VALUES(
				'$obj->USER_ID', '$obj->USER_NAME', '$obj->FULL_NAME', '$obj->PASSWORD',
				'$obj->DESCRIPTION', '$obj->EMAIL', '$obj->PHONE', '$obj->STATUS_ID',
				'$obj->CREATED_DATE', '$obj->CREATED_BY', '$obj->MODIFY_DATE', '$obj->MODIFY_BY',
				'$obj->JOB_TITLE', '$obj->TICKET_USERNAME', '$obj->TICKET_PASSWORD'
			)
		";

		$result=$db->Execute($sql);					
		if($result){
			$iserror=0;
		}else{
			$iserror=1;
		}
	}
	
	function Update($obj, &$iserror){
		global $db;
		
		$eff=""; $exp="";
		if($obj->EFFECTIVE_DATE!=""){
			$eff = " EFFECTIVE_DATE = '$obj->EFFECTIVE_DATE',";
		}else{
			$eff = " EFFECTIVE_DATE = NULL,";
		}
		
		if($obj->EXPIRY_DATE!=""){
			$exp = " EXPIRY_DATE = '$obj->EXPIRY_DATE',";
		}else{
			$exp = " EXPIRY_DATE = NULL,";
		}
		
		$sql = "
			UPDATE tblsubscription_plan SET
				SP_NAME = '$obj->SP_NAME',
				SERVICE_ID = '$obj->SERVICE_ID',
				BILLING_ITEM_ID = '$obj->BILLING_ITEM_ID',
				PERIOD_VALUE = '$obj->PERIOD_VALUE',
				PERIOD_UNIT = '$obj->PERIOD_UNIT',
				IS_POST_PAID = '$obj->IS_POST_PAID',
				IS_BUNDLE = '$obj->IS_BUNDLE',
				DEPOSIT = '$obj->DEPOSIT',
				SECURITY_DEPOSIT = '$obj->SECURITY_DEPOSIT',
				".$eff."
				".$exp."
				IS_VISIBLE = '$obj->IS_VISIBLE',
				INSTALLATION_PROCEDURE_ID = '$obj->INSTALLATION_PROCEDURE_ID'
			WHERE SP_ID = '$obj->SP_ID'
		";

		$result = $db->Execute($sql);					
		if($result){
			$iserror=0;
		}else{
			$iserror=1;
		}
	}
	
	
	function AddSNSBySP_ID($obj, &$iserror){
		global $db;
		
		$sql = "
			INSERT INTO trelservice_network_service(
				SP_ID, NETWORK_SERVICE_ID, NETWORK_SERVICE_VALUE
			)
			VALUES(
				'$obj->SP_ID', '$obj->NETWORK_SERVICE_ID', '$obj->NETWORK_SERVICE_VALUE'
			)
		";

		$result = $db->Execute($sql);					
		if($result){
			$iserror=0;
		}else{
			$iserror=1;
		}
	}
	
	
	function DeleteSNSBySP_ID($obj, &$iserror){
		global $db;
		
		$sql = "
			DELETE FROM trelservice_network_service
			WHERE SP_ID = '$obj->SP_ID'
		";

		$result = $db->Execute($sql);					
		if($result){
			$iserror=0;
		}else{
			$iserror=1;
		}
	}
	
	
	function AddSPAttribute($obj, &$iserror){
		global $db;
		
		$sql = "
			INSERT INTO trelsubscription_attribute
			(
				SP_ID, ATTRIBUTE_TYPE_CODE, ATTRIBUTE_ID
			)
			VALUES
			(
				'$obj->SP_ID', '$obj->ATTRIBUTE_TYPE_CODE', '$obj->ATTRIBUTE_ID'
			)
		";

		$result = $db->Execute($sql);					
		if($result){
			$iserror=0;
		}else{
			$iserror=1;
		}
	}
	
	
	function DeleteSPAttribute($obj, &$iserror){
		global $db;
		
		$sql = "
			DELETE FROM trelsubscription_attribute
			WHERE SP_ID = '$obj->SP_ID'
		";

		$result = $db->Execute($sql);					
		if($result){
			$iserror=0;
		}else{
			$iserror=1;
		}
	}
	
	
	function AddSPGroup($obj, &$iserror){
		global $db;
		
		$sql = "
			INSERT INTO trelsp_group(
				MAIN_SP_ID, SP_ID, ORDERS
			)
			VALUES(
				'$obj->MAIN_SP_ID', '$obj->SP_ID', '$obj->ORDERS'
			)
		";

		$result = $db->Execute($sql);					
		if($result){
			$iserror=0;
		}else{
			$iserror=1;
		}
	}
	
	
	function DeleteSPGroup($obj, &$iserror){
		global $db;
		
		$sql = "
			DELETE FROM trelsp_group
			WHERE MAIN_SP_ID = '$obj->MAIN_SP_ID'
		";

		$result = $db->Execute($sql);					
		if($result){
			$iserror=0;
		}else{
			$iserror=1;
		}
	}
	 function GetBySP_ID($sel){
			global $db;
			$strsql="select * from tblsubscription_plan where SP_ID = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new SP();
			while($row=$result->FetchRow()){
				 
				$obj->SP_ID = $row["SP_ID"]; 
				 
				$obj->SP_NAME = $row["SP_NAME"]; 
				 
				$obj->SERVICE_ID = $row["SERVICE_ID"]; 
				 
				$obj->FEE = $row["FEE"]; 
				 
				$obj->EFFECTIVE_DATE = $row["EFFECTIVE_DATE"]; 
				 
				$obj->EXPIRY_DATE = $row["EXPIRY_DATE"]; 
				 
				$obj->VISIBLE = $row["VISIBLE"]; 
				 
				$obj->IS_POSTPAID = $row["IS_POSTPAID"]; 
				 
				$obj->CYCLE_TYPE_ID = $row["CYCLE_TYPE_ID"]; 
				 
				$obj->NETWORK_SERVICE_ID = $row["NETWORK_SERVICE_ID"]; 
				 
				$obj->IS_PRORATE = $row["IS_PRORATE"]; 
				 
				$obj->DEPOSIT_AMOUNT = $row["DEPOSIT_AMOUNT"]; 
				 
				$obj->REGISTRATION_FEE = $row["REGISTRATION_FEE"]; 
				 
				$obj->CONFIGURATION_FEE = $row["CONFIGURATION_FEE"]; 
				 
				$obj->CPE_DEVICE_PRICE = $row["CPE_DEVICE_PRICE"]; 
				 
				$obj->CPE_TYPE_ID = $row["CPE_TYPE_ID"]; 
				 
				$obj->IS_BUNDLE = $row["IS_BUNDLE"]; 
				 
				$obj->SHOW_OPTION = $row["SHOW_OPTION"]; 
				 
				$obj->MAILBOX = $row["MAILBOX"]; 
				 
				$obj->MAILBOX_QUOTA = $row["MAILBOX_QUOTA"]; 
				 
				$obj->TIMEBAND_ID = $row["TIMEBAND_ID"]; 
				
			}	
			return $obj;
	}	
}

?>