<?php

include_once("agent_ado.php");
include_once("functions.php");
 

class UserADO
{
	
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
	
	/* 
		Get UserADO By ID		
	*/	
	
	function UserADO($pUSER_ID="", $pUSER_NAME="", $pFULL_NAME="", $pPASSWORD="", $pDESCRIPTION="", $pEMAIL="", $pPHONE="", $pSTATUS_ID="", $pCREATED_DATE="", $pCREATED_BY="", $pMODIFY_DATE="", $pMODIFY_BY=""){
		 
		$this->USER_ID = $pUSER_ID;
		 
		$this->USER_NAME = $pUSER_NAME;
		 
		$this->FULL_NAME = $pFULL_NAME;
		 
		$this->PASSWORD = $pPASSWORD;
		 
		$this->DESCRIPTION = $pDESCRIPTION;
		 
		$this->EMAIL = $pEMAIL;
		 
		$this->PHONE = $pPHONE;
		 
		$this->STATUS_ID = $pSTATUS_ID;
		 
		$this->CREATED_DATE = $pCREATED_DATE;
		 
		$this->CREATED_BY = $pCREATED_BY;
		 
		$this->MODIFY_DATE = $pMODIFY_DATE;
		 
		$this->MODIFY_BY = $pMODIFY_BY;
		
	}
	
	
	function GetByUSER_ID($sel){
			global $db;
			$strsql="select * from tbluser where USER_ID='$sel'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
				$obj->JOB_TITLE = $row["JOB_TITLE"]; 
				
			}	
			return $obj;
	}		
	
	function GetByUSER_NAME($sel){
			global $db;
			$strsql="select * from tbluser where USER_NAME = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
				$obj->JOB_TITLE = $row["JOB_TITLE"]; 
				
			}	
			return $obj;
	}		
	
	function GetByFULL_NAME($sel){
			global $db;
			$strsql="select * from tbluser where FULL_NAME = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetByPASSWORD($sel){
			global $db;
			$strsql="select * from tbluser where PASSWORD = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 

				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetByDESCRIPTION($sel){
			global $db;
			$strsql="select * from tbluser where DESCRIPTION = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetByEMAIL($sel){
			global $db;
			$strsql="select * from tbluser where EMAIL = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetByPHONE($sel){
			global $db;
			$strsql="select * from tbluser where PHONE = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetBySTATUS_ID($sel){
			global $db;
			$strsql="select * from tbluser where STATUS_ID = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetByCREATED_DATE($sel){
			global $db;
			$strsql="select * from tbluser where CREATED_DATE = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetByCREATED_BY($sel){
			global $db;
			$strsql="select * from tbluser where CREATED_BY = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetByMODIFY_DATE($sel){
			global $db;
			$strsql="select * from tbluser where MODIFY_DATE = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	function GetByMODIFY_BY($sel){
			global $db;
			$strsql="select * from tbluser where MODIFY_BY = '" . $sel."'";
			$result=$db->Execute($strsql);	
	
			$obj=new UserADO();
			while($row=$result->FetchRow()){
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
			}	
			return $obj;
	}		
	
	
	/*
	Check exists
	*/		
	function GetByCondition($con){
			global $db;			
			$strsql="select * from tbluser ";
			if($con!=""){
				$strsql .= "where $con";
			}
			$result=$db->Execute($strsql);	
			$objarr = array();

			while($row=$result->FetchRow()){
				$obj=new UserADO();
				 
				$obj->USER_ID = $row["USER_ID"]; 
				 
				$obj->USER_NAME = $row["USER_NAME"]; 
				 
				$obj->FULL_NAME = $row["FULL_NAME"]; 
				 
				$obj->PASSWORD = $row["PASSWORD"]; 
				 
				$obj->DESCRIPTION = $row["DESCRIPTION"]; 
				 
				$obj->EMAIL = $row["EMAIL"]; 
				 
				$obj->PHONE = $row["PHONE"]; 
				 
				$obj->STATUS_ID = $row["STATUS_ID"]; 
				 
				$obj->CREATED_DATE = $row["CREATED_DATE"]; 
				 
				$obj->CREATED_BY = $row["CREATED_BY"]; 
				 
				$obj->MODIFY_DATE = $row["MODIFY_DATE"]; 
				 
				$obj->MODIFY_BY = $row["MODIFY_BY"]; 
				
				$objarr[] = $obj;
			}	
			return $objarr;
	}		

	
	/*
	Check exists
	*/
	function Exists($obj, $isUpdate, &$resultmessage, &$iserror){
		global $db;
		$sql="select * from tbluser where upper(USER_NAME) = upper('$obj->USER_NAME')";
		if($isUpdate==1){
			$sql.= " and USER_ID <> '$obj->USER_ID'";
		}
		
		$result=$db->Execute($sql);
		if($result->RecordCount() > 0){
			$resultmessage = "UserADO already exists";
			$iserror = 1;
		}else{
			$resultmessage = "UserADO not exists exists";
			$iserror = 0;
		}			
	}
	
	//Add new UserADO
	function Add($obj, &$resultmessage, &$iserror){
		global $db;
		$resultmessage="";
		$result=0;						
/*		$this->Exists($obj, 0, &$resultmessage, &$iserror);
		
		if($iserror==1){
			return;
		}
*/		
		
		
		$sql = "INSERT INTO tbluser(USER_ID, USER_NAME, FULL_NAME, PASSWORD, DESCRIPTION, EMAIL, PHONE, STATUS_ID, CREATED_DATE, CREATED_BY, MODIFY_DATE, MODIFY_BY) 
		VALUES (
				 '$obj->USER_ID', 
				 '$obj->USER_NAME', 
				 '$obj->FULL_NAME', 
				 '$obj->PASSWORD', 
				 '$obj->DESCRIPTION', 
				 '$obj->EMAIL', 
				 '$obj->PHONE', 
				 '$obj->STATUS_ID', 
				 TO_DATE('$obj->CREATED_DATE','yyyy-mm-dd') , 
				 '$obj->CREATED_BY', 
				 TO_DATE('$obj->MODIFY_DATE','yyyy-mm-dd') , 
				 '$obj->MODIFY_BY')";

		$result=$db->Execute($sql);					
		if($result){
			$result=0;
			$resultmessage="Successfully adding new UserADO.";			
		}else{
			$result=1;
			$resultmessage="Fail adding new UserADO.";
		}
	}
	
	function Update($obj, &$resultmessage, &$iserror){
		global $db;
		
		$resultmessage="";
		$result=0;		
		
		
			
		$sql = "UPDATE tbluser SET 														
							USER_NAME = '$obj->USER_NAME', 
							FULL_NAME = '$obj->FULL_NAME', 
							PASSWORD = '$obj->PASSWORD', 
							DESCRIPTION = '$obj->DESCRIPTION', 
							EMAIL = '$obj->EMAIL', 
							PHONE = '$obj->PHONE', 
							STATUS_ID = '$obj->STATUS_ID', 
							CREATED_DATE = TO_DATE('$obj->CREATED_DATE','yyyy-mm-dd'), 
							CREATED_BY = '$obj->CREATED_BY', 
							MODIFY_DATE = TO_DATE('$obj->MODIFY_DATE','yyyy-mm-dd'), 
							MODIFY_BY = '$obj->MODIFY_BY'
		WHERE USER_ID = '$obj->USER_ID'"; 
		
		//print $sql;
		$result=$db->Execute($sql);					
		if($result){
			$result=0;
			$resultmessage="Successfully update UserADO";			
		}else{
			$result=1;
			$resultmessage="Fail update UserADO";
		}
	}
	
	
	function Delete($obj, &$resultmessage, &$iserror){
		global $db;
		
		$resultmessage="";
		$result=0;
		
		$this->Exists($obj, 1, &$resultmessage, &$iserror);
		
		if($iserror==1){
			return;
		}
			
		$sql = "DELETE FROM tbluser 
		WHERE  upper(USER_NAME) = upper('$obj->USER_NAME')";
		
		//print $sql;
		$result=$db->Execute($sql);					
		if($result){
			$result=0;
			$resultmessage="Successfully delete UserADO";			
		}else{
			$result=1;
			$resultmessage="Fail delete UserADO";
		}
	}
	
	function Deactivate($obj, &$resultmessage, &$iserror){
		global $db;
		
		$resultmessage="";
		$result=0;		
		
		$this->Exists($obj, 1, &$resultmessage, &$iserror);
		
		if($iserror==1){
			return;
		}		
		
		$sql = "UPDATE tbluser SET Status='0' WHERE  = '$obj->'";
		//print $sql;
		$result=$db->Execute($sql);					
		if($result){
			$result=0;
			$resultmessage="Successfully deactivate UserADO";			
		}else{
			$result=1;
			$resultmessage="Fail deactivate UserADO";
		}
	}
	
	function Activate($obj, &$resultmessage, &$iserror){
		global $db;
		
		$resultmessage="";
		$result=0;		
		
		$this->Exists($obj, 1, &$resultmessage, &$iserror);
		
		if($iserror==1){
			return;
		}		
		
		$sql = "UPDATE tbluser SET Status='1' WHERE  = '$obj->'";
		//print $sql;
		$result=$db->Execute($sql);					
		if($result){
			$result=0;
			$resultmessage="Successfully activate UserADO";			
		}else{
			$result=1;
			$resultmessage="Fail activate UserADO";
		}
	}
	
}

	/*$obj = new UserADO();

	$user = $obj->GetByUSER_ID(281);
	
	print_r($user);*/
?>