<?php

		/*
		 * Format Date
		 */
		
		function formatDate($strdate = "", $mode){
			
			$date = strtotime($strdate);					
			if(empty($date)) return;
			$sep = "/";
			$com = ",";
			
			/*# ============ AM/PM ===========
			# am/pm*/
			$a = date("a", $date);
			/*# AM/PM*/
			$A = date("A", $date);
			
			/*# ============ Second ==========
			# ss (00 - 59)*/
			$s = date("s", $date);
			
			/*# ============ Minute ==========
			# mn (00 - 59)*/
			$i = date("i", $date);
			
			/*# ============ Hour ============
			# hh (1 - 12)*/
			$g = date("g", $date);
			/*# hh (01 - 12)*/
			$h = date("h", $date);
			/*# hh (0 - 23)*/
			$G = date("G", $date);
			/*# hh (00 - 23)*/
			$H = date("H", $date);
			
			/*# ============ Date ============
			# dd (1 - 31)*/
			$j = date("j", $date);
			/*# dd (01 - 31)*/			
			$d = date("d", $date);
			/*# ddd (mon-sun)*/
			$D = date("D", $date);
			/*# dddd (monday - sunday)*/
			$l = date("l", $date);
			
			/*# ============ Month ============
			# mm (1 - 12)*/
			$n = date("n", $date);
			/*# mm (01 - 12)*/
			$m = date("m", $date);
			/*# mmm (jan - dec)*/
			$M = date("M", $date);
			/*# mmmm (january - december)*/
			$F = date("F", $date); 
			
			/*# ============ year =============
			# yy*/
			$y = date("y", $date);
			/*# yyyy*/
			$Y = date("Y", $date);
			
			switch($mode){
				case 1: /*# dd/mm/yy (01/01/07)*/
					$retDate = $d.$sep.$m.$sep.$y;
					break;
				case 2: /*# dd/mm/yyyy (01/01/2007) Diplay with Ms SQL Server*/
 					$retDate = $d.$sep.$m.$sep.$Y;
					break;
				case 3: /*# dd/mmm/yy (01/jan/07)*/
					$retDate = $d.$sep.$M.$sep.$y; 
					break;
				case 4: /*# dd/mmm/yyyy (01/jan/2007)*/
					$retDate = $d.$sep.$M.$sep.$Y; 
					break;								
				case 5: /*# yyyymmdd (20070101) for insert in MySQL*/ 
					$retDate = $Y.$m.$d.$H.$i.$s;
					break;
				case 6: /*#YYYY-mm-dd*/
					$retDate = $Y."-".$m."-".$d;
					break;
				case 7: /*#dd mmmm yyyy*/
					$retDate = $d." ".$F." ".$Y;
					break;
				case 8: /*#dd mmm yyyy hh:mm:ss*/
					$retDate = $d." ".$F." ".$Y." ".$H.":".$i.":".$s;
					break;
				case 9: /*#dd/mmm/yyyy hh:mm:ss*/
					$retDate = $d."/".$M."/".$Y." ".$H.":".$i.":".$s;
					break;
					
				case 10: /*#dd mmm yyyy hh:mm:ss*/
					$retDate = $d." ".$M." ".$Y." ".$H.":".$i.":".$s; 
					break;
				case 11: /*#dd mmm yyyy */
					$retDate = $d." ".$M." ".$Y; 
					break;
				case 12: /*#dd-mm-YYYY*/
					$retDate = $d."-".$M."-".$Y;
					break;
				case 13: /*#13:30*/
					$retDate = $H.":".$i ;
					break;
				case 14: /*#dd - mmm - yyyy */
					$retDate = $d."-".$m."-".$Y; 
					break;
				case 15: /*#dd mmm yyyy hh:mm:ss*/
					$retDate = $d." - ".$M." - ".$Y." ".$H.":".$i.":".$s; 
					break;
				case 16: /*#yyyymmdd*/
					$retDate = $Y.$m.$d; 
					break;
			} 
			
			return $retDate;
		}
		
		/*
		 * Format currency
		 */
		function FormatCurrency($Amount, $currency = "\$", $type = 1,$digit=2){
			
			if($type == 1)
				$Amount = $Amount;
			
			elseif($type == 2)
				$Amount = $Amount / 10;
	
			elseif($type == 3)
				$Amount = $Amount / 100;
			return $currency.number_format($Amount, $digit);
		}
		function FormatMoney($amount, $money_type="\$"){
			$money = "";
			if($amount < 0){
				$money .= "-".$money_type.number_format(($amount * (-1)), 2);
			}
			else{
				$money .= $money_type.number_format($amount, 2);
			}
			return $money;
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
		 
		
	
	function DateAdd($v, $d=null, $f="d/M/Y"){ 
		$d=($d?$d:date("Y-m-d")); 
		return date($f,strtotime($v." days",strtotime($d))); 
	}
	
	
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
		

	function GeneratePassword($length = 12) {
		srand((double)microtime()*1000000000);
		$UniqID=md5(uniqid(rand()));				
		$password=substr(substr(rand(),0,$length).substr(rand(),0,$length),0,$length);
		return trim($password);
		$password=substr(rand(),0,$length).substr(rand(),0,$length);
		return trim($password);
		
		
	}
	
	
	
	function GetDays($current_select_days){
		
		$end_day_of_month = date("t");
		if(!isset($current_select_days)){
			$current_select_days = date("d");	
		}
		for ($i = 1;$i<= $end_day_of_month; $i++){
			if($current_select_days == $i){
				echo "<option value='".$i."' selected='selected'>".$i."</option>";
			}else{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
		
	}
	function GetMonths($current_select_months){
		$months = array(1=>"January",2=>"February",3=>"March",4=>"April",5=>"May",6=>"June",7=>"July",8=>"August",9=>"September",10=>"October",11=>"November",12=>"December");
		
		if(!isset($current_select_months)){
			$current_select_months = date("n");	
		}
		
		for ($i = 1;$i<=count($months); $i++){
			if($current_select_months == $i){
				echo "<option value='".$i."' selected='selected'>".$months[$i]."</option>";
			}else{
				echo "<option value='".$i."'>".$months[$i]."</option>";
			}
		}
			
	}

	function GetYears($current_select_years){
		
		if(!isset($current_select_years)) {
			
			$current_select_years = date("Y");
				
		}
		
		for ($i = date("Y");$i >= 2009; $i--){
			if($current_select_years == $i){
				echo "<option value='".$i."' selected='selected'>".$i."</option>";
			}else{
				echo "<option value='".$i."'>".$i."</option>";
			}
		}
	
	}
	
	function IdleTimeOut($username, $file_name){
		
		if($username==""){		    
			header("location:../index.php?page={$file_name}");
			exit;
		}	
	}
	
	
	//SErver
	/*function PathRoot(){
		
		$host  = $_SERVER['HTTP_HOST'];
		
		$arr =  explode("/", $_SERVER['PHP_SELF']);
	
		$url = "http://".$host;		//$url = "http://".$host."/".$arr[1];		
		return $url;
	}*/
	//Client
	function PathRoot(){
		
		$host  = $_SERVER['HTTP_HOST'];
		
		$arr =  explode("/", $_SERVER['PHP_SELF']);
	
		$url = "http://".$host."/".$arr[1];		
		return $url;
	}
	
	function convertNumber($num)
{
   list($num, $dec) = explode(".", $num);

   $output = "";

   if($num{0} == "-")
   {
      $output = "negative ";
      $num = ltrim($num, "-");
   }
   else if($num{0} == "+")
   {
      $output = "positive ";
      $num = ltrim($num, "+");
   }
   
   if($num{0} == "0")
   {
      $output .= "Zero";
   }
   else
   {
      $num = str_pad($num, 36, "0", STR_PAD_LEFT);
      $group = rtrim(chunk_split($num, 3, " "), " ");
      $groups = explode(" ", $group);

      $groups2 = array();
      foreach($groups as $g) $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});

      for($z = 0; $z < count($groups2); $z++)
      {
         if($groups2[$z] != "")
         {
            $output .= $groups2[$z].convertGroup(11 - $z).($z < 11 && !array_search('', array_slice($groups2, $z + 1, -1))
             && $groups2[11] != '' && $groups[11]{0} == '0' ? " and " : ", ");
         }
      }

      $output = rtrim($output, ", ");
	  $output .= " Dollar(s)";
	  //$output = str_replace("One Dollars","One Dollar",$output);
   }

   if($dec > 0)
   {
      $output .= " and ";
      //for($i = 0; $i < strlen($dec); $i++) $output .= " ".convertDigit($dec{$i});
	  $output .= convertNumber($dec);
	  $output .= " Cent(s)";
	  $output = str_replace('Dollar(s) Cent(s)','Cent(s)',$output);
   }

   return $output;
}

function convertGroup($index)
{
   switch($index)
   {
      case 11: return " Decillion";
      case 10: return " Nonillion";
      case 9: return " Octillion";
      case 8: return " Septillion";
      case 7: return " Sextillion";
      case 6: return " Quintrillion";
      case 5: return " Quadrillion";
      case 4: return " Trillion";
      case 3: return " Billion";
      case 2: return " Million";
      case 1: return " Thousand";
      case 0: return "";
   }
}

function convertThreeDigit($dig1, $dig2, $dig3)
{
   $output = "";

   if($dig1 == "0" && $dig2 == "0" && $dig3 == "0") return "";

   if($dig1 != "0")
   {
      $output .= convertDigit($dig1)." Hundred";
      if($dig2 != "0" || $dig3 != "0") $output .= " and ";
   }

   if($dig2 != "0") $output .= convertTwoDigit($dig2, $dig3);
   else if($dig3 != "0") $output .= convertDigit($dig3);

   return $output;
}

function convertTwoDigit($dig1, $dig2)
{
   if($dig2 == "0")
   {
      switch($dig1)
      {
         case "1": return "Ten";
         case "2": return "Twenty";
         case "3": return "Thirty";
         case "4": return "Forty";
         case "5": return "Fifty";
         case "6": return "Sixty";
         case "7": return "seventy";
         case "8": return "Eighty";
         case "9": return "Ninety";
      }
   }
   else if($dig1 == "1")
   {
      switch($dig2)
      {
         case "1": return "Eleven";
         case "2": return "Twelve";
         case "3": return "Thirteen";
         case "4": return "Fourteen";
         case "5": return "Fifteen";
         case "6": return "Sixteen";
         case "7": return "Seventeen";
         case "8": return "Eighteen";
         case "9": return "Nineteen";
      }
   }
   else
   {
      $temp = convertDigit($dig2);
      switch($dig1)
      {
         case "2": return "Twenty-$temp";
         case "3": return "Thirty-$temp";
         case "4": return "Forty-$temp";
         case "5": return "Fifty-$temp";
         case "6": return "Sixty-$temp";
         case "7": return "Seventy-$temp";
         case "8": return "Eighty-$temp";
         case "9": return "Ninety-$temp";
      }
   }
}
      
function convertDigit($digit)
{

   switch($digit)
   {
      case "0": return "Zero";
      case "1": return "One";
      case "2": return "Two";
      case "3": return "Three";
      case "4": return "Four";
      case "5": return "Five";
      case "6": return "Six";
      case "7": return "Seven";
      case "8": return "Eight";
      case "9": return "Nine";
   }
}

?>