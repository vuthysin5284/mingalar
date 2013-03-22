
var MessageBox = {	
   Show:function(promptMsg){alert(promptMsg);}
   
}

var page = function(){
		url,
		display,
		currentPage,
		queryString,
		numRecord,
		msg,
		url_request,
		row_index,
		table_name
}
var Security = function(){ full, del, list, add, edit }

function IsNumber(obj){
	
    var elementValueLength = obj.value.length;
    var lastChar  = obj.value.toString().substring(elementValueLength-1,elementValueLength);
    var goodChars =  obj.value.toString().substring(0,elementValueLength-1);
    if(!isNaN(parseInt(lastChar)) || lastChar==',' || lastChar=='.'){
     	obj.value = goodChars+lastChar; 
	}else{
     	obj.value = goodChars; 
    }
     
}

function CurrencyFormat(obj)
{

    var elementValue = obj.value;
    var afterSeperator;
    var beforeSeperator;
    var newBefore = '';
    elementValue = elementValue.replace('.','');    
    if(elementValue.toString().indexOf(',')>-1)
    {
        afterSeperator = elementValue.split(',')[1];
        beforeSeperator = elementValue.split(',')[0];
    }
    else
    {
        beforeSeperator = elementValue;
        afterSeperator = '00';
    }
    
    
    var count = 0;
    for(var i=0;i<beforeSeperator.length;i++)
    {
        count++;
        newBefore = beforeSeperator.substring(beforeSeperator.length-i-1,beforeSeperator.length-i) + newBefore;
        if(count==3)
        {
            if(i!=beforeSeperator.length-1)
            {
                newBefore = '.' + newBefore;
                count = 0;      
            }      
        }
    }
   obj.value = newBefore+','+afterSeperator;
}

function NumbersOnly(e,t){
		
	if(t.value.indexOf(".")==0)t.value="0.";
	var dot=t.value.indexOf(".");
	
	var unicode=e.charCode? e.charCode : e.keyCode;
	
	if(unicode == 37 || unicode==39)return true;

	if (unicode!=8 && unicode!=46 && unicode!=9){ 
		if (unicode<48||unicode>57) 
		return false;
	}
	if (unicode==46 && dot>0)return false;
}

var bth = {
	
	Delete:function(page){
		
		if(page.url==""){MessageBox.Show("Please set your url for submit"); return}
		
		$.post(page.url, page.queryString ,function(data){	
			
			if(data=="success"){
				$("#"+page.row_index).remove();
			}else{
				MessageBox.Show(data);
			}
			
		});	
	},
	Insert:function(page){
		
		if(page.url==""){MessageBox.Show("Please your url for submit"); return}
		
		$.post(page.url, page.queryString ,function(data){	

			if(data=="success"){
				document.location.href = page.url_request;	
			}else{
				MessageBox.Show(data);
			}
			
		});	
			
	},
	Update:function(page){
		
		if(page.url==""){MessageBox.Show("Please your url for submit"); return}
		$.post(page.url, page.queryString ,function(data){	
									
			if(data=="success"){
				document.location.href = page.url_request;	
			}else{
				MessageBox.Show(data);
			}
		});	
		
	}
	,View:function(page){


		$('#'+page.display).html('<img src="../images/loading-circle.gif" title="Processing...">Processing...');
		$.post(page.url, page.queryString ,function(data){
			$('#'+page.display).html(data);
		});
		
	},
	Login:function(page){
		
		
		$('#'+page.display).html('<img src="../images/loading-circle.gif" title="Processing...">Processing...');
		
		$.post(page.url, page.queryString ,function(data){	
			
			if(data=="user"){
				MessageBox.Show("user is not valid!");
				
			}else if(data=="password"){
				MessageBox.Show("password is not valid!");	
			}else if(data=="seccess"){
				document.location.href=page.url_request;
			}			
		});	
		
	}
	,
	Close:function(){
		$.post("../login.php", {a:'logout'} ,function(data){
			window.home();	
		});	
	}
	,
	deleteRow:function (tableID){
	
		try {
		
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length-1;
			var bool = false;
			
			for(var i=1; i<=rowCount; i++){
				
				var row = table.rows[i];
				var chkbox = row.cells[0].childNodes[0];
				
				if(null != chkbox && true == chkbox.checked) {
				
					bool = chkbox.checked;
					table.deleteRow(i);
					rowCount--;
					i--;
				}	
			}
			
		}catch(e) {
			alert(e);
		}
	}
}
	
