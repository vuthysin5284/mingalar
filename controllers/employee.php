<?php session_start();date_default_timezone_set('Asia/Bangkok');

include_once('../adodb/adodb.inc.php');
include_once("../utilities/db.config.php");
require_once("../utilities/functions.php");
require_once("../utilities/class.paging.php");
require_once("../models/employee.php");
require_once("../models/department.php");
require_once("../models/company.php");
require_once("../customizes/department.custom.php");

$profiles = new profiles_custom(19,"profiles",3);
$employee = new employee(20,"employee",3);
$company = new company(20,"company",3);

$a = $_REQUEST["a"];
if(isset($_REQUEST["employee_id"])){
	$employee->employee_id = $_REQUEST["employee_id"];
	$employee = $employee->GetemployeeInfoByemployee_id($employee);
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title><?php echo $config["system_name"] ?> - Employee</title>
<?php 
include_once("../utilities/header.php"); 
 ?>
<script type="text/javascript" src="../js/prowestec.js"></script>
<script type="text/javascript">
	page.url = "employee.modify.php";
	page.display = "displaymgs";
	page.url_request = "../views/employee.php";
	$(function(){			
		var a = "<?php echo $a?>";
		if(a=="New"){
			$("#employee_id").val("<?php echo $employee->Getemployee_id();?>");	
		}else if(a == "Edit"){	
			 $("#abbreviation").val("<?php echo $employee->abbreviation ?>");
			 $("#employee_id").val("<?php echo $employee->employee_id ?>");
			 $("#seller_name").val("<?php echo $employee->seller_name ?>");
			 $("#position").val("<?php echo $employee->position ?>");
			 $("#company_id").val("<?php echo $employee->company_id ?>");
			 $("#department").val("<?php echo $employee->department ?>");
			 $("#tel").val("<?php echo $employee->tel ?>");
			 $("#extension").val("<?php echo $employee->extension ?>");
			 $("#email").val("<?php echo $employee->email ?>");
			 var department = document.getElementById("department");
			department.disabled = false;
		}
		
	 $("#btSave").click(function() { 
		if(a=="Edit"){Validate(2);}else{Validate(1);}
	 });
	   $("#topSave").click(function() {						 
		if(a=="Edit"){Validate(2);}else{Validate(1);}
	 });
	  $("#topCancel").click(function(){
		document.location.href = "../views/employee.php";		
	  });
	  $("#btCancel").click(function(){
		document.location.href = "../views/employee.php";	
	  });
 });
 function Validate(act){		
if( $("#abbreviation").val()==""){ 
    MessageBox.Show("Please enter abbreviation!");
    $("#abbreviation").focus();
    return; 
}else if( $("#seller_name").val()==""){ 
    MessageBox.Show("Please enter employee name!");
    $("#seller_name").focus();
    return; 
}else if( $("#position").val()==""){ 
    MessageBox.Show("Please enter position!");
    $("#position").focus();
    return; 
}else if( $("#company_id").val()==""){ 
    MessageBox.Show("Please select company!");
    $("#company_id").focus();
    return; 
}else if( $("#department").val()=="0" || $("#department").val() == "Select"){ 
    MessageBox.Show("Please select department ");
    $("#department").focus();
    return; 
}else if( $("#tel").val()==""){ 
    MessageBox.Show("Please retry to get new tel ");
    $("#tel").focus();
    return; 
}else{ 
	
	if( $("#email").val()!=""){ 
		if(!isEmail($("#email").val())){
			 MessageBox.Show("Your email is not validate!");
			$("#email").focus();
			return; 
		}
	}
		page.queryString = { 
			abbreviation:$("#abbreviation").val(),
			employee_id:$("#employee_id").val(),
			seller_name:$("#seller_name").val(),
			position:$("#position").val(),
			company_id:$("#company_id").val(),
			department:$("#department").val(),
			tel:$("#tel").val(),
			extension:$("#extension").val(),
			email:$("#email").val(),
			a:'<?php echo $a?>'};	
			if(act == 1){
				ProWestecAjax.Insert(page);
			}else if(act == 2){
				ProWestecAjax.Update(page);
			}			
		}
	}
	
	function GetDepartment(company_id){
		page.queryString = { a:'get-department-list','company_id':company_id};
		$.post("department.modify.php",page.queryString,function(jData){
			
			var profile = JSON.parse(jData);
			var department = document.getElementById("department");
			department.disabled = false;
			department.options.length = 0;
			
			for(var i=0; i < profile.length ; i++){
				
				department.options[department.options.length] = new Option(profile[i].profile_name, profile[i].profile_id);
			}
		});
	}
</script>
</head>
<body>
<div class="header"> 
   	<?php include("../utilities/switchlang.php");?>
</div>
<div class="content">
<ul class="MenuBarHorizontal" id="MenuBar1">
        <?php include_once("../utilities/dropdownmenu.php"); ?> 
    </ul>
<div class="title modify">
 Employee [<?php echo $a?>]
</div>
<div class="action_menu modify">
 
   <a href="#" id="topCancel" class="close"><div class="sub_action_menu">Cancel</div></a>
   <a href="#" id="topSave" class="save"><div class="sub_action_menu">Save</div></a>
</div>
<div style="float:none; width:100%; display:inline-table; height:30px">
<hr style="border-top:1px solid #999; border-collapse:collapse;" />
</div>
<div class="wrap-form">
<form id="#frmemployee" class="border"><table width="50%" height="300px" style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" align="center">		
<tr><td colspan="2" class="center"><font color="#FF0000">*</font> <em>Require field, please fill all require fields before save.</em></td></tr>
		<tr>
		  <td class="right" width="40%">Abbreviation (<font color="#FF0000">*</font>):</td><td class="left"> <input type="text" id="abbreviation" tabindex="1" size="30"></td> </tr>
		 <input type="hidden" id="employee_id" tabindex="2" size="30" readonly>
		<tr>
		  <td class="right">Employee Name (<font color="#FF0000">*</font>):</td><td class="left"> <input type="text" id="seller_name" tabindex="3" size="30"></td> </tr>
		<tr>
		  <td class="right">Position:</td><td class="left"> <input type="text" id="position" tabindex="4" size="30"></td> </tr>
        
        <tr>
		  <td class="right">Company Name(<font color="#FF0000">*</font>):</td><td class="left"> <select id="company_id" name="company_id">
          		<?php
				$company->GetcompanyCombo();
				
				?>
          </select></td> </tr>
          
		<tr>
		  <td class="right">Department (<font color="#FF0000">*</font>):</td><td class="left"> 
          <?php
				
				$rs =	$profiles->GetprofilesTree("");
				
		?>
          <select id="department" name="department">
          		<?php
					
				echo "<option value='0'>Select</option>";	
				while($dr = $rs->FetchRow()){
					echo "<option value='".$dr["profile_id"]."'>".$dr["profile_name"]."</option>";	
				}
				?>
          </select></td> </tr>
		<tr>
		  <td class="right">Tel (<font color="#FF0000">*</font>):</td><td class="left"> <input type="text" id="tel" tabindex="6" size="30"></td> </tr>
		<tr>
		  <td class="right">Extension:</td><td class="left"> <input type="text" id="extension" tabindex="7" size="30"></td> </tr>
		<tr>
		  <td class="right">Email:</td><td class="left"> <input type="text" id="email" tabindex="8" size="30"></td> </tr>
<tr><td colspan="2" align="center" style="text-align:center"> </td></tr></table><input type="button" value="Save" id="btSave" tabindex="8" > &nbsp;<input type="button" value="Cancel" id="btCancel" tabindex="9" ></form> 
<div id="displaymgs"></div>
</div>
</div>
<div class="footer">
	<?php include("../utilities/footer.php"); ?>
</div>

</body>
</html>