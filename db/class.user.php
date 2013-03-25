<?php

	include_once("class.user_ado_old.php");
	
	class User extends UserADO
	{
		# treluser_group variable
		var $TRUG_ID;
		var $GROUP_ID;
		//var $USER_ID;

		function GetUserBySTATUS_ID($sel)
		{
			global $db;
			$strsql="select * from tbluser where STATUS_ID =".$sel;
			$result=$db->Execute($strsql);	
			
			while($row=$result->FetchRow())
			{					 
				echo '<option value="'.$row["USER_ID"].'">'.$row["USER_NAME"]."</option>"; 					
			}
		}
		
		function getJobTitleNameByJTID($job_title_id)
		{
			global $db;
			$strsql="
					SELECT UG.GROUP_NAME 
					FROM tbluser U INNER JOIN 
						 treluser_group TRUG ON U.USER_ID = TRUG.USER_ID INNER JOIN 
						 tbluser_group UG ON TRUG.GROUP_ID = UG.GROUP_ID 
					WHERE U.USER_ID = $id
					ORDER BY TRUG.TRUG_ID
			";
			
			$strsql="
					SELECT JT.JOB_TITLE FROM tlkpjob_title JT
					WHERE JT.JOB_ID = $job_title_id
			";
			$result=$db->Execute($strsql);	
			
			while($row=$result->FetchRow())
			{					 
				return $row[0];			
			}			
		}
		
		function GetJobTitleForLookup()
		{
			global $db;
			$strsql="SELECT J.JOB_ID, J.JOB_TITLE FROM tlkpjob_title J ORDER BY J.JOB_TITLE";
	
			$result=$db->Execute($strsql);	
			
			$i = 1;
			$num_rec = $result->RecordCount();
			while($row=$result->FetchRow())
			{
				if($i<=$num_rec-1)
				{		
					echo "['".$row["JOB_ID"]."', '".$row["JOB_TITLE"]."'],\n"; 
				}
				if($i==$num_rec)
				{		
					echo "['".$row["JOB_ID"]."', '".$row["JOB_TITLE"]."']"; 
				}
				$i++;
			}
		}
		
		function validateGroupByUserID($u_id, $g_id)
		{
			global $db;
			$sql = "
				SELECT * FROM tbluser U
					INNER JOIN treluser_group UG ON UG.USER_ID = U.USER_ID
				WHERE U.USER_ID = '$u_id'
				AND UG.GROUP_ID IN (".$g_id.")
			";
	
			$result = $db->Execute($sql);	
			
			if($result->RecordCount() > 0){
				return true;
			}
			return false;
		}
	
	}


?>