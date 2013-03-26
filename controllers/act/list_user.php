<?php 
	include_once('models/act/sign_up_m.php');
	
	$obj->account_id = isset($_POST["account_id"])?$_POST["account_id"]:''; 
	if($obj->account_id!=''){
		sign_up::Delete($obj);
		header('location:index.php?f=act&p=list_user');
	}
	$_result = sign_up::UserList();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>List accounts </title>
</head>
<script language="javascript" type="text/javascript">
	/*$("#btncreateaccount").live('click', function() {
   	MessageBox.Show("You don't have permission. please contact to administrator!");
});*/

	function gotoDelete(account_id){
		if(confirm('Are you suer, you want to delete this user account?')){ 
			$('#account_id').val(account_id);
			$('#frmlist_user').submit();
			return true;
		}else{
			return false;
		}
	}


</script> 

<body>
 

<form id="frmlist_user" method="post" enctype="multipart/form-data"> 
	<input type="hidden" id="account_id" name="account_id" value="" />
    <div style="float:left; width:150px; border:1px #CCC solid; margin-right:5px;">
    	<a href="index.php?f=act&p=sign_up" style="text-decoration:none"><div class="text_signup mouse_hover">New User</div></a>
        <a href="index.php?f=act&p=list_user" style="text-decoration:none"><div class="text_signup mouse_hover">List Users</div></a>
    </div>
    <div style="float:left; width:423px; border:0px #CCC solid; padding:0px;">  
        <?php echo $_result; ?> 
    </div>
    </form>
 
</body>
</html>