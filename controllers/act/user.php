<?php session_start();
include_once('../../adodb/adodb.inc.php');
include_once("../../utilities/db.config.php");
require_once("../../utilities/class.paging.php");
require_once("../../models/user.php"); 
require_once("../../models/department.php"); 
require_once("../../customizes/department.custom.php");
require_once("../../models/employee.php");
require_once("../../customizes/employee.custom.php");
require_once("../../models/company.php");
require_once("../../utilities/functions.php");
IdleTimeOut($_SESSION["username"],"models/user.php");

require_once("../../models/permission.php");
$permission = new permission(20,"permission",3);
 $employee_custom = new employee_custom(20,"employee",3);
	$profiles_custom = new profiles_custom(20,"profiles",3);
	$company = new company(20,"company",3);
	$user = new user(20,"user",3);
	$a = $_REQUEST["a"];

	$user->user_name = $_REQUEST["user_name"];
	$user = $user->GetuserInfoByuser_name($user); 
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $config["system_name"] ?> - User</title>
	<?php 
	include_once("../../utilities/header.php"); 
	?>
	
	<script type="text/javascript">
		page.url = "user.modify.php";
		page.display = "displaymgs";
		page.url_request = "../views/user.php?position=<?php echo $position?>";
		var a = "<?php echo $a?>";
		
		$(function(){			
	
		SetDateTimePicker("expired_date");
		
		if(a=="New"){
			$("#user_name").removeAttr("readonly");
			$("#user_name").focus();
		}else if(a == "Edit"){	
			var s = "<?php echo $user->diabled ;?> "; 
			if(s==1)$("#diabled").attr("checked",true);
		
			var department = document.getElementById("profile_id");
				department.disabled = false;
			var employee_list = document.getElementById("employee_id");
				employee_list.disabled = false;	
			$("#user_name").val("<?php echo $user->user_name ?>");
			
			$("#olduser_name").val("<?php echo $user->user_name ?>");
			$("#full_name").val("<?php echo $user->full_name ?>");
			$("#description").val("<?php echo $user->description ?>");
			$("#password").val("<?php echo $user->password ?>");
			$("#company_id").val("<?php echo $user->company_id ?>");
			$("#profile_id").val("<?php echo $user->profile_id ?>");
			$("#employee_id").val("<?php echo $user->employee_id ?>");
			$("#expired_date").val("<?php echo formatDate($user->expired_date,2); ?>");
			
			$("#language").val("<?php echo $user->language ?>");
		}
		$("#btSave").click(function() { 
			if(a=="Edit"){Validate(2);}else{Validate(1);}
		});
		$("#topSave").click(function() {						 
			if(a=="Edit"){Validate(2);}else{Validate(1);}
		});
		$("#topCancel").click(function(){
			document.location.href = "../views/user.php";		
		});
		$("#btCancel").click(function(){
			document.location.href = "../views/user.php";	
		});
	
	$("#user_name").change(function(){
		if($("#user_name").val() != $("#olduser_name").val() ){								
			$.post("user.modify.php",{a:'valid',user_name: $("#user_name").val(),olduser_name : $("#olduser_name").val() } , function(data){
																													  
				if(data == "1"){
					alert("Username already exist in system please change");
					$("#user_name").focus();
				}
			});
		}
 	});
	
 	});
 	function Validate(act){		
		if( $("#user_name").val()==""){ 
			MessageBox.Show("Please enter your username ");
			$("#user_name").focus();
			return; 
		}		else if( $("#full_name").val()==""){ 
			MessageBox.Show("Please enter your full name ");
			$("#full_name").focus();
			return; 
		}
		else if( $("#password").val()==""){ 
			MessageBox.Show("Please enter your password ");
			$("#password").focus();
			return; 
		}else if( $("#profile_id").val()==0){ 
			MessageBox.Show("Please select profile name ");
			$("#profile_id").focus();
			return; 
		}
		else{ 
				if($("#diabled").attr("checked"))
					var s=1;
				else 
					var s=0;
					
			page.queryString = { 
				user_id:$("#user_id").val(),
				user_name:$("#olduser_name").val(),
				new_user:$("#user_name").val(),
				full_name:$("#full_name").val(),
				description:$("#description").val(),
				password:$("#password").val(),
				employee_id:$("#employee_id").val(),
				diabled:s,
				expired_date:GetDateTime("expired_date"),
				company_id:$("#company_id").val(),
				profile_id:$("#profile_id").val(),
				language:$("#language").val(),
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
			var department = document.getElementById("profile_id");
			department.disabled = false;
			department.options.length = 0;
			
			for(var i=0; i < profile.length ; i++){
				
				department.options[department.options.length] = new Option(profile[i].profile_name, profile[i].profile_id);
			}
		});
	}
	
	function GetEmployee(company_id,department_id){
		page.queryString = { a:'get-employee-list','department_id':department_id,'company_id':company_id};
		$.post("employee.modify.php",page.queryString,function(jData){
		
			var employee = JSON.parse(jData);
			var employee_list = document.getElementById("employee_id");
			employee_list.disabled = false;
			employee_list.options.length = 0;
			
			for(var i=0; i < employee.length ; i++){
				employee_list.options[employee_list.options.length] = new Option(employee[i].seller_name, employee[i].employee_id);
			}
			
		});
	}
