<?php
	/*
		+ ************************************************************************************** +	
		*																																												 *
		* This code is not to be distributed without the written permission of BRC Technology.   *
		* Copyright © 2006 <a href="http://www.brc-tech.com" target="_blank">BRC Technology</a>  *
		* 																																											 *
		+ ************************************************************************************** +
	*/
	
	/**
	 *	@Project: Wise Biller	
	 *	@File:		security.php	
	 *	
	 *	@Author: Chea vey	 
	 *
	 */
	//require_once("agent_ado.php");
	//require_once("sendmail.php");
	
	/*
		Purpose: 	Security
		Date:		15 Jul 2008
		Author:		Mongkol
	*/
	include_once("agent_ado.php");
	include_once("functions.php");
	
	class Security{
			
		/*
			Variables
		*/
		var $salt;
		var $addUser;
		var $updateUser;
		var $getGroupList;
		var $getPageList;
		var $addGroup;
		var $updateGroup;		
		
		var $group_name;	
		var $page_id;
		
		var $user_id;
		var $cust_id;
		var $user_name;
		var $full_name; 
		var $password;
		var $description;
		var $email; 
		var $phone; 
		var $status_id;
		var $created_by;
		var $user_group; 
		
		/*
			Variables for group user
		*/
		var $group_id;
		/*
			End variables for group user
		*/
		
		
		function Security()
		{			
			$this->salt="";
			$this->addUser=1;
			$this->getGroupList=2;
			$this->updateUser=3;
			$this->getPageList=4;
			$this->addGroup=5;
			$this->updateGroup=6;
			
			/// LOOK UP
			$this->after_booking=1; // booking list not yet check in, it is still wait for check in while all booking can delete from lists
			$this->check_in=2; // booking are agree came to stay and decided to stay, and can delete from list all so.
			$this->checked_in=3; // check in when customer come to stay and payment room value and checking roomtype, floor.
			$this->check_out=4; // check out when customer leave and pay all remain payment.
			$this->check_out_for_continue=5; // check out for continue, mean that the same customer continue stay in for more days
			$this->cancel_check_in=6;// cancel check in when booking register stomer not and that custay
			$this->delete_booking=7; // deleted customer booking when customer not came
			
		}
		
		/*
			Purpose: 	Password Encryption 
			Date:		15 Jul 2008
			Author:		Mongkol
		*/		
		function pwdEncrypt($strPwd)
		{
			$strPwd=$this->myEncryption($strPwd,$this->salt);
			return $strPwd;
		}
		
		/*
			Purpose: 	General Encryption
			Date:		15 Jul 2008
			Author:		Mongkol
		*/
		function myEncryption($str,$salt)
		{
			$str = md5(sha1($str.$salt));
			$str = sha1(md5($str.$salt));
			return $str;
		}
		
		/*
			Purpose: 	Check is Page Allowed
			Date:		15 Jul 2008
			Author:		Mongkol
		*/
		function isPageAllowed($group_id,$pg_id)
		{		
			$isAllowed=0;	
			global $db;			
			$sql="				
					SELECT * FROM TRELPAGE_GROUP WHERE GROUP_ID in ($group_id) AND PG_ID=$pg_id
				";
			$result=$db->Execute($sql);	
			$rowCount = $result->RecordCount();
			
			if($rowCount<=0)
				echo "<script>window.location.replace('login.htm');</script>";
		}
		/*
			Purpose: 	Check is Customer Login Page Permission
			Date:		15 Jul 2008
			Author:		Mongkol
		*/
		function isCustPageAllowed($u_name,$cust_id)
		{		
			if(empty($u_name) || empty($cust_id))
			{
				echo "<script>window.location.replace('login.htm');</script>";
			}			
		}
		
		//Public Method check user exist
		function isExist($user_name)
		{		
			$isExist=0;	
			global $db;		
			$sql="				
					SELECT * from puser
					where user_name='".$user_name."'
					and active=1
				";			
			$sql = $db->Prepare($sql);
			$result=$db->Execute($sql);	
			$rowCount = $result->RecordCount();
			
			if($rowCount>0)
				$isExist=1;
			else
				$isExist=0;
			
			return $isExist;
		}
		
		//Public Method check user exist
		function getFullName($objSecurity)
		{		
			$isExist=0;	
			global $db;			
			$sql="				
					SELECT FULL_NAME FROM puser WHERE USER_ID=:0
				";			
			$sql = $db->Prepare($sql);
			$db->Bind($sql, $objSecurity->user_id);			
			
			$result=$db->Execute($sql);				
			$row=$result->GetRows(1);			
			return $row[0]["FULL_NAME"];			
		}
		
		//Public Method check user exist
		function isValidCustUser($objSecurity)
		{		
			$isExist=0;	
			global $db;			
			$sql="				
					SELECT USER_ID,USER_NAME FROM puser
					WHERE USER_NAME=? AND PASSWORD=? 
					AND ACTIVE=1
				";			
			$sql = $db->Prepare($sql); 
			
			$result=$db->Execute($sql,array($objSecurity->user_name,$objSecurity->password));	
				
			if($result)
			{
				$rowCount = $result->RecordCount();			
				$row=$result->GetRows(1);			
				$this->u_name=$row[0]["USER_NAME"];	
				$this->user_id=$row[0]["USER_ID"]; 
			  	$this->group_id=$this->getUserGroup($this);	
							
				if($rowCount>0)
					$isExist=1;
				else
					$isExist=0;
			}
			return $isExist;
		}
		//Public Method check user exist
		function isUserExist($objSecurity)
		{		
			$isExist=0;	
			global $db;	 
			$sql="				
					
					select * from puser where user_name=? ;
				";
				/*select * from tbluser where user_name=? and user_id not in (?)*/			
			$sqlsm = $db->Prepare($sql); 
			
			//$result=$db->Execute($sqlsm, array($objSecurity->user_name, $objSecurity->user_id));
			
			/* vuthy modify */	
			$result=$db->Execute($sqlsm, array($objSecurity->user_name));
			$rowCount = $result->RecordCount();
			
			if($rowCount>0)
				$isExist=1;
			else
				$isExist=0;
			
			return $isExist;
		}
		function getUserGroup($objSecurity)
		{				
			global $db; 
			$group_id="";		
			$sql="				
					SELECT GROUP_ID FROM PTUSER_GROUP WHERE USER_ID=?
				";			
			$sql = $db->Prepare($sql);			
			//$db->Bind($sql, $objSecurity->user_id); 
			
			$result=$db->Execute($sql,array($objSecurity->user_id));	
			while($row=$result->FetchRow())
			{				
				$group_id.=$row["GROUP_ID"].",";
			}
			if(strlen($group_id)>0)
				$group_id=substr($group_id,0,strrpos($group_id,","));
			else
				$group_id="0";
				
			return $group_id;
		}
		
		//Public Method check group exist
		function isGroupExist($objSecurity)
		{		
			$isExist=0;	
			global $db;			
			$sql="				
					SELECT * FROM puser_GROUP WHERE GROUP_NAME=? AND GROUP_ID NOT IN (?)
					
				";
							
			$sql = $db->Prepare($sql); 
			
			$result=$db->Execute($sql,array($objSecurity->group_name,$objSecurity->group_id));	
			$rowCount = $result->RecordCount();
			
			if($rowCount>0)
				$isExist=1;
			else
				$isExist=0;
			
			return $isExist;
		}
		
		function getDataSet($objSecurity)
		{
			$strResult="";
			$strResult= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
					<ItemSearchResponse xmlns=\"http://webservices.amazon.com/AWSECommerceService/2006-06-28\">";
			$strResult.=$this->getUserInfo($objSecurity);
			$strResult.=$this->getUserGroupList($objSecurity);
			$strResult.="</ItemSearchResponse>";
			return $strResult;
		}
		
		//Get Page Dataset
		function getGroupPageDataSet($objSecurity)
		{
			$strResult="";
			$strResult= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
					<ItemSearchResponse xmlns=\"http://webservices.amazon.com/AWSECommerceService/2006-06-28\">";
			$strResult.=$this->getGroupInfo($objSecurity);
			$strResult.=$this->getPageList($objSecurity);
			$strResult.="</ItemSearchResponse>";
			return $strResult;
		}
		
		
		function getUserGroupList($objSecurity)
		{
			$strResult="";
			global $db;			
			$sql="				
					SELECT TUG.GROUP_ID, TUG.GROUP_NAME, TUG.DESCRIPTION,case when NVL(TRUG.USER_ID,0)=0 then 'false' else 'true' end STATUS_ID 
					FROM puser_GROUP TUG
					LEFT OUTER JOIN ptUSER_GROUP TRUG ON TRUG.GROUP_ID= TUG.GROUP_ID AND TRUG.USER_ID=:0
				";			
			$sql = $db->Prepare($sql);
			$db->Bind($sql, $objSecurity->user_id);
			$result=$db->Execute($sql);		
			
			if($result)
			{
				$numCol=$result->FieldCount();
				while($row=$result->FetchRow())
				{				
					$strResult.= "<RECORD>";
					for($i=0;$i<$numCol;$i++)
					{					
						$field=$result->FetchField($i);
						$strResult.= "<".$field->name.">".$row[$i]."</".$field->name.">";
					}	
					$strResult.= "</RECORD>";
				}
			}
			return $strResult;
		}
		
		
		function getUserInfo($objSecurity)
		{
			$strResult="";
			global $db;			
			$sql="				
					SELECT USER_ID,USER_NAME, FULL_NAME, PASSWORD, DESCRIPTION, EMAIL, PHONE, STATUS_ID FROM puser WHERE USER_ID=:0
				";
			$sql = $db->Prepare($sql);
			$db->Bind($sql, $objSecurity->user_id);
			
			$result=$db->Execute($sql);	
			if($result)
			{
				$numCol=$result->FieldCount();
				while($row=$result->FetchRow())
				{				
					$strResult .= "<USER_RECORD>";
					for($i=0;$i<$numCol;$i++)
					{					
						$field=$result->FetchField($i);
						$strResult.= "<".$field->name.">".$row[$i]."</".$field->name.">";
					}	
					$strResult.= "</USER_RECORD>";
				}
			}
			return $strResult;
		}
		
		
		function getGroupInfo($objSecurity)
		{
			$strResult="";
			global $db;			
			$sql="				
					SELECT GROUP_ID, GROUP_NAME, DESCRIPTION, STATUS_ID FROM puser_GROUP WHERE GROUP_ID=:0
				";
			$sql = $db->Prepare($sql);
			$db->Bind($sql, $objSecurity->group_id);
			
			$result=$db->Execute($sql);	
			if($result)
			{
				$numCol=$result->FieldCount();
				while($row=$result->FetchRow())
				{				
					$strResult .= "<GROUP_RECORD>";
					for($i=0;$i<$numCol;$i++)
					{					
						$field=$result->FetchField($i);
						$strResult.= "<".$field->name.">".$row[$i]."</".$field->name.">";
					}	
					$strResult.= "</GROUP_RECORD>";
				}
			}
			return $strResult;
		}
		
		
		function getPageList($objSecurity)
		{
			$strResult="";
			global $db;			
			$sql="				
					SELECT P.P_ID, P.PAGE_NAME, P.DESCRIPTION,case when NVL(PG.GROUP_ID,0)=0 then 'false' else 'true' end STATUS_ID
					FROM TBLPAGE P
					LEFT OUTER JOIN TRELPAGE_GROUP PG ON PG.PG_ID=P.P_ID AND PG.GROUP_ID=:0
				";			
			$sql = $db->Prepare($sql);
			$db->Bind($sql, $objSecurity->group_id);
			$result=$db->Execute($sql);		
			
			if($result)
			{
				$numCol=$result->FieldCount();
				while($row=$result->FetchRow())
				{				
					$strResult.= "<PAGE_RECORD>";
					for($i=0;$i<$numCol;$i++)
					{					
						$field=$result->FetchField($i);
						$strResult.= "<".$field->name.">".$row[$i]."</".$field->name.">";
					}	
					$strResult.= "</PAGE_RECORD>";
				}
			}
			return $strResult;
		}
		
		//Pulbic Method Create new user
		function createNewUser($objSecurity)
		{
			global $db; 
			try
			{		
				$db->StartTrans();			
				$objSecurity->user_id= $this->createUser($objSecurity);	 
				$this->groupUserMinipulate($objSecurity);
				$db->CompleteTrans();
				$msg="User ".$objSecurity->user_name." has been created successfully.";
			}
			catch(Exception $e)
			{
				$msg="Unexpected error while trying to create user ".$objSecurity->user_name.".\r\n".$e->getMessage();
			}
			return $msg;
		}
		
		//Pulbic Method Create new group user
		function createNewGroup($objSecurity)
		{
			global $db; 
			try
			{		
				$db->StartTrans();
				$objSecurity->group_id= $this->createGroup($objSecurity);				
				$this->pageMinipulate($objSecurity);
				$db->CompleteTrans();
				$msg="Group ".$objSecurity->group_name." has been created successfully.";
			}
			catch(Exception $e)
			{
				$msg="Unexpected error while trying to create group ".$objSecurity->group_name.".\r\n".$e->getMessage();
			}
			return $msg;
		}
		
		function getNextUserId()
		{			
			$strResult="";
			global $db;			
			/*$sql="				
					SELECT SEQ_USER_ID.NEXTVAL USER_ID FROM DUAL 
				";
			$sql = $db->Prepare($sql);			
			$result=$db->Execute($sql);		
			//$row=$result->GetRows();
			$strResult = $row[0]["USER_ID"];*/
			
			return $strResult;
		}		
		
		
		function getNextGroupId()
		{			
			$strResult="";
			global $db;			
			//$sql="";//$sql="SELECT SEQ_SP_GROUP_ID.NEXTVAL GROUP_ID FROM DUAL  ";
			//$sql = $db->Prepare($sql);			
			//$result=$db->Execute($sql);		
			//$row=$result->GetRows();
			//$strResult = $row[0]["GROUP_ID"];
			
			return $strResult;
		}
		
		//Private Method create user support public method
		function createUser($objSecurity)
		{			
			//$objSecurity->password=$this->pwdEncrypt($objSecurity->password);
			global $db;	
			$sql="					
					INSERT INTO puser(USER_ID, USER_NAME, FULL_NAME, PASSWORD, DESCRIPTION, EMAIL, PHONE, STATUS_ID, CREATED_DATE, CREATED_BY)
					VALUES(?,?,?,?,?,?,?,?,now(),?)					
				";
			$sql = $db->Prepare($sql); 
			$db->Execute($sql,array(			
						$objSecurity->user_id,
						$objSecurity->user_name,			
						$objSecurity->full_name,
						$objSecurity->password,
						$objSecurity->description,
						$objSecurity->email,
						$objSecurity->phone,
						$objSecurity->status_id,
						$objSecurity->created_by
												
			));
			
			return mysql_insert_id();
		}
		
		
		//Private Method create group user support public method
		function createGroup($objSecurity)
		{			
			$objSecurity->password=$this->pwdEncrypt($objSecurity->password);
			global $db;	
			$sql="					
					INSERT INTO puser_GROUP(GROUP_NAME,DESCRIPTION,STATUS_ID,CREATED_DATE,CREATED_BY)VALUES(?,?,?,now(),?)					
				";
			$sql = $db->Prepare($sql);		
			$db->Execute($sql,array( 
						$objSecurity->group_name,			
						$objSecurity->description,			
						$objSecurity->status_id,
						$objSecurity->created_by
			));
			return mysql_insert_id();
		}
		
		//Public Method Update Existing User
		function updateExistingUser($objSecurity)
		{		
			$msg="";
			global $db;
			try
			{
				$db->StartTrans();				
				$this->updateUser($objSecurity);
				$this->cleanUpUserGroup($objSecurity);
				$this->groupUserMinipulate($objSecurity);			
				$db->CompleteTrans();
				$msg="User ".$objSecurity->user_name." has been updated successfully.";
			}
			catch(Exception $e)
			{
				$msg="Unexpected error while trying to to update user ".$objSecurity->user_name.".\r\n".$e->getMessage();
			}
			return $msg;
		}
		
		
		//Public Method Update Existing Group
		function updateExistingGroup($objSecurity)
		{		
			$msg="";
			global $db;
			try
			{
				$db->StartTrans();				
				$this->updateGroup($objSecurity);
				$this->cleanUpPageGroup($objSecurity);
				$this->pageMinipulate($objSecurity);			
				$db->CompleteTrans();
				$msg="Group ".$objSecurity->group_name." has been updated successfully.";
			}
			catch(Exception $e)
			{
				$msg="Unexpected error while trying to to update group ".$objSecurity->group_name.".\r\n".$e->getMessage();
			}
			return $msg;
		}
		
		//private method update user
		function updateUser($objSecurity)
		{			
			global $db;	
			if($objSecurity->password=="my_system_password")
			{
			
				$sql="
					UPDATE puser SET USER_NAME=?, FULL_NAME=?, JOB_TITLE=?,
					DESCRIPTION=?, EMAIL=?, PHONE=?, MODIFY_DATE=now(),MODIFY_BY=?,STATUS_ID=? WHERE USER_ID=?
				";
			}
			else
			{
				$sql="
					UPDATE puser SET USER_NAME=?, FULL_NAME=?,JOB_TITLE=?,  
					DESCRIPTION=?, EMAIL=?, PHONE=?, MODIFY_DATE=now(),MODIFY_BY=?,STATUS_ID=? WHERE USER_ID=?
				";
			}
			
			$sql = $db->Prepare($sql); 
			
			//if($objSecurity->password!="my_system_password")
				//$db->Bind($sql, $objSecurity->$this->pwdEncrypt($objSecurity->password));
				  
			$db->Execute($sql,array(
							$objSecurity->user_name,
							$objSecurity->full_name, $objSecurity->job_title,
							$objSecurity->description,
							$objSecurity->email,
							$objSecurity->phone,
							$objSecurity->created_by,
							$objSecurity->status_id,
							$objSecurity->user_id
							
			));			
		}
		
		
		//private method update group
		function updateGroup($objSecurity)
		{			
			global $db;	   
			$sql="
				UPDATE puser_GROUP SET GROUP_NAME=?,DESCRIPTION=?,STATUS_ID=?, MODIFIED_DATE=now(), MODIFIED_BY=?
				WHERE GROUP_ID=?
			";
			
			$sql = $db->Prepare($sql); 
			$db->Execute($sql,array(
									$objSecurity->group_name,
									$objSecurity->description,
									$objSecurity->status_id,
									$objSecurity->created_by, 
									$objSecurity->group_id
									));			
		}
		
		//Private method manipulate group user
		function pageMinipulate($objSecurity)
		{
			$arrPage=split(",",$objSecurity->page_id);
			
			global $db;	
			$sql="
					INSERT INTO ptPAGE_GROUP(PG_ID, GROUP_ID )VALUES(?,?)					
				";
			
			$sql = $db->Prepare($sql);  
			foreach($arrPage as $page)
			{				
				$db->Execute($sql,array($page,$objSecurity->group_id));
			}
		}
		
		//Private method manipulate page
		function groupUserMinipulate($objSecurity)
		{
			$arrGroup=split(",",$objSecurity->user_group);
			
			global $db;	
			$sql="
					INSERT INTO ptUSER_GROUP(GROUP_ID,USER_ID)VALUES(?,?)					
				";
			
			$sql = $db->Prepare($sql);  
			foreach($arrGroup as $group)
			{				
				$db->Execute($sql,array($group,$objSecurity->user_id));
			}
		}
		
		//Clean up user group
		function cleanUpUserGroup($objSecurity)
		{		
			global $db;	
			$sql="
					DELETE from ptUSER_GROUP WHERE USER_ID=?
				";
			$sql = $db->Prepare($sql); 			
			$db->Execute($sql,array($objSecurity->user_id));			
		}
		
		//Clean up page group
		function cleanUpPageGroup($objSecurity)
		{		
			global $db;	
			$sql="
					DELETE from pTPAGE_GROUP WHERE GROUP_ID=?
				";
			$sql = $db->Prepare($sql); 						
			$db->Execute($sql,array($objSecurity->group_id));			
		}
		
		 				
	}// end class
?>