/* Developed by Bunthoeurn
	Version: 1.0
	Date: 9.7.2012
*/
var MessageBox = {	
   Show:function(promptMsg){alert(promptMsg);}
}

var Security = function(){ full, del, list, add, edit }

var page = function(){
		url,
		display,
		currentPage,
		queryString,
		numRecord,
		msg,
		url_request
}


function IsNumber(e,t){
	
	if(t.value.indexOf(".")==0)t.value="0.";
	var dot=t.value.indexOf(".");
	
	var unicode=e.charCode? e.charCode : e.keyCode;
	if(t.name == "grade" || t.name == "Grade"){
		/*107 is k 75 is K*/
		if(unicode ==107 || unicode ==75 ){ return true; }		
	}
	if(unicode == 37 || unicode==39 || unicode == 43 || unicode==45)return true;

	if (unicode!=8 && unicode!=46 && unicode!=9){ 
		if (unicode<48||unicode>57) 
		return false;
	}
	if (unicode==46 && dot>0)return false;
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


// Ajax Function query string is {var1:value1,var2:value2}
var ProWestecAjax = {
	
	Delete:function(page){
	
		if(page.url==""){MessageBox.Show("Please your url for submit"); return}
		
		$.post(page.url, page.queryString ,function(data){	
											
			if(data=="success"){
				document.location.href = page.url_request;
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
			
	}
	,
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
	,
	View:function(page){
		
		
		$('#'+page.display).html('<img src="../images/busy.gif" title="Processing...">Processing...');
		
		
		$.post(page.url, page.queryString ,function(data){	
			
			$('#'+page.display).html(data);
			
		});	
	},
	Login:function(page){
		
		
		$('#'+page.display).html('<img src="../images/busy.gif" title="Processing...">Processing...');
		
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
}


var bth = {
	
	Delete:function(page){
	
		if(page.url==""){MessageBox.Show("Please your url for submit"); return}
		
		$.post(page.url, page.queryString ,function(data){	
													
			if(data=="success"){
				document.location.href = page.url_request;
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
			
	}
	,
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
	,
	View:function(page){
		
		
		$('#'+page.display).html('<img src="../images/busy.gif" title="Processing...">Processing...');
		
		
		$.post(page.url, page.queryString ,function(data){	
				
			$('#'+page.display).html(data);
			
		});	
	},
	Login:function(page){
		
		
		$('#'+page.display).html('<img src="../images/busy.gif" title="Processing...">Processing...');
		
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

var pageNavigator = {
	showNextPage:function(currentPage,queryString){		
		page.currentPage = currentPage;
		page.queryString = queryString;
		
		this.showPaging(currentPage,queryString);
	},		
	showPreviousPage:function(currentPage,queryString){	
		
		page.currentPage = currentPage;
		page.queryString = queryString;
		this.showPaging(currentPage,queryString);
	},
	showPaging:function(currentPage,queryString){		
		page.currentPage = currentPage;
		page.queryString = queryString;
		page.url = "products.modify.php";
		page.display = "renderData";
		ProWestecAjax.View(page);
	}
}


function checkAll( checked , name ) {
	
	var frm = document.getElementsByName(name);
	
	for(i=0; i<frm.length; i++) 
	{ 
		if(frm[i].type=="checkbox" && frm[i].name == name) 
		{ 
			frm[i].checked=checked;		
		}
	}
}


function checkAllProduct( n, fldName ) {
  if (!fldName) {
     fldName = 'cb';
  }
	var f = document.ProductForm;
	var c = f.toggleProduct.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		$("#boxchecked").val(n2);
	} else {
		$("#boxchecked").val(0);
	}
}
function listItemTask( id, task ) {
    var f = document.adminForm;
    cb = eval( 'f.' + id );
    if (cb) {
        for (i = 0; true; i++) {
            cbx = eval('f.cb'+i);
            if (!cbx) break;
            cbx.checked = false;
        } // for
        cb.checked = true;
        f.boxchecked.value = 1;
        submitbutton(task);
    }
    return false;
}

function isChecked(isitchecked,value){
	
	if (isitchecked == true){
		$("#boxchecked").val(+1);
		$("#customer_id").val(value) ;
	}
	else {
		$("#boxchecked").val(-1);
		$("#customer_id").val(0);
	}
}

function isCheckedCustomer(checked, CustomerID){
	
	
}
function isCheckedProduct(checked, ProductID){
	
	
}
function isEmail( text )
{
	var pattern = "^[\\w-_\.]*[\\w-_\.]\@[\\w]\.+[\\w]+[\\w]$";
	var regex = new RegExp( pattern );
	return regex.test( text );
}

var ProWestecTable = {
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

function SetDateTimePicker(id){
	 $('#'+id).datepicker({
		buttonImage: '../images/calendar.gif',
		buttonImageOnly: true,
		changeMonth:false,
		changeYear:false,
		showOn: 'button',
		constrainInput: false,
		dateFormat: 'dd/mm/yy',
		inline: true
	});	
}

 function getSelectedText(elementId) {
    var elt = document.getElementById(elementId);

    if (elt.selectedIndex == -1)
        return null;
    return elt.options[elt.selectedIndex].text;
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
 
 function DecimalFormat(formatStr)
{
     /**
     * @fieldOf DecimalFormat
     * @type String
     */
    this.prefix = '';
    /**
     * @fieldOf DecimalFormat
     * @type String
     */
    this.suffix = '';
    /**
     * @description Grouping size
     * @fieldOf DecimalFormat
     * @type String
     */
    this.comma = 0;
    /**
     * @description Minimum integer digits to be displayed
     * @fieldOf DecimalFormat
     * @type Number
     */
    this.minInt = 1;
    /**
     * @description Minimum fractional digits to be displayed
     * @fieldOf DecimalFormat
     * @type String
     */
    this.minFrac = 0;
    /**
     * @description Maximum fractional digits to be displayed
     * @fieldOf DecimalFormat
     * @type String
     */
    this.maxFrac = 0;
    
    // get prefix
    for (var i=0; i<formatStr.length; i++) {
        if (formatStr.charAt(i) == '#' || formatStr.charAt(i) == '0') {
            this.prefix = formatStr.substring(0,i);
            formatStr = formatStr.substring(i);
            break;
        }
    }
    
    // get suffix
    this.suffix = formatStr.replace(/[#]|[0]|[,]|[.]/g , '');

    // get number as string
    var numberStr = formatStr.replace(/[^0#,.]/g , '');
    
    var intStr = '';
    var fracStr = '';
    var point = numberStr.indexOf('.');
    if (point != -1) {
        intStr = numberStr.substring(0,point);
        fracStr = numberStr.substring(point+1);
    }
    else {
        intStr = numberStr;
    }
    
    var commaPos = intStr.lastIndexOf(',');
    if (commaPos != -1) {
        this.comma = intStr.length - 1 - commaPos;
    }
    
    intStr = intStr.replace(/[,]/g , ''); // remove commas

    fracStr = fracStr.replace(/[,]|[.]+/g , '');

    this.maxFrac = fracStr.length;
    var tmp = intStr.replace(/[^0]/g , ''); // remove all except zero
    if (tmp.length > this.minInt)
      this.minInt = tmp.length;
    tmp = fracStr.replace(/[^0]/g , '');
    this.minFrac = tmp.length;
}





