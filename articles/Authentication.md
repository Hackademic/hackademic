
<!---
Authentication
-->
Synopsis
---------------
Authentication is the act of establishing something (or someone) as authentic, to check that claims made by or about the thing are true. Session Management is a process by which a server maintains the state of an entity interacting with it.

Description
-----------------
Authentication is commonly performed by submitting a username or ID and one or more items of private information that only the user should know. 
Sessions are maintained on the server by a session identifier which can be passed back and forward between the client and server when transmitting and receiving requests. 

To know more about authentication guidelines, see [OWASP Guide](https://www.owasp.org/index.php/Guide_to_Authentication).

Mitigation
---------------
A single set of strong authentication and session management controls. Such controls should strive to:

1) Meet all the authentication and session management requirements defined in OWASP’s [Application Security Verification](https://www.owasp.org/index.php/ASVS)  Standard (ASVS) areas V2 (Authentication) and V3 (Session Management).

2) Have a simple interface for developers. Consider the [ESAPI Authenticator and User APIs](http://owasp-esapi-java.googlecode.com/svn/trunk_doc/latest/org/owasp/esapi/Authenticator.html) as good examples to emulate, use, or build upon.

To know more, see
[OWASP Session Management](https://www.owasp.org/index.php/Session_Management_Cheat_Sheet)

CVSS Base Score:
----------------------------
[5.8(AV:N/AC:M/AU:N/C:P/I:P/A:N)](http://nvd.nist.gov/cvss.cfm?vector=(AV:N/AC:M/AU:N/C:P/I:P/A:N&version=2.0))

