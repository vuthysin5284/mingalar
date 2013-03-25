<?php
	include_once("configs.php");
	include_once("agent_ado.php");
	include_once("class.encryptfile.php");
	
	
	/**
	 ** Function for convert html tag
	 **
	 ** Created by: Chea vey
	 ** Created on: 2006 december 27
	 **/	
	function xmlEncode($str){
		$str=str_replace("&","&amp;",$str);
		$str=str_replace("<","&lt;",$str);
		$str=str_replace(">","&gt;",$str);
		return $str;
	}
			
	/**
	 ** Function redirect page
	 **
	 ** Created by: Chea vey
	 ** Created on: 2007 January 10
	 ** 
	 **/
	 	function redirect($url){
			print "<script>window.location='".$url."';</script>";
		}
	 
	/**
	 ** Function for convert Convert datetime
	 **
	 ** Created by: Chea vey
	 ** Created on: 2007 January 10
	 ** 
	 **/	
		function formatDate($strdate = "", $mode){
			
			$date = strtotime($strdate);					
			if(empty($date)) return;
			$sep = "/";
			$com = ",";
			
			# ============ AM/PM ===========
			# am/pm
			$a = date("a", $date);
			# AM/PM
			$A = date("A", $date);
			
			# ============ Second ==========
			# ss (00 - 59)
			$s = date("s", $date);
			
			# ============ Minute ==========
			# mn (00 - 59)
			$i = date("i", $date);
			
			# ============ Hour ============
			# hh (1 - 12)
			$g = date("g", $date);
			# hh (01 - 12)
			$h = date("h", $date);
			# hh (0 - 23)
			$G = date("G", $date);
			# hh (00 - 23)
			$H = date("H", $date);
			
			# ============ Date ============
			# dd (1 - 31)
			$j = date("j", $date);
			# dd (01 - 31)			
			$d = date("d", $date);
			# ddd (mon-sun)
			$D = date("D", $date);
			# dddd (monday - sunday)
			$l = date("l", $date);
			
			# ============ Month ============
			# mm (1 - 12)
			$n = date("n", $date);
			# mm (01 - 12)
			$m = date("m", $date);
			# mmm (jan - dec)
			$M = date("M", $date);
			# mmmm (january - december)
			$F = date("F", $date); 
			
			# ============ year =============
			# yy
			$y = date("y", $date);
			# yyyy
			$Y = date("Y", $date);
			
			switch($mode){
				case 1: # dd/mm/yy (01/01/07)
					$retDate = $d.$sep.$m.$sep.$y;
					break;
				case 2: # dd/mm/yyyy (01/01/2007)
					$retDate = $d.$sep.$m.$sep.$Y;
					break;
				case 3: # dd/mmm/yy (01/jan/07)
					$retDate = $d.$sep.$M.$sep.$y; 
					break;
				case 4: # dd/mmm/yyyy (01/jan/2007)
					$retDate = $d.$sep.$M.$sep.$Y; 
					break;								
				case 5: # yyyymmdd (20070101)
					$retDate = $Y.$m.$d;
					break;
				case 6: #YYYY-mm-dd
					$retDate = $Y."-".$m."-".$d;
					break;
				case 7: #dd mmmm yyyy
					$retDate = $d." ".$F." ".$Y;
					break;
				case 8: #dd mmm yyyy hh:mm:ss
					$retDate = $d." ".$F." ".$Y." ".$H.":".$i.":".$s;
					break;
				case 9: #dd mmm yyyy hh:mm:ss
					$retDate = $d."/".$M."/".$Y." ".$H.":".$i.":".$s;
					break;
					
				case 10: #dd mmm yyyy hh:mm:ss
					$retDate = $d." ".$M." ".$Y." ".$H.":".$i.":".$s; 
					break;
				case 11: #dd mmm yyyy 
					$retDate = $d." ".$M." ".$Y; 
					break;
			} 
			
			return $retDate;
		}
		
		/*
		 * Format currency
		 */
		function FormatCurrency($Amount, $currency = "\$", $type = 1,$digit=2){
			# 100 cents			
			if($type == 1)
				$Amount = $Amount;
			# 10 cents
			elseif($type == 2)
				$Amount = $Amount / 10;
			# 1 cent
			elseif($type == 3)
				$Amount = $Amount / 100;
			return $currency.number_format($Amount, $digit);
		}
		
		/*
		 * Format length of number
		 */
		 function FormatLength($Number, $Len){
		 	$retOut = "";
			if($Len <= 0)
				$retOut = $Number;
			else{
				if(strlen($Number) > $Len)
					$retOut = $Number;
				else{
					for ($i=1; $i<=($Len - strlen($Number)); $i++)
						$retOut .= "0";
					$retOut .= $Number;
				}
			}
			return $retOut;
		 }
		 
		 /*
		 	* Format hour
			* hh:mm:ss
		 */
		 function FormatHour($second){
				$hour = intval($second / 3600);
				$second %= 3600;
				$minute = intval($second / 60);
				$second %= 60;
				return FormatLength($hour, 2).":".FormatLength($minute, 2).":".FormatLength($second, 2);
			}
		 
		  /*
		 	* Format minute
			* mm:ss
		 */
		 function FormatMinute($second){
				$minute = intval($second / 60);
				$second %= 60;
				return FormatLength($minute, 2).":".FormatLength($second, 2);
			}
		 
		/*
		 * Fix the quotes of string for database update
		 */
		function FixQuotes ($what = "") {
			$what = ereg_replace("'","''",$what);
			while (eregi("\\\\'", $what)) {
			$what = ereg_replace("\\\\'","'",$what);
			}
			return $what;
		}
		
		/**
		 ** Function get id
		 **
		 ** Created by: Chea vey
		 ** Created on: 2006 January 10
		 **/
		
		/* function getID($field){
		 		global $mydb;
				$sql = "select NextValue from tlkpnext where NextName='".$field."'";
				if($que = $mydb->sql_query($sql)){
					if($result = $mydb->sql_fetchrow($que)){
						$ID = $result['NextValue'];
						# update next value
						$sql1 = "update tlkpnext set NextValue=".($ID + 1)." where NextName='".$field."'";
						if($mydb->sql_query($sql1))
							return $ID;
						else
							return false;
					}						
				}else
					return false;
		 }
		 
		 */
		/**
		 ** Function get next id
		 **
		 ** Created by: Thon Nicolas
		 ** Created on: 2008 January 11
		 **/
		 
		function getID($field, $conn){
		 		$id = 0; 		 				 									
				
					$sql = "select NextValue from TLKPNEXT where NextName='".$field."'";
					
					$r1 = $conn->Execute($sql);					
					if($row=$r1->FetchRow()){
						$id = $row["NextValue"];
						$sql2="Update TLKPNEXT Set NextValue=".($id+1)." WHERE NextName='".$field."'";						
						$r2=$conn->Execute($sql2);																																					
					}else{
						return -1;
					}									
					
					//var_dump($e); 							
					//adodb_backtrace($e->gettrace());																				
																							
				return $id;
		}


		function getNextID($field){		
				global $db;				
		 		$id = 0; 		 				 									
				
					/*$sql = "select NEXT_VALUE from TLKPNEXT where NEXT_NAME='".$field."'";
					
					$r1 = $db->Execute($sql);					
					if($row=$r1->FetchRow()){
						
						$id = $row["NEXT_VALUE"];
						$sql2="Update TLKPNEXT Set NEXT_VALUE=".($id+1)." WHERE NEXT_NAME='".$field."'";						
						$r2=$db->Execute($sql2);																																					
						
					}else{
						return -1;
					}			*/						
					
					//var_dump($e); 							
					//adodb_backtrace($e->gettrace());																																											
				return $id;
		}

		/*
		function getNextID($field){
		 		global $db;
		 		$id = 0; 
		 		
		 		$db->StartTrans();								
				try{
					$sql = "select NextValue from tlkpnext where NextName='".$field."'";				
					$r1 = $db->Execute($sql);
					
					if($row=$r1->FetchRow()){
						$id = $row["NextValue"];
						$sql2="Update tlkpnext Set NextValue=".($id+1)." WHERE NextName='".$field."'";						
						$r2=$db->Execute($sql2);							
																														
					}else{
						return -1;
					}
					$db->CompleteTrans();
					
				}catch(exception $e){
					//var_dump($e); 							
					adodb_backtrace($e->gettrace());
					$db->FailTrans();		
									
					return -1;
				}																			
				return $id;
		}
		*/
		 
		 /**
		 ** Function get configue value
		 **
		 ** Created by: Chea vey
		 ** Created on: 2006 January 10
		 **/
		 function getConfigue($Name){
		 		global $db;
				$sql = "select ConfigueValue from globalconfigs where ConfigueName='".$Name."'";
				if($que = $db->Execute($sql)){
					if($result = $que->FetchRow())
						return $result['ConfigueValue'];						
					else
						return false;											
				}else
					return false;
		 }
		 
		 /**
		 ** Function get Invoice Item ID
		 **
		 ** Created by: Chea vey
		 ** Created on: 2006 January 10
		 **/
		 function getInvoiceItem($ItemName){
		 		global $mydb;
				$sql = "select ItemID from tlkpInvoiceItem where ItemName='".$ItemName."'";
				if($que = $mydb->sql_query($sql)){
					if($result = $mydb->sql_fetchrow($que))
						return $result['ItemID'];						
					else
						return false;											
				}else
					return false;
		 }
		 
		 /**
		 ** Function get cashier cash drawer
		 **
		 ** Created by: Chea vey
		 ** Created on: 2006 January 26
		 **/
		 function GetDrawerID($uerid){
		 	global $db;
			$sql = "SELECT DrawerID FROM tbldrawer 
				WHERE UserID = $uerid and StatusID = 1 and StartDate <= Now() 
				and (EndDate <= Now() or ".$db->IfNull("EndDate","''")."='')";
			///print $sql;
			
			if($que = $db->Execute($sql)){
				if($que->RecordCount() > 0){
					if($result = $que->FetchRow()){
						return $result['DrawerID'];
					}else{
						return 0;
					}
				}else{
					return 0;
				}
			}else{
				return 0;
			}
		}
	//
	//	Dateadd function
	//	$v: number of date to be added
	//	$d: giving date // if null than default is today
	//	$f: format date out put
	//
	function DateAdd($v, $d=null, $f="d/M/Y"){ 
		$d=($d?$d:date("Y-m-d")); 
		return date($f,strtotime($v." days",strtotime($d))); 
	}
	
	//
	//	Datediff function
	//
	function datediff($start_date,$end_date="now",$unit="D")
		{
			$unit = strtoupper($unit);
			$start=strtotime($start_date);
			if ($start === -1) {
				$retOut = "invalid start date";
			}
			
			$end=strtotime($end_date);			
			if ($end === -1) {
				$retOut = "invalid end date";
			}
			
			//if ($start > $end) {
//				$temp = $start;
//				$start = $end;
//				$end = $temp;
//			}
			
			$diff = $end-$start;
			
			$day1 = date("j", $start);
			$mon1 = date("n", $start);
			$year1 = date("Y", $start);
			$day2 = date("j", $end);
			$mon2 = date("n", $end);
			$year2 = date("Y", $end);
			
			switch($unit) {
				case "D":
					$retOut = intval($diff/(24*60*60));
					break;
				case "M":
					if($day1>$day2) {
						$mdiff = (($year2-$year1)*12)+($mon2-$mon1-1);
					} else {
						$mdiff = (($year2-$year1)*12)+($mon2-$mon1);
					}
					$retOut = $mdiff;
					break;
				case "Y":
					if(($mon1>$mon2) || (($mon1==$mon2) && ($day1>$day2))){
						$ydiff = $year2-$year1-1;
					} else {
						$ydiff = $year2-$year1;
					}
					$retOut = $ydiff;
					break;
				case "YM":
					if($day1>$day2) {
						if($mon1>=$mon2) {
							$ymdiff = 12+($mon2-$mon1-1);
						} else {
							$ymdiff = $mon2-$mon1-1;
						}
					} else {
						if($mon1>$mon2) {
							$ymdiff = 12+($mon2-$mon1);
						} else {
							$ymdiff = $mon2-$mon1;
						}
					}
					$retOut = $ymdiff;
					break;
				case "YD":
					if(($mon1>$mon2) || (($mon1==$mon2) &&($day1>$day2))) {
						$yddiff = intval(($end - mktime(0, 0, 0, $mon1, $day1, $year2-1))/(24*60*60));						
					} else {
						$yddiff = intval(($end - mktime(0, 0, 0, $mon1, $day1, $year2))/(24*60*60));
					}
					$retOut = $yddiff;
					break;
				case "MD":
					if($day1>$day2) {
						$mddiff = intval(($end - mktime(0, 0, 0, $mon2-1, $day1, $year2))/(24*60*60));						
					} else {
						$mddiff = intval(($end - mktime(0, 0, 0, $mon2, $day1, $year2))/(24*60*60));
					}
					$retOut =$mddiff ;
					break;
				default:
     			print("{Datedif Error: Unrecognized \$unit parameter. Valid values are 'Y', 'M', 'D', 'YM'. Default is 'D'.}");
				
			}
			if($retOut < 0) $retOut = "";
			return $retOut;
		}
		
		//This function is limited to a 32 char long pass but
		//this does not seem to be a real problem :)
		function GeneratePassword($length = 12) {
			srand((double)microtime()*1000000000);
			$UniqID=md5(uniqid(rand()));				
			$password=substr(substr(rand(),0,$length).substr(rand(),0,$length),0,$length);
			return trim($password);
			$password=substr(rand(),0,$length).substr(rand(),0,$length);
			return trim($password);
			
			
		}
		
		function DBTimeStamp($strdate)
		{
			global $db;
			//clean date												
			$strdate = str_replace("'", "", $strdate);			
			// donothing
			$strdate = $db->DBTimeStamp($strdate);	
			return $strdate;	
		}
		
		 function EncryptString($text){
     	                global $globalconf;                        
                        $ivsize = mcrypt_get_iv_size(MCRYPT_XTEA, MCRYPT_MODE_OFB);
                        $iv = mcrypt_create_iv($ivsize, MCRYPT_RAND);
                        $enctext=mcrypt_encrypt(MCRYPT_XTEA, $globalconf["KEY_ENCRYPT"], $text, MCRYPT_MODE_OFB, $iv);
                        return $enctext;                                                                                                                                                                 
                 }
                 function DecryptString($text){
                        global $globalconf;  
     	                $ivsize = mcrypt_get_iv_size(MCRYPT_XTEA, MCRYPT_MODE_OFB);
                        $iv = mcrypt_create_iv($ivsize, MCRYPT_RAND);
                        return  mcrypt_decrypt(MCRYPT_XTEA, $globalconf["KEY_ENCRYPT"], $text, MCRYPT_MODE_OFB, $iv);
                 }
                 function CreateDirectory($dirname,&$resultmessage,&$iserror){
  	               if (is_dir($dirname)!=1){
		          if (!mkdir($dirname)){
		             $errorMessage="Current directory path can not create";
		             $iserror=1;
		             return;
                             }
                          else{
                             $errorMessage="Current directory path create successfully";
		             $iserror=0;	
                          }
                       }
                       else {
		       	    $resultmessage="Current directory path is exist.";
		       	    $iserror=0;
		       }                 	
                 }
                 function MoveFileFromDirectory($source,$dest,&$resultmessage,&$iserror){
                       CreateDirectory($dest,$resultmessage,$iserror);
                       if ($iserror){
		         return;		       	
		       }
		       $handle=opendir($source);
		       $count=0;
		       while (false!==($str=readdir($handle))){
                	if (is_file($source.$str)){
                		copy($source.$str,$dest.$str);
		                unlink($source.$str);
		                $count++;
                	        }
                        }
                 closedir($handle);
                 return count;       	
                 }
                 function CreateKeyFile($keytext,$filename){
                 	$file=fopen($filename,"wb");
                 	fwrite($file,$keytext);
                 	fclose($file);
                 }
                 function GetKeyFromFile($fileName,&$resultmessage,&$iserror){
                        $file=@fopen($fileName,"rb");
                        if ($file==false){
                           $resultmessage="Key File not found";
                           $iserror=1;
                       	    return;
                        }
                        return fread($file,filesize($fileName));	
                 }
                 
                 function ConvertDataToAppDataForm($st){
                 	  global $globalconf;
                          if (trim($st)=="") return "";
                          $arr=explode($globalconf["CR"],$st);                          
                          if($arr[0]){
                          	$result="SIP/".trim($arr[0]);
                          }                          
                          for($i=1;$i<count($arr);$i++){
                          	if($arr[$i]){
                           		$result = $result ."&SIP/".trim($arr[$i]);	
                           	}
                          } 
                          return $result;
                 }
                 
                 function ConvertFormAppDataToString($st){
                          if (trim($st)=="") return "";                          
                          $arr=explode("&",$st);        
                                        
                          $result = "";
                          for($i=0;$i<count($arr);$i++){                           
                          	$s = trim($arr[$i]);
                          	if($i > 0 ){
                          		$s = ",".$s;
                          	}                          	
                           $result .= $s;
                          } 
                          $result = str_replace( 'SIP/','', $result);
                          return $result;
                 }          
                 
                 function ConvertFormAppDataToTextArea($st){
                 	  global $globalconf;
                 	  
                          if (trim($st)=="") return "";                          
                          $arr=explode("&",$st);        
                                        
                          $result = "";
                          for($i=0;$i<count($arr);$i++){                           
                          	$s = trim($arr[$i]);
                          	if($i > 0 ){
                          		$s = $globalconf["CR"].$s;
                          	}                          	
                           $result .= $s;
                          } 
                          
                          $result = str_replace( 'SIP/','', $result);
                          return $result;
                 }                     
                 
				function GetMonth($m=0) {
					return (($m==0 ) ? date("F") : date("F", mktime(0,0,0,$m)));
				}
				
				

 		function array_qsort(&$array, $column, $order='SORT_ASC', $first=0, 
		$last= -2)
		{
		  // $array  - the array to be sorted
		  // $column - index (column) on which to sort
		  //          can be a string if using an associative array
		  // $order  - SORT_ASC (default) for ascending or SORT_DESC for descending
		  // $first  - start index (row) for partial array sort
		  // $last  - stop  index (row) for partial array sort
		  // $keys  - array of key values for hash array sort
		 if (is_array($array)) {
		  $keys = array_keys($array);
		 
		  if($last == -2) $last = count($array) - 1;
		  if($last > $first) {
		   $alpha = $first;
		   $omega = $last;
		   $key_alpha = $keys[$alpha];
		   $key_omega = $keys[$omega];
		   $guess = $array[$key_alpha][$column];
		   while($omega >= $alpha) {
			 if($order == 'SORT_ASC') {
			   while($array[$key_alpha][$column] < $guess) {$alpha++; $key_alpha 
		= $keys[$alpha]; }
			   while($array[$key_omega][$column] > $guess) {$omega--; $key_omega 
		= $keys[$omega]; }
			 } else {
			   while($array[$key_alpha][$column] > $guess) {$alpha++; $key_alpha 
		= $keys[$alpha]; }
			   while($array[$key_omega][$column] < $guess) {$omega--; $key_omega 
		= $keys[$omega]; }
			 }
			 if($alpha > $omega) break;
			 $temporary = $array[$key_alpha];
			 $array[$key_alpha] = $array[$key_omega]; $alpha++;
			 $key_alpha = $keys[$alpha];
			 $array[$key_omega] = $temporary; $omega--;
			 $key_omega = $keys[$omega];
		   }
		   array_qsort ($array, $column, $order, $first, $omega);
		   array_qsort ($array, $column, $order, $alpha, $last);
		  }
		 }
		  return $array;
		}
				 
?>
