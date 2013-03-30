<?php

	//print_r($_GET['p']);
	
	if($_s_name!=""){  
?>
 
<img src="images/under-construction.jpg" width="347" height="346" />

<?php
	}else{
		util::redirect('index.php?f=act&p=Login&s='.$_GET['p'].'',true);
	}

?>