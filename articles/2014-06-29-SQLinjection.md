---
layout: post
title: SQL Injection
---
<!---
SQL
-->
Synopsis:
----------------
SQL injection attacks are a type of injection attack, in which SQL commands are injected into data-plane input in order to effect the execution of predefined SQL commands.

Description:
-------------------
A successful SQL injection exploit can read sensitive data from the database,accept data from an untrusted internet source,modify the data, execute administrative operations on the database(shutting down the DBMS),recover the content of a given file present on the DBMS file system and in certain cases issue commands to the operating system.

For more details:- [OWASP guide on SQL Injection](https://www.owasp.org/index.php/SQL_Injection) 

Also see:-[MITRE definitions](http://cwe.mitre.org/data/definitions/89.html)

Mitigation:
----------------
- Sanitize the input(such as MySQL' mysql_real_escape_string() function) to ensure dangerous characters such as "'" are not passed and use persistance layers such as Hibernate or Enterprise Java Beans.

- Check server logs in a regular basis to verify that no one pokes you with malicious codes,use a WAF.

- Encrypt or hash passwords and other confidential data including connection strings

For more details:[OWASP Testing for SQL injection attacks](https://www.owasp.org/index.php/Testing_for_SQL_Injection_(OWASP-DV-005))

See SQL-Injection [OWASP Prevention cheat sheet](https://www.owasp.org/index.php/SQL_Injection_Prevention_Cheat_Sheet) 


CVSS Base Score:
----------------------------
[7.5 (AV:N/AC:L/AU:N/C:P/I:P/A:P)](http://nvd.nist.gov/cvss.cfm?vector=%28AV:N/AC:L/AU:N/C:P/I:P/A:P%29&version=2.0) 

