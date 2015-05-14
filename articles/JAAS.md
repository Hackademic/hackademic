
<!---
JAAS
-->
Synopsis:
-----------------
JAAS provides a powerful mechanism for integrating any authentication scheme into a Java application.


Description:
------------------
The process of verifying the identity of a user or another system is authentication. JAAS, as an authentication framework manages the authenticated user’s identity and credentials from login to logout.

The main features being Password stored in SHA-256 hash,Incermental time based lockout,Authentication against a DB using JDBC for users and roles. 

The process have been explained in the Tomcat MOdule below.
For more information : [OWASPJAAS Tomcat Login Module](https://www.owasp.org/index.php/JAAS_Tomcat_Login_Module)
For more details: [OWASP JAAS Timed Login Module](https://www.owasp.org/index.php/JAAS_Timed_Login_Module) 

Mitigation:
-----------------
- The OWASP JAAS Timed Login Module is an implementation of a JAAS LoginModule that provides an escalating time based lockout facility and authentication against a database which could be used to prevent brute force attacks.

- A LoginModule should have initialize(), login(), commit(), abort(), logout(). 

- The callbackHandler is in a source (.java) file separate from any single LoginModule so that it can service a multitude of LoginModules with differing callback objects.


For more details: [OWASP JAAS Cheat Sheet](https://www.owasp.org/index.php/JAAS_Cheat_Sheet) 
[JAAS](http://jaasbook.com/)


CVSS Base Score:
----------------------------
[5.0(AV:N/AC:L/AU:N/C:N/I:P/A:N)](http://nvd.nist.gov/cvss.cfm?vector=%28AV:N/AC:L/AU:N/C:N/I:P/A:N%29&version=2.0)

