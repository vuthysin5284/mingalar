<?php

class util {
	
	public function __construct() {}
	
	/*
	*check if OS is Unix or Window
	*@return: true if unix.
	*/
	
	public static function is_unix() {
		if( substr(dirname(__FILE__), 0, 1) == "/" ) 	return true;
		else											return false;
	}
	
	/*
	*fix the object that cause an error.
	*when calling the session object after called session_start()
	*the error will occur, use this function to fix the object
	*@param
	*- $object: the reference object; the object that will be fix
	*/
	public static function fix_object(&$obj) {
	  if (!is_object ($obj) && gettype ($obj) == 'object')
		return ($obj = unserialize (serialize ($obj)));
	  return $obj;
	}
	
	/*
	*get IP
	*@return string
	*/
	public static function ip() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {  
		 	
			//check ip from share internet
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
			
			//to check ip is pass from proxy
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	/*
	*when accessing to system the path between window and linux are different
	*use this function to correct the "/" for linux and "\" for window
	*@return string
	*@param:
	* - $path : incorrected path
	* - $type : 0 for current server, -1 for window, 1 for linux
	*/
	public static function path($path, $type = 0) {
		if($type == 0) {
			if(!util::is_unix())   	return str_replace('/', '\\', $path);
			else					return str_replace('\\', '/', $path);
		} elseif($type == -1) {
			return str_replace('/', '\\', $path);
		} elseif($type == 1) {
			return str_replace('\\', '/', $path);
		} else return $path;
	}
	
	/*
	*map number to letter, useful when working with Excel
	*@return: string
	*@param:
	* - $c : number which is match the letter
	*@example: ec(2); // 'B'
	*/
	public static function ec($c) {
		$c = intval($c);
		$letter = '';
		if ($c <= 0) return '';
		while($c != 0){
		   $p = ($c - 1) % 26;
		   $c = intval(($c - $p) / 26);
		   $letter = chr(65 + $p) . $letter;
		}
		return $letter;
	}
	
	/*
	*use this to redirect url
	*if couldn't use header, use javascript instead
	*@param
	* - $url: the url you wish to redirect
	* - $js : if true, redirect using javascript
	*/
	public static function redirect($uri, $js = false) {
		if($js) {
			echo '<script language="Javascript">window.location="'.$uri.'"</script>';
		} else { 
			header('location: '.$uri);
		}
	}
	
	/*
	*use this function to print array or object
	*@return: null
	*@param
	* - $obj : mix value to be printed
	*/
	public static function out($obj) {
		echo '<pre>'; print_r($obj); echo '</pre>';
	}
	
	/*
	*minify function useful to decrease text size
	*return string 
	*param : 
	* - code : string html or css or javascript
	*/
	public static function minify($code) {

		$search = array(
			'/\>[^\S ]+/s', //strip whitespaces after tags, except space
			'/[^\S ]+\</s', //strip whitespaces before tags, except space
			/*'/(\s)+/s',  // shorten multiple whitespace sequences*/
			'/(;})/', 
			'/\r?\n/',
			'/\t/'
			);
		$replace = array(
			'>',
			'<',
			/*'\\1',*/
			'}',
			'',
			''
			);
		return preg_replace($search, $replace, $code);
	}
	/**********************************************************************
		*  Format a mySQL string correctly for safe mySQL insert
		*  (no mater if magic quotes are on or not)
		*/

		static function escape($str)
		{
			return mysql_escape_string(stripslashes($str));
		}
		
		/**********************************************************************
		*  wrap String with double Quote for string value
		*/

		function quote($str) 
		{
			return '"'.$this->escape($str).'"';
		}
}






