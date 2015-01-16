
<!---
Input validation
-->

Synopsis:
---------------
Input validation refers to the process of validating all the input to an application before using it. 

Description:
------------------

Many applications do not plan input validation, and leave it up to the individual developers. This is a recipe for disaster, as different developers will certainly all choose a different approach, and many will simply leave it out in the pursuit of more interesting development.

Mitigation:
---------------
- Use an input validation framework such as Struts or the OWASP ESAPI Validation API. Use an "accept known good" input validation strategy.

- White List Regular Expression Examples and Java Regex example usage have been given in the below link. 
 [OWASP Input Validation Cheat Sheet](https://www.owasp.org/index.php/Input_Validation_Cheat_Sheet)

- Include Integrity checks,Validation and Business rules.

For more details: [MITRE definition](http://cwe.mitre.org/data/definitions/20.html) 
[Data Validation](https://www.owasp.org/index.php/Data_Validation)

CVSS Base Score:
----------------------------

