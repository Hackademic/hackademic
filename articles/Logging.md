
<!---
Logging
-->
Synopsis:
---------------
Logging is the recording of information into storage that details who performed what and when they did it (like an audit trail).

Description:
-------------------
Logging provides a detective method to ensure that the other security mechanisms being used are performing correctly. A good logging strategy should include log generation, storage, protection, analysis, and reporting.

For more details: [OWASP Reviewing Code for Logging Issue](https://www.owasp.org/index.php/Reviewing_Code_for_Logging_Issues).


Mitigation:
----------------
- Use a centralized logging mechanism that supports multiple levels of detail to log all security-related successes and failures.

- Usage of Application firewalls,Intrusion detection systems,Network firewalls,filters built into web server S/W AND server redirects,trigger-base actions and other applications such as fraud monitoring and CRM.

For more details:[MITRE definitions](http://cwe.mitre.org/data/definitions/778.html).

For guidance on building application logging mechanisms, especially related to security logging visit: [OWASP Logging Cheat Sheet](https://www.owasp.org/index.php/Logging_Cheat_Sheet).  

CVSS Base Score:
-----------------------------

