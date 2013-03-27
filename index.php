<?php 
session_start();


require("load.php");  

require("object.php"); 
 

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="mingalar.biz, mingalar website, mingalar web, mingalar.biz at myanmar" name="description"  />
<title>Mingalar <?php echo isset($_GET["p"])?'::'.$_GET["p"]:'Welcome';?></title>
<link rel="stylesheet" type="text/css" href="css/style.css"/>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-39179319-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  
	$(function() {          
		 $("img").lazyload({
			 event : "sporty"
		 });
	 });
	 $(window).bind("load", function() { 
		 var timeout = setTimeout(function() { $("img").trigger("sporty") }, 5000);
	 });    

</script>
<script type="text/javascript">   
	$('a#link').click(function() { 
		var submenu = $('div#submenu'); 
		if (submenu.is(":visible")) { 
			submenu.fadeOut(); 
		} else { 
			submenu.fadeIn(); 
		}
	});
	
	var submenu_active = false; 
	$('div#submenu').mouseenter(function() { 
		submenu_active = true;		 
	});
	
	$('div#submenu').mouseleave(function() { 
		submenu_active = false;  
		setTimeout(function() { if (submenu_active === false) $('div#submenu').fadeOut(); }, 400);
	}); 
		
</script>


</head>
<body>
	<div class="header">
    	<div style="float:left; font-family:Tahoma, Geneva, sans-serif; font-size:30px; color:#00C; font-weight:bold;">
        	<a href="index.php" style="text-decoration:none;color:#00C;">Mingalar.biz</a>
        </div>
        <div style="float:right; font-size:10px">
        
        	<?php echo empty($newObj->name)?'':$newObj->name; ?> &nbsp;&nbsp; 
            <?php if(empty($newObj->name)?'':$newObj->name){ ?>
            <a href="index.php?f=act&p=Logout" style="color:#00C;">Logout</a>
            <?php } ?> 
            &nbsp;&nbsp;
            
            <a id="link">About</a> 
            <div id="submenu">
                 <a href="#">About the company</a><br />
                 <a href="#">Careers</a>
            </div>
            
            &nbsp;&nbsp;
        	<a href="#mm"><img class="lazy" data-original="images/mm.jpg" src="images/mm.jpg" width="20" title="Malaysia" /></a>
            <a href="#en"><img class="lazy" data-original="images/en.jpg" src="images/en.jpg" width="20" title="English" /></a>
            <a href="#cn"><img class="lazy" data-original="images/cn.jpg" src="images/cn.jpg" width="20" title="Chinese" /></a>
        </div>
    </div>
    <div class="content">
    	<div style="display:inline-table; padding-top:30px; text-align:center; float:none" align="center">
        	<div align="center" style="text-align:center">
             <?php 
                    /* @_f is the folders
                     * @_page is the name of files
                    */
                    require("controllers/".$_f."/".$_page.".php"); 
                ?> 	
            </div>
        </div>
    </div>
    <div class="footer"> mingalar.biz &copy; 2013.</div>
</body>
</html>
