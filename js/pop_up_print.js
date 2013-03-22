  
    function Popup(data, title) 
    {
       w = 900;
	   h = 600;
		
		var left = (screen.width/2)-(w/2);
		var top = (screen.height/2)-(h/2);
		var mywindow = window.open ('', title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
        mywindow.document.write('<html><head><title>'+title+'</title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        mywindow.print();
        mywindow.close();
        return true;
    }
