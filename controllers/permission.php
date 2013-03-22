<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"><title>ProWestec - permission</title>
<?php session_start();
include_once("header1.php"); 
include_once('../adodb/adodb.inc.php');
require_once("../utilities/functions.php");
require_once("../utilities/class.paging.php");
include_once("../utilities/db.config.php");
require_once("../models/permission.php");
$permission = new permission(20,"permission",3);
$a = $_REQUEST["a"];
$permission->permission_id = $_REQUEST["customer_id"];
$permission = $permission->GetpermissionInfoBypermission_id($permission); ?>
<script type="text/javascript" src="../js/prowestec.js"></script>
<script type="text/javascript">
	page.url = "permission.modify.php";
	page.display = "displaymgs";
	page.url_request = "../views/permission.php";
	$(function(){			
		var a = "<?php echo $a?>";
		if(a=="New"){
			$("#permission_id").val("<?php echo $permission->Getpermission_id();?>");	
		}else if(a == "Edit"){	
 $("#permission_id").val("<?php echo $permission->permission_id ?>");
 $("#group_user_id").val("<?php echo $permission->group_user_id ?>");
 $("#module_id").val("<?php echo $permission->module_id ?>");
 $("#access_modify").val("<?php echo $permission->access_modify ?>");
}
 $("#btSave").click(function() { 
 	if(a=="Edit"){Validate(2);}else{Validate(1);}
 });
   $("#topSave").click(function() {						 
 	if(a=="Edit"){Validate(2);}else{Validate(1);}
 });
  $("#topCancel").click(function(){
 	document.location.href = "../views/permission.php";		
  });
  $("#btCancel").click(function(){
 	document.location.href = "../views/permission.php";	
  });
 });
 function Validate(act){		
if( $("#permission_id").val()==""){ 
    MessageBox.Show("Please retry to get new permission_id ");
    $("#permission_id").focus();
    return; 
}else if( $("#group_user_id").val()==""){ 
    MessageBox.Show("Please retry to get new group_user_id ");
    $("#group_user_id").focus();
    return; 
}else if( $("#module_id").val()==""){ 
    MessageBox.Show("Please retry to get new module_id ");
    $("#module_id").focus();
    return; 
}else if( $("#access_modify").val()==""){ 
    MessageBox.Show("Please retry to get new access_modify ");
    $("#access_modify").focus();
    return; 
}	else{ 
		page.queryString = { 
permission_id:$("#permission_id").val(),
group_user_id:$("#group_user_id").val(),
module_id:$("#module_id").val(),
access_modify:$("#access_modify").val(),
					a:'<?php echo $a?>'};	
if(act == 1){
	ProWestecAjax.Insert(page);
}else if(act == 2){
	ProWestecAjax.Update(page);
}			
}
}
</script>
</head>
<body style="margin:0px; text-align:center">
<div class="header">
<div class="banner">
<div style="float:left;">
<h2><a href="../index.php"><img src="../images/logo1.jpg" alt="" width="212" height="61" /></a></h2></div><div style="float:right"><h2><strong class="h1">ProWestec Welcome</strong></h2>
<?php require_once("../utilities/loginmenu.php"); ?>
</div>
</div>
<div class="menu">
<ul class="MenuBarHorizontal" id="MenuBar1">
<?php include_once("../utilities/dropdown-menu1.php"); ?>
</ul>
</div>
</div>
<div id="container">
<div style="float:left">
<h3>  permission [<?php echo $a?>]</h3>
</div>
<div class="action_menu">
  <div class="sub_action_menu"><a href="#" id="topSave"><img src="../images/filesave.png" width="32" height="32"><br>Save</a></div>
   <div class="sub_action_menu"><a href="#" id="topCancel"><img src="../images/cancel.png" width="32" height="32"><br>Cancel</a></div>
   <div class="sub_action_menu"><a href="#" id="topHelp"><img src="../images/help.png" width="32" height="32"><br>Help</a></div>
</div>
<div style="float:none; width:100%; display:inline-table; height:30px">
<hr style="border-top:1px solid #999; border-collapse:collapse;" />
</div>
<div class="wrap-form">
<form id="#frmpermission" class="border"><table width="50%" style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" frame="box" align="center">		
<tr><td colspan="2"><font color="#FF0000">*</font> <em>Require field, before login please fill all this fields.</em></td></tr>
		<tr>
		  <td class="right" width='40%'>Permission ID (<font color="#FF0000">*</font>):</td><td > <input type="text" id="permission_id" tabindex="1" size="30" readonly></td> </tr>
		<tr>
		  <td class="right">Profile (<font color="#FF0000">*</font>):</td><td > <input type="text" id="group_user_id" tabindex="2" size="30"></td> </tr>
		<tr>
		  <td class="right">Module (<font color="#FF0000">*</font>):</td><td > <input type="text" id="module_id" tabindex="3" size="30"></td> </tr>
		<tr>
		  <td class="right">Access Modify (<font color="#FF0000">*</font>):</td><td > <input type="text" id="access_modify" tabindex="4" size="30"></td> </tr>
<tr><td colspan="2" align="center" style="text-align:center"> <input type="button" value="Save" id="btSave" tabindex="4" > &nbsp;<input type="button" value="Cancel" id="btCancel" tabindex="5" ></td></tr></table></form> 
<div id="displaymgs"></div>
</div>
</div>
<div class="footer">
	<?php include("../utilities/footer.php"); ?>
</div>

</body>
</html>