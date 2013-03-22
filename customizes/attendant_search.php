<?php
class Attendant_search {
   var $attendant_id;
    var $study_id;
    var $attendant_type_id;
    var $entry_date;
    var $attendant_date;
    var $state;
    function attendant_searchByCamboBox($group_student,$session,$room){
     global $db;
      $str_json = '{"attendant":[';
      
      $where ="";
      if($group_student > 0  and $session > 0 and $room > 0){
          $where=" where g.student_group_id = $group_student and sh.shift_id =$session and r.room = $room";
      }
      else if($group_student > 0  and $session > 0 and $room == 0){
          $where=" where g.student_group_id = $group_student and sh.shift_id =$session ";
      }
      else if($group_student >0 and $session == 0 and $room == 0){
          $where=" where g.student_group_id = $group_student ";
      }
      $sql = "select s.student_id, s.fullname_en, s.fullname_kh,s.student_no, s.sex, s.dob from student s
inner join study d on s.student_id=d.student_id
inner join student_group g on d.student_group_id=g.student_group_id
inner join room r on d.room_id = r.room_id
inner join tdyss t on d.tdyss_id = t.tdyss_id
inner join shift sh on t.session = sh.shift_id $where";
      $rs = $db->Execute($sql.' order by g.group_name , sh.shift_en , s.student_no');
     $i = 0;
     while($dr = $rs->FecthRow()){
       if($i < $rs->_numOfRows-1){
         $str_json.= json_encode($dr).",";
       }
       else $str_json.= json_encode ($dr);
       $i++;
     }
    return str_replace('null', '""', $str_json) . "]}";
    }
}

?>
