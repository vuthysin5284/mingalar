/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    $(window).scroll(function() {
            if($(window).scrollTop() + $(window).height() == $(document).height()) {
                moreStudents();
            }
      });
});
function moreStudents(){
     var num = $('table#tz-table tbody').size();
     var degree = $('select#degree_tdy').val();
     var major = $('select#major_tdy').val();
     var year = $('select#year_tdy').val();
     var promotion = $('select#promotion_tdy').val();
     var type = $('select#type_tdy').val();
     var new_num = parseInt(num) + 20;
	
     $.ajax({
             url:"../controllers/student_server.php?num="+num+"&degree="+degree+"&major="+major+"&year="+year+"&promotion="+promotion+"&type="+type,
             success:function(data){
               
                 $('#tz-table tbody').append(data);
                 $('table#tz-table tbody').find('input[type=hidden]#last_number').val(new_num);
             }
     });
}