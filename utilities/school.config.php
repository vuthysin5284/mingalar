<?php
	
	define("normal",1);
	define("scholarship",2);
	define("cancellation",3);
	define("suspension",4);
	define("drop",5);
	define("getscholarship",6);
	define("_new",7);
	
	define("female",1);
	define("male",2);
	
	define("exam_scholarship",1);
	define("study_scholarship",2);
	

	
	define("manager_discount",1);
	define("graduate_discount",2);
	
	$invoice_status = array(0=>"<i class='Opening'>Opening</i>",1=>"Closed");
        
	$student_type_arr = array(normal=>'Normal',
							  scholarship=>'Scholarship',
							  cancellation=>'Cancellation',
							  suspension=>'Suspension',
							  drop=>'Drop',
							  getscholarship=>'Getscholarship',
							  _new=>'New'
		);
	
	$student_type = array(normal=>'Normal',
							  scholarship=>'Scholarship',
							  _new=>'New'
		);
	
	
	$transport  = array('1'=>"ម៉ូតូឌុបចំណាយ (លុយផ្ទាល់ខ្លួន)", '2'=>"ម៉ូតូផ្ទាល់ខ្លួន",'3'=>"កង់",
                        "4"=>"មធ្យោបាយធ្វើដំណើរសារធារណះចំណាយលុយផ្ទាល់ខ្លួន",
                        "5"=>"មធ្យោបាយធ្វើដំណើរផ្តល់ដោយគ្រឹះស្ថាន(ឥតគិតថ្លៃ)",
                        "6"=>"មធ្យោបាយធ្វើដំណើរផ្តល់ដោយសហគមន៍(ឥតគិតថ្លៃ)",
                        "7"=>"ថ្មើរជើង",
                        "8"=>"ផ្សេងៗ");

?>