/******************************************************************
AJAX

This file regroups all functions required to use AJAX method.

******************************************************************/
function getXMLHttpRequest() {
	/************************************
	Create an object XMLHttpRequest.
	************************************/
	var xhr = null;
	if (window.XMLHttpRequest || window.ActiveXObject) {
		if (window.ActiveXObject) {
			try {
				xhr = new ActiveXObject("Msxml2.XMLHTTP");
			} catch(e) {
				xhr = new ActiveXObject("Microsoft.XMLHTTP");
			}
		} else {
			xhr = new XMLHttpRequest(); 
		}
	} else {
		alert('Votre navigateur ne supporte pas l\'objet XMLHTTPRequest...');
		return null;
	}
	return xhr;
}

function urldecode(str) {
	/**************************************************************
	Decode strings that have been encode with urlencode in PHP.
	**************************************************************/
	return stripslashes(unescape(str.replace(/\+/g, ' ')));
}

function stripslashes(str) {
	/**************************************************
	Equivalent of the PHP function stripslashes().
	**************************************************/
	return (str + '').replace(/\\(.?)/g, function (s, n1) {
		switch (n1) {
			case '\\':
				return '\\';
			case '0':
				return '\u0000';
			case '':
				return '';
			default:
				return n1;        
		}
    });
}