<?php
$replace  = array("¡",
"¢",
"£",
"¤",
"¥",
"¦",
"§",
"¨",
"©",
"ª",
"«",
"¬",
"®",
"¯",
"°",
"±",
"²",
"³",
"´",
"µ",
"¶",
"·",
"¸",
"¹",
"º",
"»",
"¼",
"½",
"¾",
"¿",
"×",
"÷",
"À",	//capital a, grave accent
"Á",	//capital a, acute accent
"Â",	//capital a, circumflex accent
"Ã",	//capital a, tilde
"Ä",	//capital a, umlaut mark
"Å",	//capital a, ring
"Æ",	//capital ae
"Ç",	//capital c, cedilla
"È",	//capital e, grave accent
"É",	//capital e, acute accent
"Ê",	//capital e, circumflex accent
"Ë",	//capital e, umlaut mark
"Ì",	//capital i, grave accent
"Í",	//capital i, acute accent
"Î",	//capital i, circumflex accent
"Ï",	//capital i, umlaut mark
"Ð",	//capital eth, Icelandic
"Ñ",	//capital n, tilde
"Ò",	//capital o, grave accent
"Ó",	//capital o, acute accent
"Ô",	//capital o, circumflex accent
"Õ",	//capital o, tilde
"Ö",	//capital o, umlaut mark
"Ø",	//capital o, slash
"Ù",	//capital u, grave accent
"Ú",	//capital u, acute accent
"Û",	//capital u, circumflex accent
"Ü",	//capital u, umlaut mark
"Ý",	//capital y, acute accent
"Þ",	//capital THORN, Icelandic
"ß",	//small sharp s, German
"à",	//small a, grave accent
"á",	//small a, acute accent
"â",	//small a, circumflex accent
"ã",	//small a, tilde
"ä",	//small a, umlaut mark
"å",	//small a, ring
"æ",	//small ae
"ç",	//small c, cedilla
"è",	//small e, grave accent
"é",	//small e, acute accent
"ê",	//small e, circumflex accent
"ë",	//small e, umlaut mark
"ì",	//small i, grave accent
"í",	//small i, acute accent
"î",	//small i, circumflex accent
"ï",	//small i, umlaut mark
"ð",	//small eth, Icelandic
"ñ",	//small n, tilde
"ò",	//small o, grave accent
"ó",	//small o, acute accent
"ô",	//small o, circumflex accent
"õ",	//small o, tilde
"ö",	//small o, umlaut mark
"ø",	//small o, slash
"ù",	//small u, grave accent
"ú",	//small u, acute accent
"û",	//small u, circumflex accent
"ü",	//small u, umlaut mark
"ý",	//small y, acute accent
"þ",	//small thorn, Icelandic
"ÿ",
'"',	//quotation mark
"'",	//apostrophe 
"<",	//less-than
">",	//greater-than
"‘");	//small y, umlaut mark

$patterns   = array("/&iexcl;/",
"/&cent;/",
"/&pound;/",
"/&curren;/",
"/&yen;/",
"/&brvbar;/",
"/&sect;/",
"/&uml;/",
"/&copy;/",
"/&ordf;/",
"/&laquo;/",
"/&not;/",
"/&reg;/",
"/&macr;/",
"/&deg;/",
"/&plusmn;/",
"/&sup2;/",
"/&sup3;/",
"/&acute;/",
"/&micro;/",
"/&para;/",
"/&middot;/",
"/&cedil;/",
"/&sup1;/",
"/&ordm;/",
"/&raquo;/",
"/&frac14;/",
"/&frac12;/",
"/&frac34;/",
"/&iquest;/",
"/&times;/",
"/&divide;/",
"/&Agrave;/",	//capital a, grave accent
"/&Aacute;/",	//capital a, acute accent
"/&Acirc;/",	//capital a, circumflex accent
"/&Atilde;/",	//capital a, tilde
"/&Auml;/",	//capital a, umlaut mark
"/&Aring;/",	//capital a, ring
"/&AElig;/",	//capital ae
"/&Ccedil;/",	//capital c, cedilla
"/&Egrave;/",	//capital e, grave accent
"/&Eacute;/",	//capital e, acute accent
"/&Ecirc;/",	//capital e, circumflex accent
"/&Euml;/",	//capital e, umlaut mark
"/&Igrave;/",	//capital i, grave accent
"/&Iacute;/",	//capital i, acute accent
"/&Icirc;/",	//capital i, circumflex accent
"/&Iuml;/",	//capital i, umlaut mark
"/&ETH;/",	//capital eth, Icelandic
"/&Ntilde;/",	//capital n, tilde
"/&Ograve;/",	//capital o, grave accent
"/&Oacute;/",	//capital o, acute accent
"/&Ocirc;/",	//capital o, circumflex accent
"/&Otilde;/",	//capital o, tilde
"/&Ouml;/",	//capital o, umlaut mark
"/&Oslash;/",	//capital o, slash
"/&Ugrave;/",	//capital u, grave accent
"/&Uacute;/",	//capital u, acute accent
"/&Ucirc;/",	//capital u, circumflex accent
"/&Uuml;/",	//capital u, umlaut mark
"/&Yacute;/",	//capital y, acute accent
"/&THORN;/",	//capital THORN, Icelandic
"/&szlig;/",	//small sharp s, German
"/&agrave;/",	//small a, grave accent
"/&aacute;/",	//small a, acute accent
"/&acirc;/",	//small a, circumflex accent
"/&atilde;/",	//small a, tilde
"/&auml;/",	//small a, umlaut mark
"/&aring;/",	//small a, ring
"/&aelig;/",	//small ae
"/&ccedil;/",	//small c, cedilla
"/&egrave;/",	//small e, grave accent
"/&eacute;/",	//small e, acute accent
"/&ecirc;/",	//small e, circumflex accent
"/&euml;/",	//small e, umlaut mark
"/&igrave;/",	//small i, grave accent
"/&iacute;/",	//small i, acute accent
"/&icirc;/",	//small i, circumflex accent
"/&iuml;/",	//small i, umlaut mark
"/&eth;/",	//small eth, Icelandic
"/&ntilde;/",	//small n, tilde
"/&ograve;/",	//small o, grave accent
"/&oacute;/",	//small o, acute accent
"/&ocirc;/",	//small o, circumflex accent
"/&otilde;/",	//small o, tilde
"/&ouml;/",	//small o, umlaut mark
"/&oslash;/",	//small o, slash
"/&ugrave;/",	//small u, grave accent
"/&uacute;/",	//small u, acute accent
"/&ucirc;/",	//small u, circumflex accent
"/&uuml;/",	//small u, umlaut mark
"/&yacute;/",	//small y, acute accent
"/&thorn;/",	//small thorn, Icelandic
"/&yuml;/",
"/&quot;/",	//quotation mark
"/&apos;/",	//apostrophe 
"/&lt;/",	//less-than
"/&gt;/",	//greater-than
"/&lsquo;/");	//small y, umlaut mark

//echo preg_replace($patterns,$replace,"A'Test");

?>