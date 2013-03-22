<?php
	/*Code Generator: V.1
	 Developed by Bunthoeurn 
	 Date: 18/07/2012 03:57 
	*/	 
	session_start();
	 require_once("../adodb/adodb.inc.php");                           
	 require_once("../utilities/db.config.php");                       
	 require_once("../utilities/functions.php");                       
	 require_once("../utilities/class.paging.php");                    
	 require_once("../models/term_condition.class.php"); 
	 require_once("../models/tracks.php");
	$tracks = new tracks(20,"tracks",3);
	 $term_condition = new term_condition(20,"term_condition",3); 
	 $a = $_REQUEST["a"];                                              
	 if($a == "view"){                                                 
		 $position = empty($_REQUEST["position"])?0:$_REQUEST["position"]; 
		 echo $term_condition->Getterm_conditionList($position);    
	 }else if($a=="Edit"){                                             
		$term_condition->term_id = $_REQUEST["term_id"];
		$term_condition->description = $_REQUEST["description"];
		$term_condition->term_name = $_REQUEST["term_name"];
		$term_condition->order_no = $_REQUEST["order_no"];
		$term_condition->default = $_REQUEST["txtdefault"];
		
		if($term_condition->default==1)$term_condition->SetState();
		  
		if($term_condition->Update($term_condition)){ 
			$tracks->truck_id = 0;
				$tracks->username = $_SESSION["username"];
				$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
				$tracks->operation = "Edit Team Condition";
				$tracks->operate_date = date('Ymd h:i:s');
				$tracks->description = json_encode($term_condition);
				$tracks->Insert($tracks);
			 echo "success";    
		}                      
	 }else if($a == "New"){ 
	 	
		 $term_condition->term_id = $_REQUEST["term_id"];
		 $term_condition->description = $_REQUEST["description"];
		 $term_condition->term_name = $_REQUEST["term_name"];
		 $term_condition->order_no = $_REQUEST["order_no"];
		 $term_condition->default = $_REQUEST["txtdefault"];
		  
		 if($term_condition->default==1)$term_condition->SetState();
		  
		 if($term_condition->Insert($term_condition)) 
		 {   
		 $tracks->truck_id = 0;
				$tracks->username = $_SESSION["username"];
				$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
				$tracks->operation = "Insert New Team Condition";
				$tracks->operate_date = date('Ymd h:i:s');
				$tracks->description = json_encode($term_condition);
				$tracks->Insert($tracks);
			 echo "success";       
		 }                         
	 }else if($a== "delete"){   
	 	
		 $term_id = explode(',', $_REQUEST["term_id"]);
		 $detector = false ;                                                   
		 for( $i=0 ; $i < count($term_id); $i++ ){    
		 
			 $term_condition->term_id = $term_id[$i];   
			 $detector = $term_condition->Delete($term_condition); 
			 $tracks->truck_id = 0;
				$tracks->username = $_SESSION["username"];
				$tracks->ip_address = $_SERVER['REMOTE_ADDR'];
				$tracks->operation = "Delete Team Condition";
				$tracks->operate_date = date('Ymd h:i:s');
				$tracks->description = json_encode($term_condition);
				$tracks->Insert($tracks);
		 }                                                     
		 if($detector == true){ echo "success"; }
		 
	 }else if($a== "trash"){                               
		 $term_id = explode(',', $_REQUEST["term_id"]);  
		 $detector = false ;                                                   
		 for( $i=0 ; $i < count($term_id); $i++ ){                  
			 $term_condition->term_id = $term_id[$i];   
			 $term_condition->state = $_REQUEST["state"];   
			 $detector = $term_condition->SetState($term_condition) ; 
		 }                                                     
		 if($detector == true){ echo "success"; }            
	 }else if($a== "restore"){                             
		 $term_id = explode(',', $_REQUEST["term_id"]);                
		 $detector = false ;                                                   
		 $term_condition->state = $_REQUEST["state"];   
		 for($i=0 ; $i < count($term_id); $i++){                    
			 $term_condition->term_id =$term_id[$i];   
			 $detector = $term_condition->SetState($term_condition); 
		 }                     
		 if($detector == true){ echo "success"; }
	 }                       
?>
