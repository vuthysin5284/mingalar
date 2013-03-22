<?php session_start();date_default_timezone_set('Asia/Bangkok');
	require_once('../adodb/adodb.inc.php');
	require_once("../utilities/db.config.php");
	require_once("../utilities/functions.php");
	require_once("../utilities/class.paging.php");	
	require_once("../models/tracks.php");
	$tracks = new tracks(100,"tracks",10);
	$a = $_REQUEST["a"];
	$position = empty($_REQUEST["position"])?0:$_REQUEST["position"];	

	
	if($a == "view"){
		
		$tracks->GettracksList($position);
		
	}else if($a == "search"){
		$t =  $_REQUEST["t"];
		if($t==2){
			
			$start_date = $_REQUEST["start_date"];
			$end_date = $_REQUEST["end_date"];
			
			echo $tracks->GettracksSearchListByDate($position, formatDate( $start_date ,5), formatDate($end_date,5));
			
			
		}else{
			$q = $_REQUEST["q"];
			
			echo $tracks->GettracksSearchList($position,$q,$t);
			
			
		}
	}else if($a == "get_tracks_list"){
		$employee_id =$_REQUEST["employee_id"];	
		$tracks->GettracksListByEmployeeID($position, $employee_id);
	}
?>