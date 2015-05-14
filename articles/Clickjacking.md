
<!---
ClickJacking
-->
Synopsis:
----------------
Clickjacking (UI redress attack) happens when an attacker uses multiple transparent or opaque layers to trick a user into clicking on a button or link on another page when they were intending to click on the the top level page. 

Description:
----------------------
Clickjacking is a malicious technique that consists of deceiving a user into interacting with multiple transparent or opaque layers to trick a user into clicking on a button or link which they did not intend to. 

It can be used in combination with other attacks, which could potentially send unauthorized commands or reveal confidential data while the victim is spoofed and interacting on seemingly harmless web page.
For more details view:- [OWASP Guide on Clickjacking](https://www.owasp.org/index.php/Clickjacking)

Mitigation:
-----------------
- Include "frame-breaking" functionality which prevents other web pages from framing the site you wish to defend. 

- Using X-Frame-Options Header types like DENY,SAMEORIGIN,ALLOW-FROM uri.

- window.confirm() Protection 

To know more about implementing frame-breaking visit :- [OWASP Clickjacking Defence Cheat Sheet](https://www.owasp.org/index.php/Clickjacking_Defense_Cheat_Sheet)

To view details on the testing of clickjacking visit:- [OWASP Testing for Clickjacking](https://www.owasp.org/index.php/Testing_for_Clickjacking_(OWASP-CS-004))

CVSS Base Score:
----------------------------
[ 4.3 (AV:N/AC:M/AU:N/C:N/I:P/A:N)
](http://nvd.nist.gov/cvss.cfm?vector=(AV:N/AC:M/AU:N/C:N/I:P/A:N)&version=2.0)

