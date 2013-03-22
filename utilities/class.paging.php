<?php
    class Paging{
		
		var $RECORD;
		var $STATEMENT;
		var $PAGEDISPLAY;
		var $ROWS;
		
		function Paging($record,$table_name,$pageDisplay){
			$this->RECORD = $record; 
			$this->PAGEDISPLAY = $pageDisplay;
		}
			
		function getNumRec(){
			
			return $this->ROWS;

		}
		
		function getPages(){
			if($this->getNumRec() > 0){
			if(($this->getNumRec() / $this->RECORD)>0 and ($this->getNumRec() / $this->RECORD)<1){
			
				return 1;
			
			}else{
			
				$i = 0;
				if(($this->getNumRec() % $this->RECORD) > 0){
					$i = 1;
				}				
				return intval(($this->getNumRec() / $this->RECORD)+$i);
			}}else{
				return 0;
			}
		}
		
		
		function pagingLayout($curr_page,$q){
			
			$pageNum = round($this->getPages());
			
			if ($pageNum==0) return;
			$curr_page = round($curr_page/$this->RECORD);
			$min = $curr_page - ($this->PAGEDISPLAY-1);
			$max = $curr_page + $this->PAGEDISPLAY;
			
			$position = $curr_page;
			
			$j = 0;
			echo '<table border="0" cellspacing="0" cellpadding="5" class="paging" align="center"><tr>';
			if($curr_page >= 1){
				echo '<td><a href="javascript:pageNav.showPreviousPage({position:0,q:\''.$q.'\',a:\'view\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/2leftarrow.png" width="16" height="16" /></a></td><td><a href="javascript:pageNav.showPreviousPage({position:'.$this->RECORD.' *'.($position-1).',q:\''.$q.'\',a:\'view\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/1leftarrow.png" width="16" height="16" /></a></td>';
			}else{
				echo '<td><img src="'.PathRoot().'/images/2leftarrow-dis.jpg" width="16" height="16" /></td><td><img src="'.PathRoot().'/images/1leftarrow-dis.jpg" width="16" height="16" /></td>';
			}
			
			for($i=1; $i<=$pageNum; $i++){
				
				if($i==($position+1)){
					echo '<td class="currentpage">&nbsp;'.$i.'&nbsp;</td>';
				}
				else{
					if($min <= $i and $max >= $i){
						
						if($i==$position ){
							echo '<td><a href="javascript:pageNav.showPaging({position:'.$j.',q:\''.$q.'\',a:\'view\'})" class="noncurrentpage">&nbsp;'.$i.'&nbsp;</a></td>';
						}
						else{
							echo '<td><a href="javascript:pageNav.showPaging({position:'.$j.',q:\''.$q.'\',a:\'view\'})" class="noncurrentpage">&nbsp;'.$i.'&nbsp;</a></td>';
						}
					}
				}
				$j += $this->RECORD;
				
			}
			
			if( ($pageNum-1) > $curr_page ){
				echo '<td><a href="javascript:pageNav.showNextPage({position:'.$this->RECORD.'*'.($position+1).',q:\''.$q.'\',a:\'view\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/1rightarrow.png" width="16" height="16" /></a></td><td><a href="javascript:pageNav.showNextPage({position:'.$this->RECORD.'*'.($pageNum-1).',q:\''.$q.'\',a:\'view\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/2rightarrow.png" width="16" height="16" /></a></td>';
			}else{
				echo '<td><img src="'.PathRoot().'/images/1rightarrow-dis.jpg" width="16" height="16" /></td><td><img src="'.PathRoot().'/images/2rightarrow-dis.jpg" width="16" height="16" /></td>';
			}
			echo '</tr></table>';
		}
		
		function pagingLayoutScholarship($curr_page,$q){
			
			$pageNum = round($this->getPages());
			if ($pageNum==0) return;
			$curr_page = round($curr_page/$this->RECORD);
			$min = $curr_page - ($this->PAGEDISPLAY-1);
			$max = $curr_page + $this->PAGEDISPLAY;
			
			$position = $curr_page;
			
			$j = 0;
			echo '<table border="0" cellspacing="0" cellpadding="5" class="paging"><tr>';
			if($curr_page >= 1){
				echo '<td><a href="javascript:pageNav.showPreviousPage({position:0,q:\''.$q.'\',a:\'viewScholarship\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/2leftarrow.png" width="16" height="16" /></a></td><td><a href="javascript:pageNav.showPreviousPage({position:'.$this->RECORD.' *'.($position-1).',q:\''.$q.'\',a:\'viewScholarship\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/1leftarrow.png" width="16" height="16" /></a></td>';
			}else{
				echo '<td><img src="'.PathRoot().'/images/2leftarrow-dis.jpg" width="16" height="16" /></td><td><img src="'.PathRoot().'/images/1leftarrow-dis.jpg" width="16" height="16" /></td>';
			}
			
			for($i=1; $i<=$pageNum; $i++){
				
				if($i==($position+1)){
					echo '<td class="currentpage">&nbsp;'.$i.'&nbsp;</td>';
				}
				else{
					if($min <= $i and $max >= $i){
						
						if($i==$position ){
							echo '<td><a href="javascript:pageNav.showPaging({position:'.$j.',q:\''.$q.'\',a:\'viewScholarship\'})" class="noncurrentpage">&nbsp;'.$i.'&nbsp;</a></td>';
						}
						else{
							echo '<td><a href="javascript:pageNav.showPaging({position:'.$j.',q:\''.$q.'\',a:\'viewScholarship\'})" class="noncurrentpage">&nbsp;'.$i.'&nbsp;</a></td>';
						}
					}
				}
				$j += $this->RECORD;
				
			}
			
			if( ($pageNum-1) > $curr_page ){
				echo '<td><a href="javascript:pageNav.showNextPage({position:'.$this->RECORD.'*'.($position+1).',q:\''.$q.'\',a:\'viewScholarship\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/1rightarrow.png" width="16" height="16" /></a></td><td><a href="javascript:pageNav.showNextPage({position:'.$this->RECORD.'*'.($pageNum-1).',q:\''.$q.'\',a:\'viewScholarship\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/2rightarrow.png" width="16" height="16" /></a></td>';
			}else{
				echo '<td><img src="'.PathRoot().'/images/1rightarrow-dis.jpg" width="16" height="16" /></td><td><img src="'.PathRoot().'/images/2rightarrow-dis.jpg" width="16" height="16" /></td>';
			}
			echo '</tr></table>';
		}
		
		function pagingLayoutTdyss($curr_page,$academic_year,$degree_id,$major_id, $year , $session , $promotion){
			
			$pageNum = round($this->getPages());
			if ($pageNum==0) return;
			$curr_page = round($curr_page/$this->RECORD);
			$min = $curr_page - ($this->PAGEDISPLAY-1);
			$max = $curr_page + $this->PAGEDISPLAY;
			
			$position = $curr_page;
			
			$j = 0;
			echo '<table border="0" cellspacing="0" cellpadding="5" class="paging"><tr>';
			if($curr_page >= 1){
				echo '<td><a href="javascript:pageNav.showPreviousPage({position:0,academic_year:\''.$academic_year.'\',degree_id:\''.$degree_id.'\',major_id:\''.$major_id.'\',year:\''.$year.'\',session:\''.$session.'\',promotion:\''.$promotion.'\',a:\'view\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/2leftarrow.png" width="16" height="16" /></a></td><td><a href="javascript:pageNav.showPreviousPage({position:'.$this->RECORD.' *'.($position-1).',academic_year:\''.$academic_year.'\',degree_id:\''.$degree_id.'\',major_id:\''.$major_id.'\',year:\''.$year.'\',session:\''.$session.'\',promotion:\''.$promotion.'\',a:\'view\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/1leftarrow.png" width="16" height="16" /></a></td>';
			}else{
				echo '<td><img src="'.PathRoot().'/images/2leftarrow-dis.jpg" width="16" height="16" /></td><td><img src="'.PathRoot().'/images/1leftarrow-dis.jpg" width="16" height="16" /></td>';
			}
			
			for($i=1; $i<=$pageNum; $i++){
				
				if($i==($position+1)){
					echo '<td class="currentpage">&nbsp;'.$i.'&nbsp;</td>';
				}
				else{
					if($min <= $i and $max >= $i){
						
						if($i==$position ){
							echo '<td><a href="javascript:pageNav.showPaging({position:'.$j.',academic_year:\''.$academic_year.'\',degree_id:\''.$degree_id.'\',major_id:\''.$major_id.'\',year:\''.$year.'\',session:\''.$session.'\',promotion:\''.$promotion.'\',a:\'view\'})" class="noncurrentpage">&nbsp;'.$i.'&nbsp;</a></td>';
						}
						else{
							echo '<td><a href="javascript:pageNav.showPaging({position:'.$j.',academic_year:\''.$academic_year.'\',degree_id:\''.$degree_id.'\',major_id:\''.$major_id.'\',year:\''.$year.'\',session:\''.$session.'\',promotion:\''.$promotion.'\',a:\'view\'})" class="noncurrentpage">&nbsp;'.$i.'&nbsp;</a></td>';
						}
					}
				}
				$j += $this->RECORD;
				
			}
			
			if( ($pageNum-1) > $curr_page ){
				echo '<td><a href="javascript:pageNav.showNextPage({position:'.$this->RECORD.'*'.($position+1).',academic_year:\''.$academic_year.'\',degree_id:\''.$degree_id.'\',major_id:\''.$major_id.'\',year:\''.$year.'\',session:\''.$session.'\',promotion:\''.$promotion.'\',a:\'view\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/1rightarrow.png" width="16" height="16" /></a></td><td><a href="javascript:pageNav.showNextPage({position:'.$this->RECORD.'*'.($pageNum-1).',academic_year:\''.$academic_year.'\',degree_id:\''.$degree_id.'\',major_id:\''.$major_id.'\',year:\''.$year.'\',session:\''.$session.'\',promotion:\''.$promotion.'\',a:\'view\'})" class="noncurrentpage"><img src="'.PathRoot().'/images/2rightarrow.png" width="16" height="16" /></a></td>';
			}else{
				echo '<td><img src="'.PathRoot().'/images/1rightarrow-dis.jpg" width="16" height="16" /></td><td><img src="'.PathRoot().'/images/2rightarrow-dis.jpg" width="16" height="16" /></td>';
			}
			echo '</tr></table>';
		}
		
		
	}	
?>