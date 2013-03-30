<?php		 
    if(user::logout()){  
        util::redirect('index.php?');
    }else{}