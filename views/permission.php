<?php
 session_start();
require_once('../adodb/adodb.inc.php'); 
require_once("../utilities/db.config.php"); 
require_once("../utilities/functions.php");
require_once("../utilities/class.paging.php");
require_once("../models/department.php"); 
require_once("../customizes/department.custom.php");
require_once("../models/modules.php"); 

IdleTimeOut($_SESSION["username"],"views/permission.php");

$profiles = new profiles(20,"profiles",3);
$profiles_custom = new profiles_custom(20,"profiles",3);

require_once("../models/permission.php");
$permission = new permission(20,"permission",3);
$permission = $permission->GetpermissionInfo($_SESSION["username"],"permission"); 

$position = empty($_REQUEST["position"])?0:$_REQUEST["position"];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html> 
<head> 
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
<title><?php echo $config["project"]; ?> - Permission</title> 
<?php 
require_once("../utilities/header.php"); 
?> 

<script type="text/javascript"> 
	
	page.url = "../controllers/permission.modify.php"; 
	page.numRecord = "hdRecord"; 
	page.currentPage = 0;
	page.display = "renderData"; 
	page.url_request = "permission.php";
	
	
	Security.full = "<?php echo $permission->full?>";
	Security.add = "<?php echo $permission->add?>";
	Security.edit = "<?php echo $permission->edit?>";
	Security.list = "<?php echo $permission->list?>";
	Security.del = "<?php echo $permission->delete?>";
	
	
	$(function(){	
			   
		$("#accordion").accordion({
			header: "h4"
		});
	}); 
	
	function FullPermission(permission_id, module_id, profile_id , obj ){
		
		if(Security.full ==1 || Security.edit ==1 || Security.add == 1){ 	 
			page.queryString = {permission_id:permission_id,module_id:module_id, full :(obj.checked)?1:0 ,profile_id:profile_id,a:'full'};
	
			$.post(page.url, page.queryString ,function(data){
				//alert(data);
			});
		
		}else{
			MessageBox.Show("You don't have permission. please contact to administrator!");
		}
	
	} 
	
	function AddPermission(permission_id, module_id, profile_id , obj ){
		 if(Security.full ==1 || Security.edit ==1 || Security.add == 1){ 
			page.queryString = {permission_id:permission_id,module_id:module_id,add:(obj.checked)?1:0,profile_id:profile_id,a:'add'};
	
			$.post(page.url, page.queryString ,function(data){	
				//alert(data);
			});
		}else{
			MessageBox.Show("You don't have permission. please contact to administrator!");
		}
	
	} 
	
	function EditPermission(permission_id, module_id, profile_id , obj ){
		if(Security.full ==1 || Security.edit ==1 || Security.add == 1){ 	 
			page.queryString = {permission_id:permission_id,module_id:module_id,edit:(obj.checked)?1:0,profile_id:profile_id,a:'edit'};
	
			$.post(page.url, page.queryString ,function(data){	
				//alert(data);
			});
		}else{
			MessageBox.Show("You don't have permission. please contact to administrator!");
		}
	
	}
	
	function DeletePermission(permission_id, module_id, profile_id , obj ){
		 if(Security.full ==1 || Security.edit ==1 || Security.add == 1){ 
			page.queryString = {permission_id:permission_id,module_id:module_id,delete:(obj.checked)?1:0,profile_id:profile_id,a:'delete'};
	
			$.post(page.url, page.queryString ,function(data){	
				//alert(data);
			});
		}else{
			MessageBox.Show("You don't have permission. please contact to administrator!");
		}
	} 
	
	function ListPermission(permission_id, module_id, profile_id , obj ){
		
		 if(Security.full ==1 || Security.edit ==1 || Security.add == 1){ 
		
			page.queryString = {permission_id:permission_id,module_id:module_id,list:(obj.checked)?1:0,profile_id:profile_id,a:'list'};
	
			$.post(page.url, page.queryString ,function(data){	
				//alert(data);
			});
		
		}else{
			MessageBox.Show("You don't have permission. please contact to administrator!");
		}

	
	} 
	
	function iSFullPermission(fullName, AddName , EditName, DeleteName, ListName){
		
		if(document.getElementById(fullName).checked)
		{
			document.getElementById(AddName).disabled = true;
			document.getElementById(EditName).disabled = true;
			document.getElementById(DeleteName).disabled = true;
			document.getElementById(ListName).disabled = true;
		}else{
			document.getElementById(AddName).disabled = false;
			document.getElementById(EditName).disabled = false;
			document.getElementById(DeleteName).disabled = false;
			document.getElementById(ListName).disabled = false;	
		}
		
		
	}
	
	
	function iSNotFullPermission(fullName, AddName , EditName, DeleteName, ListName){
		
		
		if(document.getElementById(AddName).checked == true &&
			document.getElementById(EditName).checked == true &&
			document.getElementById(DeleteName).checked == true &&
			document.getElementById(ListName).checked == true)
		{
			document.getElementById(fullName).checked = true;	
			document.getElementById(AddName).disabled = true;
			document.getElementById(EditName).disabled = true;
			document.getElementById(DeleteName).disabled = true;
			document.getElementById(ListName).disabled = true;
		}else{
			document.getElementById(fullName).checked = false;	
			document.getElementById(AddName).disabled = false;
			document.getElementById(EditName).disabled = false;
			document.getElementById(DeleteName).disabled = false;
			document.getElementById(ListName).disabled = false;	
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
    <div class="title" style="font-family:'Khmer OS'; font-size:18px">Permission to Department</div> 
    <div style="width:233px; display:inline-table; height:31px; position:relative"> 
     
    </div> 
<form name="adminForm" id="adminForm"> 
<input type="hidden" id="hdRecord" name="hdRecord">

<div id="renderData">

<div id="accordion" style="padding:6px; width:99%">       
	<?php 
 
		$j=1;
		if($permission->full ==1 or $permission->list ==1 ){
	
  		$rs =  $profiles_custom->GetprofilesTree("");
		
        while($dr = $rs->FetchRow()){ 
			
			echo "<h4><a href='#' style='text-align:left;'>".$dr["profile_id"]."-".$dr["profile_name"].'-'.$dr["company_name"]."</a></h4>";
			
			$permission->profile_id = $dr["profile_id"];
 			
			$res = $permission->GetpermissionObject($permission);
			
			echo "<div><table table border='1' cellspacing='0' cellpadding='3' id='tz-table' align='center'><thead><tr><th>Module Name</th><th style='width:90px'>Full Control</th>
			<th style='width:90px'>Add New</th><th style='width:90px'>Edit</th><th style='width:90px'>Delete</th>
			<th style='width:90px'>List</th></tr></thead>";
			
			 while($dr1 = $res->FetchRow()){
				 $disabled_add = "";$disabled_edit = "";$disabled_delete = "";$disabled_list = "";
				$full = ""; if($dr1["full"] == 1){ $full = "checked";  $disabled_add = "disabled";$disabled_edit = "disabled";$disabled_delete = "disabled";$disabled_list = "disabled"; }
				$add = ""; if($dr1["add"] == 1){ $add = "checked"; }
				$list = ""; if($dr1["list"] == 1){ $list = "checked"; }
				$delete = ""; if($dr1["delete"] == 1){ $delete = "checked"; }
				$edit = ""; if($dr1["edit"] == 1){ $edit = "checked"; }
				  
				  echo "<tr class='rowhover'><td class='left'>".$dr1["module_id"]." - ".$dr1["module_name"]."</td>";
					  echo "<td class='center'>
					  <input type='checkbox' id='full".$j."' name='full".$j."'  $full value='".$dr1["permission_id"]."' onclick=\"FullPermission('".$dr1["permission_id"]."','".$dr1["module_id"]."','".$permission->profile_id."',this);iSFullPermission('full".$j."','add".$j."','edit".$j."','delete".$j."','list".$j."')\" /></td>";
					  
					  echo "<td class='center'><input type='checkbox' $add id='add".$j."' name='add".$j."' value='".$dr1["permission_id"]."' onclick=\"AddPermission('".$dr1["permission_id"]."','".$dr1["module_id"]."','".$permission->profile_id."',this);iSNotFullPermission('full".$j."','add".$j."','edit".$j."','delete".$j."','list".$j."')\" $disabled_add /></td>";
					  
					  echo "<td class='center'><input type='checkbox' $edit id='edit".$j."' name='edit".$j."' value='".$dr1["permission_id"]."' onclick=\"EditPermission('".$dr1["permission_id"]."','".$dr1["module_id"]."','".$permission->profile_id."',this);iSNotFullPermission('full".$j."','add".$j."','edit".$j."','delete".$j."','list".$j."')\" $disabled_edit /></td>
					 ";
					   echo "<td class='center'><input type='checkbox' $delete id='delete".$j."' name='delete".$j."' value='".$dr1["permission_id"]."' onclick=\"DeletePermission('".$dr1["permission_id"]."','".$dr1["module_id"]."','".$permission->profile_id."',this);iSNotFullPermission('full".$j."','add".$j."','edit".$j."','delete".$j."','list".$j."')\" $disabled_delete /></td>
					 ";
					   echo "<td class='center'><input type='checkbox' $list id='list".$j."' name='list".$j."' value='".$dr1["permission_id"]."' onclick=\"ListPermission('".$dr1["permission_id"]."','".$dr1["module_id"]."','".$permission->profile_id."',this);iSNotFullPermission('full".$j."','add".$j."','edit".$j."','delete".$j."','list".$j."')\" $disabled_list /></td>
					  </tr>";
				$j++;
				$full = "";
				$add = "";
				$delete = "";
				$list = "";
				$edit = "";
				
			 }
			echo "</table></div>";
		}
	}else{
		echo "<span class='validate'>You don't have permission, please contact to administator!</span>";	
	}
    ?>     
</div>

</div> 
<input type="hidden" name="boxchecked" id="boxchecked" value="0" /> 
<input type="hidden" name="customer_id" id="customer_id" value="0" /> 
</form> 
</div>
<div class="footer"><?php include("../utilities/footer.php"); ?></div>

</body></html>