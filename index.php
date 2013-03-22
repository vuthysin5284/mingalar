<?php require("load.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta content="mingalar.biz, mingalar website, mingalar web, mingalar.biz at myanmar" name="description"  />
<title>Mingalar Welcome</title>
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

</script>
</head>
<body>
	<div class="header">
    	<div style="float:left; font-family:Tahoma, Geneva, sans-serif; font-size:30px; color:#00C; font-weight:bold;">
        	<a href="index.php" style="text-decoration:none;color:#00C;">Mingalar.biz</a>
        </div>
        <div style="float:right">
        	<a href="#mm"><img src="images/mm.jpg" width="40" /></a>
            <a href="#en"><img src="images/en.jpg" width="40" /></a>
            <a href="#cn"><img src="images/cn.jpg" width="40" /></a>
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
