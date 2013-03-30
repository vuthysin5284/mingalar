<?php
	$_s_name = empty($_service->service_name)?'':$_service->service_name;
	$_user_name = empty($newObj->name)?'':$newObj->name; 
?>
<?php if($_s_name=="EDUCATION" || $_user_name=="Admin"){ ?>
<div style="float:left; margin-right:10px">
	<a href="index.php?f=edu&p=education" title="Education">
    <img class="lazy" data-original="images/education.jpg" src="images/education.jpg" width="290" height="150" /></a></div>
<?php } ?>

<?php if($_s_name=="TOUR AND TRAVELS" || $_user_name=="Admin"){ ?>
<div style="float:left;">
	<a href="index.php?f=ttr&p=tour_travel" title="Tour & Travel">
    <img class="lazy" data-original="images/tour.jpg" src="images/tour.jpg" width="290" height="150" /></a></div>
<?php } ?>

<?php if($_s_name=="LOGISTIC" || $_user_name=="Admin"){ ?>
<div style="float:left;margin-left:10px">
	<a href="index.php?f=lg&p=logistic" title="Logistic">
    <img class="lazy" data-original="images/logistic.jpg" src="images/logistic.jpg" width="290" height="150" /></a></div>
<?php } ?>

<?php if($_s_name=="REAL ESTATE" || $_user_name=="Admin"){ ?>
<div style="float:left;margin-left:10px">
	<a href="index.php?f=rt&p=realestate" title="Realestate">
    <img class="lazy" data-original="images/realestate.jpg" src="images/realestate.jpg" width="290" height="150" /></a></div>
<?php } ?>

<?php if($_s_name=="STORE" || $_user_name=="Admin"){ ?>
<div style="clear:both; margin-bottom:10px;"></div>

<div style="float:left;margin-right:10px">
	<a href="index.php?f=store&p=store" title="Store">
    <img class="lazy" data-original="images/shopping.jpg" src="images/shopping.jpg" width="290" height="150" /></a></div>
<?php } ?>

<?php if($_s_name=="ADVERTIMENT" || $_user_name=="Admin"){ ?>
<div style="float:left">
	<a href="index.php?f=ads&p=advertisment" title="Advertisment">
    <img class="lazy" data-original="images/ads.jpg" src="images/ads.jpg" width="290" height="150" /></a></div>
<?php } ?>

<?php if($_s_name=="JOBS" || $_user_name=="Admin"){ ?>
<div style="float:left;margin-left:10px ">
	<a href="index.php?f=job&p=jobs" title="Jobs">
    <img class="lazy" data-original="images/job.jpg" src="images/job.jpg" width="290" height="150" /></a></div>
<?php } ?>

<?php if($_user_name=="Admin"){ ?> 
<div style="float:left;margin-left:10px">
	<a href="index.php?f=act&p=Login" title="User Login and Signup">
    <img class="lazy" data-original="images/user.jpg" src="images/user.jpg" width="290" height="150" /></a></div>
<?php } ?> 



<?php
	if($_s_name=="" && $_user_name!="Admin"){  
?>
  
<div style="float:left; margin-right:10px">
	<a href="index.php?f=edu&p=education" title="Education">
    <img class="lazy" data-original="images/education.jpg" src="images/education.jpg" width="290" height="150" /></a></div>
    
<div style="float:left;">
	<a href="index.php?f=ttr&p=tour_travel" title="Tour & Travel">
    <img class="lazy" data-original="images/tour.jpg" src="images/tour.jpg" width="290" height="150" /></a></div>
    
<div style="float:left;margin-left:10px">
	<a href="index.php?f=lg&p=logistic" title="Logistic">
    <img class="lazy" data-original="images/logistic.jpg" src="images/logistic.jpg" width="290" height="150" /></a></div>
    
<div style="float:left;margin-left:10px">
	<a href="index.php?f=rt&p=realestate" title="Realestate">
    <img class="lazy" data-original="images/realestate.jpg" src="images/realestate.jpg" width="290" height="150" /></a></div>
    
<div style="clear:both; margin-bottom:10px;"></div>

<div style="float:left;margin-right:10px">
	<a href="index.php?f=store&p=store" title="Store">
    <img class="lazy" data-original="images/shopping.jpg" src="images/shopping.jpg" width="290" height="150" /></a></div>
    
<div style="float:left">
	<a href="index.php?f=ads&p=advertisment" title="Advertisment">
    <img class="lazy" data-original="images/ads.jpg" src="images/ads.jpg" width="290" height="150" /></a></div>
    
<div style="float:left;margin-left:10px ">
	<a href="index.php?f=job&p=jobs" title="Jobs">
    <img class="lazy" data-original="images/job.jpg" src="images/job.jpg" width="290" height="150" /></a></div>
<?php } ?>



