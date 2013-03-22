<?php
session_start();
require_once("../adodb/adodb.inc.php");
require_once("../utilities/db.config.php");
require_once("../utilities/functions.php");
require_once("../utilities/class.paging.php");
require_once("../models/user.php");


IdleTimeOut($_SESSION["username"],"views/user.php");

$position = empty($_REQUEST["position"])?0:$_REQUEST["position"]; 
$q = empty($_REQUEST["tbkeyword"])?"":$_REQUEST["tbkeyword"];


$user = new user(19,"user",3);
require_once("../models/permission.php");
$permission = new permission(20,"permission",3);
$permission = $permission->GetpermissionInfo($_SESSION["username"],"user"); 

?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
	<title><?php echo $config["project"]; ?> - User</title> 
	<?php 
		require_once("../utilities/header.php"); 
	?>
	<script type="text/javascript"> 
		page.url = "../controllers/user.modify.php?position=<?php echo $position?>"; 
		page.numRecord = "hdRecord"; 
		page.currentPage = 0; 
		page.display = "renderData"; 
		page.url_request = "user.php"; 
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
				document.location.href = "user.php?&tbkeyword=" + $("#tbkeyword").val();
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
			} 
		}
		function gotoEdit(user_name){ 
			if(Security.full==1 || Security.edit ==1){
				var a = "Edit"; 
				document.location.href = "../controllers/user.php?user_name="+user_name+"&a="+a+"&position="+page.position;
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
			} 
		}
		function gotoAddNew(){ 
			if(Security.full==1 || Security.add ==1){	
				var user_name = 0; 
				var a = "New"; 
				document.location.href = "../controllers/user.php?user_name="+user_name +"&a="+a; 
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
			}
		} 
		function gotoDelete(){ 
			if(Security.full==1 || Security.del ==1){	
				var frm = document.getElementsByName("user_group"); 
				var id = "";
				for(i=0; i<frm.length; i++) 
				{ 
					if(frm[i].type=="checkbox") 
					{ 
						if(frm[i].checked==true && frm[i].name == "user_group"){ 
							if(frm[i].value!=""){ 
								 id += frm[i].value+",";
							}
						}
					} 
				}
				
				if(confirm("Do you want to delete users?")== true){
					
					page.queryString = {user_name:id.substr(0,id.lastIndexOf(',')),a:'delete'}; 
					page.msg = true;			 
					ProWestecAjax.Delete(page); 
					
				}
				
			}else{ 
				MessageBox.Show("You don't have permission. please contact to administrator!");
			} 
		} 
		function click_check(user_name,obj){ 
			if(Security.full==1 || Security.edit ==1){
				
				if(obj.checked==true){				 
					page.queryString = {user_name:user_name,diabled:1,a:'check'};
					$.post(page.url, page.queryString ,function(data){ });
				}else{
					page.queryString = {user_name:user_name,diabled:0,a:'check'};
						$.post(page.url, page.queryString ,function(data){	});		
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
	<form name="adminForm" id="adminForm" action="user.php" method="post"> 
		<div style="display:block; width:100%; border-bottom: 1px solid #dcdcdc; height:50px;"><div class="title"><?php print("User List"); ?></div><div class="action_menu"> 
            <a href="index.php" id="topClose"><div class="sub_action_menu"><?php print("Close"); ?></div></a>
            <a href="#" id="topDelete"><div class="sub_action_menu"><?php print("Delete"); ?> </div></a>  
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
				
				$user->GetuserList($position,$q);
  			
			}else{ 
				echo "<span class='validate'>You don't have permission please contact to administror!</span>";
			}
		?> 
			
			</div> 
		
	</form> 
    </div>
<div class="footer"><?php include("../utilities/footer.php"); ?> </div>

</body></html>
