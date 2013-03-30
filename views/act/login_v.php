<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
</head>

<script language="javascript">
	function login(){
		var user_name = document.getElementById('txtuser_name').value;
		var pwd = document.getElementById('txtpwd').value;
		
		if(user_name==""){
			alert("User Name and Password Cannot be blank.");
			return false;
		}else if(pwd == ""){
			alert("User Name and Password Cannot be blank.");
			return false;
		}else{
			return true;
		}
	}

</script>

<body> 
<?php echo isset($erro)?$erro:''; ?>
<form method="post" onsubmit="return login(); false" enctype="multipart/form-data">
	<table width="350px" align="center" > 
		<tr>
			<td><?php echo $_GET['s'];?></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><font style="color:#00C; font-size:20px; font-weight:700;" face="arial">Log In</font></td>
		</tr>
		<tr>
			<td><hr style="border:1px #333333 solid;" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><font style="font-size:11px;" face="arial">Please Log In, You have user and password yet?</font></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><font style="color:#333333; font-size:12px; font-weight:700;" face="arial">User Name</font></td>
		</tr>
		<tr>
			<td><input type="text" id="txtuser_name" name="txtuser_name" tabindex="1" style="width:350px;font-family:Arial; font-size:14px; font-weight:bold;"/> </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><font style="color:#333333; font-size:12px; font-weight:700;" face="arial">Password</font>&nbsp; 
            <a href="index.php?f=act&p=forgot_password" style="color:#00C; font-size:11px;">Forget password?</a>&nbsp; </td>
		</tr>
		<tr>
			<td><font color="#333333" face="arial">
            <input type="password" tabindex="2" id="txtpwd" name="txtpwd" style="width:350px" /></font></td>
		</tr>
		<tr>
			<td align="right">&nbsp;</td>
		</tr>
		<tr>
			<td><button type="submit" name="is_submit" tabindex="3">Login</button>&nbsp;&nbsp;or&nbsp;&nbsp;
            <label style="color:#333333; font-size:12px;">Create new account</label>&nbsp;
            <a href="index.php?f=act&p=sign_up" tabindex="4" style="color:#00C; font-size:12px;">Sign Up</a></td>
		</tr> 
	</table>
</form>


</body>
</html>
