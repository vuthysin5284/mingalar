<?php
class Student_print_card extends student{
    

	
      function GetStudentPrintcard($degree_id, $major_id, $year, $promotion,$student_group_id){
            global $db;
			
            $result = "";
            $where = "";
            if($degree_id >0){
                    $where .= " and t.degree = $degree_id ";
            }
			
			if( $major_id >0 ){
                    $where .= " and t.major = $major_id ";
            } 
			
			if( $year > 0 ){
                    $where .= " and t.year = $year ";
            }
			
			if($promotion > 0){
                    $where .= " and t.promotion = $promotion ";
            }
			
			if( $student_group_id >0){
                    $where .= " and sg.student_group_id = $student_group_id ";
            }
				
			if($where != ""){
				$where  = " where " . substr( $where,4); 	
			}	
			
			$sql ="select distinct d.study_id,s.student_id,sg.student_group_id,sg.student_group_id,s.student_no,s.fullname_en,s.fullname_kh,s.sex, s.student_type, s.dob ,
                                t.course_code,g.degree_name_en ,m.major_name_en,t.year,t.promotion,t.term, s.telephone, s.email from student s
                                inner join study d on d.student_id =s.student_id  and d.status =1
                                left outer join student_group sg on d.student_group_id = sg.student_group_id
                                left outer join tdyss t on t.tdyss_id = d.tdyss_id
                                left outer join degree g on g.degree_id = t.degree
                                left outer join major m on m.major_id = t.major $where";


			$rs = $db->Execute($sql . " order by g.degree_name_en , m.major_name_en , s.student_no ");

			echo "<table border='1' style='font-family:arial;font-size:12px;border-collapse:collapse' width='99%' align='center' id='tz-table'>".
                                "<thead height='30'><tr>".
                                        '<th><input type="checkbox" onclick="checkedAll()" /></th>'.
                                        "<th>#</th>".
                                        "<th>". ucwords(str_replace("_"," ","Name English"))."</th>".
                                        "<th>". ucwords(str_replace("_"," ","Name Khmer"))."</th>".
                                        "<th>". ucwords(str_replace("_"," ","student_ID"))."</th>".
                                        "<th>". ucwords(str_replace("_"," ","sex"))."</th>".
                                        "<th>". ucwords(str_replace("_"," ","date of birth"))."</th>".
                                        "<th>". ucwords(str_replace("_"," ","telephone"))."</th>".
                                        "<th>". ucwords(str_replace("_"," ","email"))."</th>".
                                        "<th>". ucwords(str_replace("_"," ","group name"))."</th>".
                                        "<th>". ucwords(str_replace("_"," ","Type"))."</th>
                                        <th>". ucwords(str_replace("_"," ","course_code"))."</th>
                                        <th>". ucwords(str_replace("_"," ","Degree"))."</th>
                                        <th>". ucwords(str_replace("_"," ","Major"))."</th>
                                        <th>". ucwords(str_replace("_"," ","Year"))."</th>
                                        <th>". ucwords(str_replace("_"," ","Promotion"))."</th>
                                        <th>". ucwords(str_replace("_"," ","Print time"))."</th>
                                        <th>". ucwords(str_replace("_"," ","Term")).'</th>
                                </tr>
                            </thead>
                            <tbody>';
			$i=1;
			$j=0;
			while($dr = $rs->FetchRow()){


				$sex = $dr['sex'];


				$sttype = $dr["student_type"];

				if($sttype == normal){

					$sttype ='<i class="normal">Normal</i>';

				}elseif($sttype == scholarship){

					$sttype ='<i class="scholarship">Scholarship</i>';

				}elseif($sttype == cancellation){

					$sttype ='<i class="cancellation">Cancellation</i>';

				}elseif($sttype == suspension){

					$sttype ='<i class="suspension">Suspension</i>';

				}elseif($sttype == drop){

					$sttype ='<i class="drop">Drop</i>';

				}elseif($sttype == _new){

					$sttype ='<i class="_new">New</i>';

				}

				echo "<tr class='rowhover' onDblClick=\"ViewStudent(".$dr["student_id"].")\" id='$j'>";
                echo '<td><input type="checkbox" name="check" value="'.$dr['student_id'].'"/></td>';
				echo  "<td>$i</td>";
                                    echo "<td>".$dr["fullname_en"]."</td>";
                                    echo "<td>".$dr["fullname_kh"]."</td>";
                                    echo "<td>".$dr["student_no"]."</td>";
                                    echo "<td>".$sex."</td>";
                                    echo "<td>".formatDate($dr["dob"],12)."</td>";
                                    echo "<td>".$dr["telephone"]."</td>";
                                    echo "<td>".$dr["email"]."</td>";
                                    echo "<td>".$dr["student_group_id"]."</td>";
                                    echo "<td>".$sttype."</td>";
                                    echo "<td>".$dr["course_code"]."</td>";
                                    echo "<td>".$dr["degree_name_en"]."</td>";
                                    echo "<td>".$dr["major_name_en"]."</td>";
                                    echo "<td>".$dr["year"]."</td>";
                                    echo "<td>".$dr["promotion"]."</td>";
                                    echo "<td>".$this->print_num($dr['study_id'])."</td>";
                                    echo "<td>".$dr["term"]."</td>";

			echo "</tr>";
 				$i++;$j++;
 			}
                        echo "</tbody>
             </table><br><br><br>";
	}
        function print_num($study_id){
            global $db;
            $sql_print="select count(*) as print_num from print_card p inner join study sd on p.study_id = sd.study_id
                        inner join student s on sd.student_id = s.student_id where p.study_id = ? and sd.status = 1";
            $rs = $db->Execute($sql_print,array($study_id));
            $row = $rs->FetchRow();
            $maxid = $row['print_num'];
            return $maxid;
            
       }
}
?>