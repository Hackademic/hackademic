// Author Divam Gupta
// github.com/divamgupta

// This mini phantom.js script simplates the login by the admin. As the webapp is vulnerable to XSS, phantom.js will execute the js injected.



"use strict";
var page = require('webpage').create(),
    server = 'http://localhost:8000',
    data = 'login=admin&username=admin&password=ccedjbvcfrvvuibdhbchdbchdbhcdhccdv';

page.open(server, 'post', data, function (status) {
	console.log(status)
    if (status !== 'success') {
        console.log('Unable to post!');
    } else {

    	setTimeout( function(){

    		phantom.exit();
    		 
    	} , 1000 );
       
    }
  
});