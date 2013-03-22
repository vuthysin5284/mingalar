
jQuery.fn.print = function(){

	if (this.size() > 1){
		this.eq( 0 ).print();
		return;
	} else if (!this.size()){
		return;
	}


	var strFrameName = ("printer-" + (new Date()).getTime());


	var jFrame = $( "<iframe name='" + strFrameName + "'>" );


	jFrame
		.css( "width", "1px" )
		.css( "height", "1px" )
		.css( "position", "absolute" )
		.css( "left", "-9999px" )
		.appendTo( $( "body:first" ) )
	;


	var objFrame = window.frames[ strFrameName ];


	var objDoc = objFrame.document;
	var jStyleDiv = $( "<div>" ).append(
		$( "style" ).clone()
		);
    var linkStyle="";

	objDoc.open();
	objDoc.write( "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">" );
	objDoc.write( "<html xmlns=\"http://www.w3.org/1999/xhtml\">" );
	objDoc.write( "<body>" );
	objDoc.write( "<head>" );
	objDoc.write( linkStyle );
	objDoc.write( "<title>" );
	objDoc.write( document.title );
	objDoc.write( "</title>" );
	objDoc.write( jStyleDiv.html() );
	objDoc.write( "</head>" );
	objDoc.write( this.html());
	objDoc.write( "</body>" );
	objDoc.write( "</html>" );
	objDoc.close();
	objFrame.focus();
	objFrame.print();
    return true;
setTimeout(
		function(){
			jFrame.remove();
		},
		(60 * 1000)
		);
}