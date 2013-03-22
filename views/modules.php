<?php
session_start();
require_once("../adodb/adodb.inc.php");
include_once('../adodb/adodb-pager.inc.php'); 
require_once("../utilities/db.config.php");
require_once("../utilities/functions.php");
require_once("../utilities/class.paging.php");

require_once("../models/modules.php");

IdleTimeOut($_SESSION["username"],"views/modules.php");

$position = empty($_REQUEST["position"])?0:$_REQUEST["position"]; 
$q = empty($_REQUEST["tbkeyword"])?"":$_REQUEST["tbkeyword"];

$modules = new modules(19,"modules",3);
require_once("../models/permission.php");
$permission = new permission(20,"permission",3);
$permission = $permission->GetpermissionInfo($_SESSION["username"],"modules"); 

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title><?php echo $config["project"]; ?> - Module</title> 
	<?php 
		require_once("../utilities/header.php"); 
	?>
	<script type="text/javascript"> 
		page.url = "../controllers/modules.modify.php?position=<?php echo $position?>"; 
		page.numRecord = "hdRecord"; 
		page.currentPage = 0; 
		page.display = "renderData"; 
		page.url_request = "modules.php"; 
		page.position = '<?php echo $position?>';
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
			$("#bottomDelete").click(function(){gotoDelete();});
			$("#topEdit").click(function(){gotoEdit();}); 
			$("#bottomEdit").click(function(){gotoEdit();}); 
			$("#tbkeyword").val("<?php echo $q?>");
			$("#btnSearch").click(function(){gotoSearch();});
		});
		function gotoSearch(){
			if(Security.full==1 || Security.list ==1){
				document.location.href = "modules.php?&tbkeyword=" + $("#tbkeyword").val();
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
			} 
		}
		function gotoEdit(){ 
			if(Security.full==1 || Security.edit ==1){
				var frm = document.adminForm;
 				for(i=0; i<frm.elements.length; i++) 
				{ 
					if(frm.elements[i].type=="checkbox") 
					{ 
						if(frm.elements[i].checked==true && frm.elements[i].name == "group"){ 
							if(frm.elements[i].value!=""){ 
								var module_id = frm.elements[i].value; 
								var a = "Edit"; 
								document.location.href = "../controllers/modules.php?module_id="+module_id+"&a="+a+"&position="+page.position;
							} 
						} 
					}
				}
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
			} 
		}
		function gotoAddNew(){ 
			if(Security.full==1 || Security.add ==1){	
				var module_id = 0; 
				var a = "New"; 
				document.location.href = "../controllers/modules.php?module_id="+module_id +"&a="+a; 
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
			}
		} 
		function gotoDelete(){ 
			if(Security.full==1 || Security.del ==1){	
				var frm = document.adminForm; 
				var id = "";
				for(i=0; i<frm.elements.length; i++) 
				{ 
					if(frm.elements[i].type=="checkbox") 
					{ 
						if(frm.elements[i].checked==true && frm.elements[i].name == "group"){ 
							if(frm.elements[i].value!=""){ 
								id += frm.elements[i].value+",";
							}
						}
					} 
				}
				
				if(confirm("Do you want to delete modules?")==true){
					page.queryString = {module_id:id.substr(0, id.lastIndexOf(',')),a:'delete'}; 
					page.msg = true;			 
					tz.Delete(page); 	
				}
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
			} 
		} 
		function click_check(module_id,obj){ 
			if(Security.full==1 || Security.edit ==1){
				if(obj.checked==true){	
				
					page.queryString = {module_id:module_id,active:1,a:'check'};
					$.post(page.url, page.queryString ,function(data){  });
					
				}else{
				
					page.queryString = {module_id:module_id,active:0,a:'check'};
					$.post(page.url, page.queryString ,function(data){ });		
				}
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
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
	<form name="adminForm" id="adminForm" action="modules.php" method="post"> 
		<div style="display:block; width:100%; border-bottom: 1px solid #dcdcdc; height:50px;"><div class="title"><?php print("Modules List"); ?></div><div class="action_menu"> 
            <a href="index.php" id="topClose"><div class="sub_action_menu"><?php print("Close"); ?></div></a>
            <a href="#" id="topDelete" style="display:none"><div class="sub_action_menu"><?php print("Delete"); ?> </div></a>  
            <a href="#" id="topEdit" style="display:none"><div class="sub_action_menu">	<?php print("Edit"); ?> </div></a>  
            <a href="#" id="topAdd"><div class="sub_action_menu"><?php print("New"); ?></div> </a> 
		</div> 
        </div> 
			<div class="search"> 
				<div class="column"><input type="button" id="btnSearch" name="btnSearch" value="<?php print("Search"); ?>" /></div> <div class="column"><?php print("Keyword"); ?> : <input type="text" id="tbkeyword" name="tbkeyword" /></div> 
				
			</div> 
			<input type="hidden" id="hdRecord" name="hdRecord"> 
		<div id="renderData"> 
		<?php  
			if($permission->full ==1 or $permission->list ==1 ){
				
				$modules->GetmodulesList($position,$q);
			}else{ 
				echo "<span class='validate'>You don't have permission, please contact to administator!</span>";
			}
		?> 
			</div> 
			 
		
	</form> 
</div>
<div class="footer"><?php include("../utilities/footer.php"); ?></div>
</body></html>