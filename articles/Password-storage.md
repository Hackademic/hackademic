
<!---
Password storage shet
-->
Synopsis
---------------
This article provides guidance on properly storing passwords, secret question responses, and similar credential information.

Description
-----------------
Proper storage helps prevent theft, compromise, and malicious use of credentials. Information systems store passwords and other credentials in a variety of protected forms. Common vulnerabilities allow the theft of protected passwords through attack vectors such as SQL Injection. Protected passwords can also be stolen from artifacts such as logs, dumps, and backups. 

Mitigation
---------------
*  Do not limit the character set and set long max lengths for credentials.
*  Use a cryptographically strong credential-specific salt.
*  Design password storage assuming eventual compromise.

For more information visit,
[OWASP Password Storage Cheat Sheet] https://www.owasp.org/index.php/Password_Storage_Cheat_Sheet


CVSS Base Score:
----------------------------

