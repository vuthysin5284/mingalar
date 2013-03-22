<?php
	 session_start(); 
	/*Code Generator: V.1
	 Developed by Bunthoeurn 
	 Date: 18/07/2012 03:58*/
	 include_once("../adodb/adodb.inc.php"); 
	 include_once("../utilities/db.config.php"); 
	 include_once("../utilities/class.paging.php"); 
	 include_once("../utilities/functions.php"); 
	 include_once("../models/term_condition.class.php"); 
	 require_once("../utilities/specail_chars_encode.php");
	 $term_condition = new term_condition(20,"term_condition",3); 
	 $a = $_REQUEST["a"];
	 $position = empty( $_REQUEST["position"])?0:$_REQUEST["position"];
	 $term_condition->term_id = $_REQUEST["term_id"];
	 $term_condition = $term_condition->Getterm_conditionInfoByterm_id($term_condition);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	 <title><?php echo $config["project"]; ?> - Term Condition</title>
	<?php require_once("../utilities/header.php");  ?>    
      
	 <script type="text/javascript">
		 page.url = "../controllers/term_condition.server.php";
		 var a = "<?php echo $a; ?>";
		 page.url_request = "term_condition.list.php?position=<?php echo $position; ?>";
		
		 $(function(){
					
			 if(a=="New"){ 
				 $("#term_id").val("<?php echo $term_condition->Getterm_id();?>");	
			 } 
			 $("#btSaveNew").click(function() { 
 				 if(a=="Edit"){Validate(2,'more');}else{Validate(1,'more'); }
 			 });
 			 $("#topCancel").click(function(){
 				 document.location.href = "term_condition.list.php";		
 			 });
 			 $("#btSaveClose").click(function(){
 				 if(a=="Edit"){Validate(2,'');}else{Validate(1,'');}
 			 });
			 
			 <?php
			 	if($term_condition->default == 1){
					echo "document.getElementById('default').checked  = true;document.getElementById('txtdefault').value  = 1;";	
				}
			 ?>
 		 });
 		 function Validate(act,command){		
			 if($("#description").val()==""){ 
				 MessageBox.Show("Please enter description! ");
				 $("#description").focus();
				 return; 
			 } else{ 
				 page.queryString = { 
					 term_id:$("#term_id").val(),
					 description:$("#description").val(),
					 order_no:$("#order_no").val(),
					 term_name:$("#term_name").val(),
					 txtdefault:$("#txtdefault").val(),
					 a:'<?php echo $a; ?>'};
				 if(command == "more"){ page.url_request = ""; }else{ page.url_request = "term_condition.list.php?position=<?php echo $position; ?>"; }
				 if(act == 1){
					 ProWestecAjax.Insert(page); ClearData();
				 }else if(act == 2){
					 ProWestecAjax.Update(page); ClearData();
				 }
			 }
		 }
		 function ClearData(){ 
			 $("#term_id").val('');
			 $("#description").val('');
		 }
		 
		function ChangeDefault(checked){
			if(checked){
				document.getElementById("txtdefault").value = 1;
			}else{
				document.getElementById("txtdefault").value = 0;	
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
		 <div style="width:100%; display:inline; border-bottom:1px solid #CCC; height:60px; float:left;">
				 <div class="title">Term Condition[<?php echo $a; ?>]</div>
			 <div class="action_menu">
				 <a href="term_condition.list.php?position=<?php echo $position; ?>" id="topClose" class="close"><div class="sub_action_menu">Close</div></a>
			 </div>
		 </div>
		 <div style="width:100%; text-align:center; float:left; text-align:center;">
			 <form id="frmterm_condition" name="frmterm_condition" class="border" method="post">
             <input type="hidden" id="txtdefault" name="txtdefault" value="0" />
				 <table width="70%" height="300" style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" align="center">
					 <tr><td colspan="2"><font color='#FF0000'>*</font> <em>Require field, please fill all this fields.</em></td></tr>
					 <input type="hidden" id="term_id" name="term_id" value="<?php echo $term_condition->term_id; ?>" tabindex="1" readonly>
					 <tr>
						 <td align="right" valign="top">Description (<font color='#FF0000'>*</font>):</td>
                        
						 <td class="left"><textarea id="description" name="description" cols="95" rows="20" tabindex="2"><?php echo preg_replace($patterns,$replace,$term_condition->description); ?></textarea></td>
					 </tr>
                      <tr>
						 <td class="right">Term Name :</td>
						 <td align="left"><input type="text" <?php if($term_condition->term_name == "NO") echo "readonly" ?> id="term_name" name="term_name" value="<?php echo preg_replace($patterns,$replace,$term_condition->term_name); ?>"></td>
					 </tr>
                      <tr>
						 <td class="right">Order No:</td>
						 <td align="left"> <input type="text" value="<?php echo $term_condition->order_no; ?>" id="order_no" name="order_no" onKeyPress="return IsNumber(event,this)"></td>
					 </tr>
					 <tr>
						 <td align='center' style='text-align:center'>
							 Is Default:
						 </td>
                         <td class="left">
                         	<input type="checkbox" id="default" name="default" onChange="ChangeDefault(this.checked)" />
                         </td>
					 </tr>
				 </table>
                 <input type="button" value="Save & New" id="btSaveNew" tabindex="2" > &nbsp;
							 <input type="button" value="Save & Close" id="btSaveClose" tabindex="3" > &nbsp;
							 <input type="reset" value="Reset" id="btReset" tabindex="4" >
			 </form> 
		 </div>  
</div> 
<div class="footer"><?php include("../utilities/footer.php"); ?></div> 
</body> 
</html>