</script>
</head>
<body>
<div class="header"> 
   	<?php include("../../utilities/switchlang.php");?>
</div>
<div class="content">
<ul class="MenuBarHorizontal" id="MenuBar1">
        <?php include_once("../../utilities/dropdownmenu.php"); ?> 
    </ul>
	<div style="display:block; width:100%; border-bottom: 1px solid #dcdcdc; height:50px;"><div class="title">
		<?php print("User"); ?> [<?php echo $a?>]</div>
	</div>
	
		<form id="#frmuser" class="border">
		<table width="50%" style="border-collapse:collapse; background-color:#FFF; height:200px" border="0" cellpadding="5" cellspacing="0" align="center">	
        <input type="hidden" id="olduser_name" tabindex="1" size="30">
			<tr><td colspan="2"><font color="#FF0000">*</font> <em>Require field, before save please fill all this fields.</em></td></tr>
			<tr><td width='50%' style="text-align:right"><?php print("User Name"); ?>(<font color="#FF0000">*</font>):</td><td bgcolor="#FFFFFF" style="border:none;text-align:left"> 
            <input type="text" id="user_name" tabindex="1" size="30">
            </td> </tr>
			<tr>
            <td style="text-align:right"><?php print("Full Name"); ?>(<font color="#FF0000">*</font>):</td>
            <td bgcolor="#FFFFFF" style="border:none;text-align:left"><input type="text" id="full_name" tabindex="2" size="30"></td>
            </tr>
			<tr><td style="text-align:right"><?php print("Description"); ?>:</td><td bgcolor="#FFFFFF" style="border:none;text-align:left"> <input type="text" id="description" tabindex="3" size="30"></td> </tr>
			<tr><td style="text-align:right"><?php print("Password"); ?> (<font color="#FF0000">*</font>):</td><td bgcolor="#FFFFFF" style="border:none;text-align:left"> <input type="text" id="password" tabindex="4" size="30"></td> </tr>
			
            <tr>
		  <td class="right">Company Name(<font color="#FF0000">*</font>):</td><td class="left"> <select id="company_id" name="company_id" onChange="GetEmployee(this.value,document.getElementById('profile_id').value)">
          <option value='0'>-Select-</option>
          		<?php
				$company->GetCompanyComboforUser();
				
				?>
          </select></td> </tr>
            <tr><td style="text-align:right">Department(<font color="#FF0000">*</font>):</td><td bgcolor="#FFFFFF" style="border:none;text-align:left"> <select id="profile_id" name="profile_id" onChange="GetEmployee(document.getElementById('company_id').value,this.value)">
						
						<?php
							$rs =	$profiles_custom->GetprofilesTree($user->company_id);
							echo "<option value='0'>-Select-</option>";
							while($dr = $rs->FetchRow()){
							  echo "<option value='".$dr["profile_id"]."'>".$dr["profile_name"]."</option>";
							}
							
						?>
						
					</select>
			</td></tr>
            
            <tr><td style="text-align:right"><?php print("Employee"); ?>:</td><td bgcolor="#FFFFFF" style="border:none;text-align:left"> <select id="employee_id" name="employee_id">
						<?php
							$rs1 = $employee_custom->Get_Combobox_employee();
							echo "<option value='0'>-Select-</option>";
							while($dr = $rs1->FetchRow()){
							  echo "<option value='".$dr["employee_id"]."'>".$dr["seller_name"]."</option>";
							}
							
						?>
						
					</select>
			</td></tr>
            
			<tr><td style="text-align:right">Expiry Date:</td><td bgcolor="#FFFFFF" style="border:none;text-align:left"> <input type="text" id="expired_date" name="expired_date" tabindex="9" size="30" ></td> </tr>
	<tr style="text-align:right; display:none"><td >Language:</td><td bgcolor="#FFFFFF" style="border:none;text-align:left"> <input type="text" id="language" tabindex="9" size="10" maxlength="2" ></td> </tr>
				
			<tr><td style="text-align:right">Status:</td><td bgcolor="#FFFFFF" style="border:none;text-align:left"><input type="checkbox" id="diabled" tabindex="10" > Deactivate
            </td> </tr>
			</table>
           <input type="button" value="<?php print("Save"); ?>" id="btSave" tabindex="11" > &nbsp;<input type="button" value="<?php print("Cancel"); ?>" id="btCancel" tabindex="11" >
            </form> 
</div>
<div class="footer">
	<?php include("../../utilities/footer.php"); ?>
</div>

</body>
</html>