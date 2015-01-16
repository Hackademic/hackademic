
<!---
CSRF
-->
Synopsis
--------------
CSRF is an attack which forces an end user to execute unwanted actions on a web application in which he/she is currently authenticated.

Description
------------------
CSRF attack occurs when a malicious Web site, email, blog, instant message, or program causes a user’s Web browser to perform an unwanted action on a trusted site for which the user is currently authenticated. CSRF attacks generally target functions that cause a state change on the server but can also be used to access sensitive data.

To know more about CSRF visit: [ OWASP Guide on Cross-Site Request Forgery](https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF))

Mitigation
---------------

- The preferred option is to include the unique token in a hidden field. This causes the value to be sent in the body of the HTTP request, avoiding its inclusion in the URL, which is more prone to exposure.

- The unique token can also be included in the URL itself, or a URL parameter. However, such placement runs a greater risk that the URL will be exposed to an attacker, thus compromising the secret token.

- Requiring the user to reauthenticate, or prove they are a user (e.g., via a CAPTCHA) can also protect against CSRF.

Also see: [OWASP CSRF prevention without Synchronizer token](https://www.owasp.org/index.php/Cross-Site_Request_Forgery_(CSRF)_Prevention_Cheat_Sheet#CSRF_Prevention_without_a_Synchronizer_Token)

[OWASP Top 10:](https://www.owasp.org/index.php/Top_10_2013-A8-Cross-Site_Request_Forgery_(CSRF))

[TESTING FOR CSRF](https://www.owasp.org/index.php/Testing_for_CSRF_%28OWASP-SM-005%29)

[OWASP CSRF Guard](https://www.owasp.org/index.php/CSRFGuard)  

[OWASP ESAPI](https://www.owasp.org/index.php/ESAPI)

CVSS Base Score:
-----------------------------
[6.8(AV:N/AC:M/AU:N/C:P/I:P/A:P)](http://nvd.nist.gov/cvss.cfm?vector=%28AV:N/AC:M/AU:N/C:P/I:P/A:P%29&version=2.0)
