 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create account for join the user login</title>
</head>
<script language="javascript" type="text/javascript">
	/*$("#btncreateaccount").live('click', function() {
   	MessageBox.Show("You don't have permission. please contact to administrator!");
});*/

	function addNewAccount(){
		var user_name = document.getElementById('user_name').value;
		var pwd = document.getElementById('pwd').value;
		
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
 

<form method="post" onsubmit="return addNewAccount(); false" enctype="multipart/form-data">
 	<!-- checking for visible menu user-->
	<?php if(isset($newObj->user_name)=='admin'){?>
    <div style="float:left; width:150px; border:1px #CCC solid; margin-right:5px;">
    	<a href="index.php?f=act&p=sign_up" style="text-decoration:none"><div class="mouse_hover menu">New User</div></a>
        <a href="index.php?f=act&p=list_user" style="text-decoration:none"><div class="mouse_hover">List Users</div></a>
    </div>
    <?php } ?>
    <div style="float:left; width:400px; border:1px #CCC solid; padding:10px;"> 
        <?php echo isset($erro)?$erro:''; ?>
        <div class="title">Createa Account</div>  
        
        <div class="text_signup">User name</div>    
        <div class="text_signup"><input type="text" id="user_name" name="user_name" style="width:400px;" /></div>    
        
        <div class="text_signup">Last name</div>    
        <div class="text_signup"><input type="text" id="last_name" name="last_name" style="width:400px;"/></div>
        
        <div class="text_signup">Fisrt name</div>    
        <div class="text_signup"><input type="text" id="first_name" name="first_name" style="width:400px;"/></div>    
        
        <div class="text_signup">Email address</div>    
        <div class="text_signup"><input type="text" id="email_adr" name="email_adr" style="width:400px;"/></div> 
        
        <div class="text_signup">Password</div>    
        <div class="text_signup"><input type="password" id="pwd" name="pwd" style="width:400px;"/></div> 
        
        <div class="text_signup">Confirm Password</div>    
        <div class="text_signup"><input type="password" id="con_pwd" name="con_pwd" style="width:400px;"/></div> 
        
        <div class="text_signup"><font style="font-size:11px;" face="arial">6 or more characters </font></div> 
        
        <div class="text_signup">Choose Service</div>    
        <div class="text_signup">
        	<select id="service" name="service" style="width:250px;">
            	<option value=""> . . . SELECTED SERVICES . . . </option>
            	<?php sign_up::ServiceList();?>
            </select>
        </div> 
        
        <div style="float:left;"><button id="btncreateaccount" name="btncreateaccount">Creat Account</button></div>  
        <div class="text_signup">&nbsp;</div>  
        <div class="text_signup">
                <label style="color:#333333; font-size:12px;">Already on Mingalar?</label>&nbsp;
                <a href="index.php?f=act&p=Login" style="color:#00C; font-size:12px;">Log in</a></div> 
         
    </div>
    </form>
 
</body>
</html>