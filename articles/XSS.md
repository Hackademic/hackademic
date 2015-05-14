
<!---
XSS
-->
Synopsis:
---------------
Cross site scripting is a vulnerability in which malicious scripts are injected into the websites which can lead to a total breach of security when customer details are stolen or manipulated.

Description: 
------------------
XSS can be found anywhere in an application where user input has been taken but not properly encoded. The injected script will be sent to users when the browser executes the script, and a malicious action is performed on the client side which can be used to steal credentials. 

For more information on XSS:-
[OWASP guide on XSS](https://www.owasp.org/index.php/Cross-site_Scripting_(XSS)) 

Mitigation: 
-------------

- The preferred option is to properly escape all untrusted data based on the HTML context (body, attribute, JavaScript, CSS, or URL) that the data will be placed into. 

- Positive or “whitelist” input validation is also recommended but is not a complete defense as many applications require special characters in their input. Such validation should  validate the length, characters, format, and business rules on that data before accepting the input.

 For more details:[OWASP Cross Site Scripting Prevention Cheat Sheet](https://www.owasp.org/index.php/XSS_(Cross_Site_Scripting)_Prevention_Cheat_Sheet) 

[XSS Filter Evasion Cheat Sheet](https://www.owasp.org/index.php/XSS_Filter_Evasion_Cheat_Sheet) 

[Top 10 2013 A3 Cross-Site Scripting(XSS)](https://www.owasp.org/index.php/Top_10_2013-A3-Cross-Site_Scripting_(XSS)) 

[OWASP AntiSamy](https://www.owasp.org/index.php/AntiSamy) 
[Java HTML Sanitizer Project](https://www.owasp.org/index.php/OWASP_Java_HTML_Sanitizer_Project).


CVSS Base Score:
----------------

For more details:-[4.3 (AV:N/AC:M/AU:N/C:N/I:P/A:N)](http://nvd.nist.gov/cvss.cfm?vector=(AV:N/AC:M/AU:N/C:N/I:P/A:N)&version=2.0) 

