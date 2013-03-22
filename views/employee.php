<?php  
 session_start();
require_once('../adodb/adodb.inc.php'); 
require_once("../utilities/db.config.php"); 
require_once("../utilities/functions.php");
require_once("../utilities/class.paging.php");
require_once("../models/employee.php"); 
$position = empty($_REQUEST["position"])?0:$_REQUEST["position"]; 
$q = empty($_REQUEST["q"])?"":$_REQUEST["q"]; 

$employee = new employee(19,"employee",3); 

IdleTimeOut($_SESSION["username"],"views/employee.php");
require_once("../models/permission.php");
$permission = new permission(18,"permission",3);
$permission = $permission->GetpermissionInfo($_SESSION["username"],"employee"); 

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title><?php echo $config["project"] ?> - Employee</title> 
<?php
require_once("../utilities/header.php");
?>
<script type="text/javascript"> 
	page.url = "../controllers/employee.modify.php"; 
	page.numRecord = "hdRecord"; 
	page.currentPage = 0; 
	page.display = "renderData"; 
	page.url_request = "employee.php?position=<?php echo $position?>"; 
	
	/*Variable Permission*/
	Security.full = "<?php echo $permission->full?>";
	Security.add = "<?php echo $permission->add?>";
	Security.edit = "<?php echo $permission->edit?>";
	Security.list = "<?php echo $permission->list?>";
	Security.del = "<?php echo $permission->delete?>";
	
	$(function(){		    
		 $("#topAdd").click(function(){gotoAddNew();}); 
		 $("#bottomAdd").click(function(){gotoAddNew();}); 
		 $("#topDelete").click(function(){gotoDelete();});	 
		 $("#topEdit").click(function(){gotoEdit();}); 
		 $("#bottomEdit").click(function(){gotoEdit();}); 
	}); 
	
	function gotoEdit(employee_id){ 
		if(Security.full==1 || Security.edit ==1){
			var a = "Edit"; 
		    document.location.href = "../controllers/employee.php?employee_id="+employee_id + "&a="+a; 
		}else{
			MessageBox.Show("You don't have permission to edit employee!");
		}
	} 
	function gotoAddNew(){ 
		if(Security.full==1 || Security.add ==1){
			
			var customer_id = 0; 
			var a = "New"; 
			document.location.href = "../controllers/employee.php?customer_id="+customer_id +"&a="+a;
		}else{
				MessageBox.Show("You don't have permission to add new employee!");
			}
			
	} 
	function gotoDelete(){ 
		if(Security.full==1 || Security.del ==1){
			var frm = document.getElementsByName("employee_group"); 
				var id = "";
				for(i=0; i<frm.length; i++) 
				{ 
					if(frm[i].type=="checkbox") 
					{ 
						if(frm[i].checked==true && frm[i].name == "employee_group"){ 
							if(frm[i].value!=""){ 
								id +=frm[i].value+",";	
							}
						}
					} 
				}
				
				if(confirm("Do you want to delete employee(s)?")== true){
					
					page.queryString = {employee_id:id.substr(0,id.lastIndexOf(',')),a:'delete'}; 
					page.msg = false;			 
					ProWestecAjax.Delete(page); 
				}
		}else{
				MessageBox.Show("You don't have permission to delete employee!");
			}
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
<form name="adminForm" id="adminForm" action="employee.php" method="post"> 
<div style="display:block; width:100%; border-bottom: 1px solid #dcdcdc; height:50px;"><div class="title">Employee List</div> 
 
<div class="action_menu"> 	 
<a href="index.php" id="topClose" class="close"><div class="sub_action_menu">Close</div></a>
<a href="#" id="topDelete"><div class="sub_action_menu">Delete</div></a>   
<a href="#" id="topAdd"><div class="sub_action_menu">New</div></a> 
</div> 
</div>
<div class="search">
	<div class="column"><input type="submit" value="Search" id="btSearch" /></div>
	<div class="column">Keyword : <input type="text" id="tbkeyword" name="q" value="<?php echo $q?>" /></div> 
</div>
<input type="hidden" id="hdRecord" name="hdRecord"> 
<div id="renderData"> 
<?php  
	if($permission->full==1 or $permission->list==1){	
		$employee->GetemployeeSearchList($position,$q);
	}else{
		echo "<span class='validate'>Your don't have permission to view seller!</span>";
	}
?> 
</div> 
<input type="hidden" name="boxchecked" id="boxchecked" value="0" /> 
<input type="hidden" name="customer_id" id="customer_id" value="0" /> 

 </form> </div>
<div class="footer"><?php include("../utilities/footer.php"); ?> </div>

</body></html>