var pageNav = {
	showNextPage:function(queryString){		
		this.showPaging(queryString);
	},		
	showPreviousPage:function(queryString){	
		this.showPaging(queryString);
	},
	showPaging:function(queryString){		
		page.queryString = queryString;
		bth.View(page);
	}
}

function isEmail( text )
{
	var pattern = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[\\w]$";
	var regex = new RegExp( pattern );
	return regex.test( text );
}

function validateEmail(email){
	   var a = document.getElementById(email).value;
	   var filter = /^[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}$/;
		if(filter.test(a)){
			return true;
		}
		else{
			return false;
		}
	}

var timer_is_on=0;
var c=0;
var t;	

function timer_counter(object_id)
{
	document.getElementById(object_id).value=c;
	c=c+1;
	t=setTimeout("timer_counter()",1000);
}

function doTimer()
{
	
	if (!timer_is_on)
  	{
  		timer_is_on=1;
	  	timedCount();
  	}
}

function SetDateTimePicker(name){
	 $('#'+name).datepicker({
		buttonImage: '../images/calendar.gif',
		buttonImageOnly: true,
		changeMonth:false,
		changeYear:false,
		showOn: 'button',
		constrainInput: false,
		dateFormat: 'dd-M-yy',
		inline: true
	});	
}

function GetDateTime(name){
	
	var partern0 = /-/;
	var partern1 = /\//;			
	var partern2 = / /;
	var char_split = ' ';
	
	
	if(partern0.test(document.getElementById(name).value)== true){
			char_split = '-';
	}else if(partern1.test(document.getElementById(name).value)== true){
			char_split = '/';
	}
	
	var date = document.getElementById(name).value.split(char_split);
	
	if(document.getElementById(name).value == ""){
		return "NULL";
	}
	
	var month = {"Jan":"01","Feb":"02","Mar":"03","Apr":"04","May":"05","Jun":"06","Jul":"07","Aug":"08","Sep":"09","Oct":10,"Nov":11,"Dec":12,"jan":"01","feb":"02","mar":"03","apr":"04","may":"05","jun":"06","jul":"07","aug":"08","sep":"09","oct":10,"nov":11,"dec":12,"01":"01","02":"02","03":"03","04":"04","05":"05","06":"06","07":"07","08":"08","09":"09","10":10,"11":11,"12":12,"1":"01","2":"02","3":"03","4":"04","5":"05","6":"06","7":"07","8":"08","9":"09","10":10,"11":11,"12":12};
	
	if(date.length ==1){
		if(date[0].lenght<4 || date[0].lenght >4){ alert("Please inter 4 digits for year!"); document.getElementById(name).focus();  }
		return  date+''+'0101';	
	}else{
	  	var str = date[0];
		if(str.length == 1){
			str = '0'+str;	
		}
		return date[2]+''+month[date[1]]+''+ str;	
	}
	
}

function checkAll(checked) {
		
	var f = document.from_admin;
	
	for (i=0; i < f.elements.length; i++) {
		
		if (f.elements[i].type == "checkbox") {
			f.elements[i].checked = checked;
		}
	}
	
}
		
function SubmitForm(){
	document.getElementById("from_admin").submit();
}

function Trash(page,access_modify){ 
			
	if(access_modify=='1' || access_modify =='2'){	
		
		var f = document.from_admin;
		var str_value = "";
		for (i=0; i < f.elements.length; i++) {
			
			if (f.elements[i].type == "checkbox") {
				if(f.elements[i].checked == true && f.elements[i].id != "checkall"){
					
				str_value = str_value + f.elements[i].value + ",";
					
				}
			}
		}
		
		page.queryString = {id:str_value.substr(0,str_value.lastIndexOf(',')),state : -2 ,a:'modify'};
		page.msg = false;			 
		$.post(page.url, page.queryString ,function(data){  document.from_admin.submit();});

	}else{ 
		confirm("You don't have permission to delete!");
	} 
} 

 function getSelectedText(elementId) {
    var elt = document.getElementById(elementId);

    if (elt.selectedIndex == -1)
        return null;
    return elt.options[elt.selectedIndex].text;
}

function createXMLDocument( s ) {
	 var browserName = navigator.appName;
	
	 var xmlDoc;
	 if ( browserName == "Microsoft Internet Explorer" ) {
		 xmlDoc = new ActiveXObject( "Microsoft.XMLDOM" );
		 xmlDoc.async = "false";
		 xmlDoc.loadXML( s );
		
	 } else {
		xmlDoc = ( new DOMParser() ).parseFromString( s, "text/xml" );
	 }
	 return xmlDoc;
 }
	



