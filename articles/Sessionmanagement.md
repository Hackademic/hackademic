
<!---
Session Management
-->
Synopsis
---------------
A web session is a sequence of network HTTP request and response  associated to the same user. Modern and complex web applications require the retaining of information or status about each user for the duration of multiple requests. Therefore, sessions provide the ability to establish variables such as access rights and localization settings. 

Description
-----------------
In order to keep the authenticated state and track the users progress within the web application, applications provide users with a session identifier (session ID or token) that is assigned at session creation time, and is shared and exchanged by the user and the web application. It includes Session ID length,fingerprinting,content.


Mitigation
---------------
To detect session attacks,
*  Session ID Guessing and Brute Force Detection.
* With the goal of detecting (and, in some scenarios, protecting against) user misbehaviors and session hijacking, it is highly recommended to bind the session ID to other user or client properties, such as the client IP address,user agent.
* Logging Sessions Life Cycle: Monitoring Creation, Usage, and Destruction of Session IDs.

For more information see,
[OWASP Cookies DB] https://www.owasp.org/index.php/Category:OWASP_Cookies_Database
[OWASP Session Management] https://www.owasp.org/index.php/Session_Management_Cheat_Sheet



CVSS Base Score:
----------------------------

