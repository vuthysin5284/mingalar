<?php
 
class Crypt {
	
	//encrypt key
	public static $_k = array();
	
	public static $_m = array(
		'0' => 'm', 'm' => '0', 
		'9' => 'R', 'R' => '9', 
		'z' => 'Z', 'Z' => 'z', 
		'o' => 'P', 'P' => 'o', 
		'=' => '1', '1' => '=', 
		'k' => 'G', 'G' => 'k', 
		'7' => '4', '4' => '7', 
		'H' => 'r', 'r' => 'H', 
		'T' => 'e', 'e' => 'T', 
		'A' => 'a', 'a' => 'A', 
		'f' => 'U', 'U' => 'f', 
		'S' => 'L', 'L' => 'S', 
		'6' => 'I', 'I' => '6', 
		'x' => 'y', 'y' => 'x', 
		'Y' => 'C', 'C' => 'Y', 
		'u' => '3', '3' => 'u', 
		'O' => 'b', 'b' => 'O', 
		'2' => 'w', 'w' => '2', 
		'v' => 'J', 'J' => 'v', 
		'p' => 'q', 'q' => 'p', 
		'X' => 's', 's' => 'X', 
		'c' => 't', 't' => 'c', 
		'5' => 'N', 'N' => '5', 
		'8' => 'V', 'V' => '8', 
		'd' => 'g', 'g' => 'd', 
		'W' => 'i', 'i' => 'W', 
		'M' => 'h', 'h' => 'M', 
		'E' => 'n', 'n' => 'E', 
		'D' => 'F', 'F' => 'D', 
		'j' => 'Q', 'Q' => 'j', 
		'l' => '$', '$' => 'l', 
		'B' => 'K', 'K' => 'B'
	);
	
	public function __construct($k = '123') {  

		//make key as md5
		$_k = md5($k);
	}
	
	public function encrypt($str) {
		
		//get string length
		$i = strlen($str);
print_r(isset($_k)?$_k:'');
		//cannot encrypt more than 20 character
		if($i > 21) return false;
		else $str = substr(isset($_k)?$_k:'', 0, (21 - $i + 1)).'|'.$str;
		
		//encode into base64
		$a = base64_encode($str);
		
		//split into array
		$a = str_split($a);
		
		//switch array element
		foreach($a as $k => $v) $a[$k] = isset($_m[$v]) ? $this->_m[$v] : $v;
		
		//switch first to last
		$str = $a[0]; $a[0] = $a[count($a) - 1]; $a[count($a) - 1] = $str;
		
		//return encoded string
		return implode('', $a);
	}
	
	public function decrypt($str) {
		
		//split into array
		$a = str_split($str);
		
		//switch first to last
		$str = $a[0]; $a[0] = $a[count($a) - 1]; $a[count($a) - 1] = $str;
		
		//switch array element
		foreach($a as $k => $v) $a[$k] = isset($_m[$v]) ? $_m[$v] : $v;
		
		//serialize array into a string
		$a = implode('', $a);
	
		//decode base64
		$a = base64_decode($a);
		
		//cut off extended string
		$a = explode('|', $a);
		
		return isset($a[1]) ? $a[1] : $a[0];
	}
}



