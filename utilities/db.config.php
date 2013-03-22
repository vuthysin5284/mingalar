<?php
date_default_timezone_set('Asia/Phnom_Penh');
define("default_user","admin");

$config['dbhost'] = "localhost";
$config['dbuser'] = "root";
$config['dbpass'] = "root";
$config['dbname'] = "mingalar_db";

$config['dbpref'] = "pro";
$config['project'] = "WESTAG";

//$driver = 'mssqlnative';
$driver = 'mysqli';

if (empty($driver) or $driver == 'mssqlnative') {
	$db = NewADOConnection($driver);
	$db->Connect($config['dbhost'],$config['dbuser'],$config['dbpass'],$config['dbname']);
	$db->SetFetchMode(ADODB_FETCH_BOTH); /*Default MSSQL is ADODB_FETCH_NUM*/
}
//invoice status 1 is closed and 0 open, 2 void
$state = array("1"=>"Published","0"=>"Unpublished","2"=>"Archived","-2"=>"Trashed");
$semester = array(1 => "1",2 => "2");

?>