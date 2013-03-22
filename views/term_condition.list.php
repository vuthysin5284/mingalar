<?php
	 session_start(); 
	/*Code Generator: V.1
	 Developed by Bunthoeurn 
	 Date: 18/07/2012 03:59*/
	 include_once("../adodb/adodb.inc.php");                                       
	 include_once("../utilities/db.config.php");                                   
	 include_once("../utilities/functions.php");                                   
	 include_once("../utilities/class.paging.php");                                            
	 include_once("../models/term_condition.class.php");                        
	 IdleTimeOut($_SESSION["username"],"views/term_condition.list.php");       
	 $position = empty($_REQUEST["position"])?0:$_REQUEST["position"];           
	 $q = empty($_REQUEST["q"])?"":$_REQUEST["q"];                             
	                  
	 $term_condition = new term_condition(20,"term_condition",3);         
		require_once("../models/permission.php");
$permission = new permission(20,"permission",3);
$permission = $permission->GetpermissionInfo($_SESSION["username"],"term_condition"); 
 ?>                                                                                
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>                                                                             
 <head>                                                                            
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">         
	 <title><?php echo $config["project"]; ?> - Term Condition</title>          
	 <?php require_once("../utilities/header.php");  ?>       
              
	 <script type="text/javascript">                                               
		 page.url = "../controllers/term_condition.server.php?position=<?php echo $position; ?>"; 
		 page.numRecord = "hdRecord";                                                
		 page.currentPage = 0;                                                         
		 page.url_request = "term_condition.list.php";                            
		 page.position = "<?php echo $position;?>";                                  
         Security.full = "<?php echo $permission->full?>";
		 Security.add = "<?php echo $permission->add?>";
		 Security.edit = "<?php echo $permission->edit?>";
		 Security.list = "<?php echo $permission->list?>";
		 Security.del = "<?php echo $permission->delete?>";
		 
		 $(function(){		                                                            
			 $("#topAdd").click(function(){gotoAddNew();});                            
			 $("#bottomAdd").click(function(){gotoAddNew();});                         
			 $("#topTrash").click(function(){gotoTrash();});                         
			 $("#topDelete").click(function(){gotoDelete();});                         
		 });                                                                           
		 function gotoEdit(term_id){                                        
			 if(Security.edit==1 || Security.full ==1){	                                              
				 var a = "Edit";                                                         
				 document.location.href = "term_condition.manipulate.php?term_id="+term_id+"&a="+a+"&position="+page.position;
			   }else{ 
				confirm("You don't have permission to edit term condition!");
			}                                                                 
		 }                                                                             
		 function gotoAddNew(){                                                        
			      if(Security.add==1 || Security.full ==1){	                                          
					 var term_id = 0;                                               
					 var a = "New";                                                          
					 document.location.href = "term_condition.manipulate.php?term_id="+term_id +"&a="+a; 
		         }else{ 
				confirm("You don't hav	e permission to add new term condition!");
			}                                                        
		 }                                                                             
		 function gotoDelete(){                           
			if(Security.del==1 || Security.full ==1){	                              
				        
				 var frm = document.adminForm;                                
				 var id = "";                                                          
				 for(i=0; i<frm.elements.length; i++)                                    
				 {                                                                       
					 if(frm.elements[i].type=="checkbox")                                
					 { 
						 if(frm.elements[i].checked==true && frm.elements[i].name == "term_group"){  
							 if(frm.elements[i].value!=""){                                  
								 id +=frm.elements[i].value+",";	                            
								 $("#"+frm.elements[i].value).remove();	i--;                
							 }                                                                 
						 }                                                                   
					 }                                                                     
				 }  
				
					if(id ==""){
						MessageBox.Show("This select term condition to delete!");
						return;
					}
					if(confirm("Do you want to delete term condition?") == true){                                                                          
						 page.queryString = {term_id:id.substr(0,id.lastIndexOf(',')),a:'delete'};  
						 page.msg = true;			                                            
						 ProWestecAjax.Delete(page);                                                       
					 }	
				
			   }else{ 
				confirm("You don't have permission to delete tern condition!");
			}                                                                   
		 }                                                                             
		 function gotoTrash(){                           
			                              
				             
				 var frm = document.adminForm;                                
				 var id = "";                                                          
				 for(i=0; i<frm.elements.length; i++)                                    
				 {                                                                       
					 if(frm.elements[i].type=="checkbox")                                
					 { 
						 if(frm.elements[i].checked==true && frm.elements[i].name == "group"){  
							 if(frm.elements[i].value!=""){                                  
								 id +=frm.elements[i].value+",";	                            
								 $("#"+frm.elements[i].value).remove(); i--;	                
							 }                                                                 
						 }                                                                   
					
					}                                                                     
				 } 
					
				if(id !=""){
					
				  if(confirm("Do you want to delete term condition?") == true){
					 page.queryString = {term_id:id.substr(0,id.lastIndexOf(',')),state:-2,a:'trash'};  
					 page.msg = true;			                                            
					 ProWestecAjax.Delete(page);                                                       
				 } 
				 
				}else{
					MessageBox.Show("This select quote to delete!");
					return;
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
		<form name="adminForm" id="adminForm" action="?" method="post"> 
			 <div style="display:block; width:100%; border-bottom: 1px solid #CCC; height:50px;">
				 <div class="title">Term Condition</div>
				 <div class="action_menu"> 
					 <a href="index.php" id="topClose" class="close"><div class="sub_action_menu">Close</div></a>
					 <a href="#" id="topDelete" class="delete"><div class="sub_action_menu">Delete</div></a>
					 <a href="#" id="topAdd" class="new"><div class="sub_action_menu">New</div></a>
				 </div> 
			 </div>
			 <div class="search">
				 <div class="column">
					 <input id="position" type="hidden" name="position" value="<?php echo $position; ?>" /></div>				 </div>
				 <input type="hidden" id="hdRecord" name="hdRecord"> 
			 <div id="renderData"> 
				 <?php  
					 if($permission->full ==1 or $permission->list ==1){
						 $term_condition->Getterm_conditionList($position);
					 }else{
						echo "<span class='validate'>You don't have permission please contact to administror!</span>";  
					 }
				 ?> 
			 </div> 
		 </form>
	 </div>  
</div> 
<div class="footer"><?php include("../utilities/footer.php"); ?></div> 
</body> 
</html>