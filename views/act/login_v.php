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
<form action="../controllers/login_c.php" method="post" onsubmit="return login(); false" enctype="multipart/form-data">
	<table width="350px" align="center" > 
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><font style="color:#00C; font-size:30px;" face="arial">Log In</font></td>
		</tr>
		<tr>
			<td><hr  style="border:1px #333333 solid;" /></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><font color="#333333" face="arial" size="2">Please Log In, You have user and password yet?</font></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><font color="#333333" face="arial">User Name</font></td>
		</tr>
		<tr>
			<td><input type="text" id="txtuser_name" name="txtuser_name" style="width:350px;font-family:Arial; font-size:14px; font-weight:bold;"/> </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td><font color="#333333" face="arial">Password</font></td>
		</tr>
		<tr>
			<td><font color="#333333" face="arial"><input type="password" id="txtpwd" name="txtpwd" style="width:350px" /></font></td>
		</tr>
		<tr>
			<td align="right"><a style="color:#00C; font-size:13px;text-decoration:none;">Forget password?</a></td>
		</tr>
		<tr>
			<td> <input type="submit" value="Log In"  style="width:100px;" /> &nbsp; &nbsp; &nbsp;
            <label style="color:#333333; font-size:13px;">Create new account </label>
            <a style="color:#00C; font-size:13px; text-decoration:none;">Sign Up</a></td>
		</tr> 
	</table>
</form>


</body>
</html>
