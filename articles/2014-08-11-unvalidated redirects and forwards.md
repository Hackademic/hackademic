---
layout: post
title: Unvalidated Redirects and Forwards
---
<!---
Unvalidated Redirects and Forwards
-->
Synopsis
---------------
Unvalidated redirects and forwards are possible when a web application accepts untrusted input that could cause the web application to redirect the request to a URL contained within untrusted input.

Description
-----------------
By modifying untrusted URL input to a malicious site, an attacker may successfully launch a phishing scam and steal user credentials. Because the server name in the modified link is identical to the original site, phishing attempts may have a more trustworthy appearance.

Mitigation
---------------
* Simply avoid using redirects and forwards.If used, do not allow the url as user input for the destination. 
* If user input can’t be avoided, ensure that the supplied value is valid, appropriate  and is authorized.
* Sanitize input by creating a list of trusted URL's (lists of hosts or a regex) and force all redirects through a confirmation page.

For more information visit,
[OWASP Unvalidated Redirects and Forwards] https://www.owasp.org/index.php/Unvalidated_Redirects_and_Forwards_Cheat_Sheet
[MITRE]http://cwe.mitre.org/data/definitions/601.html
[OWASP Open Redirect] https://www.owasp.org/index.php/Open_redirect

CVSS Base Score:
----------------------------

