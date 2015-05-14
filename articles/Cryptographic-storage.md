
<!---
Cryptography
-->
Synopsis:
----------------
Insecure Cryptographic Storage is a vulnerability that occurs when sensitive data is not stored securely.


Description:
-------------------
Insecure Cryptographic Storage is a collection of vulnerabilities which has to deal with the most important data is not encrypted leading to leak of sensitive information.The most common flaw in this area is not encrypting data that deserves encryption.When encryption is employed, unsafe key generation and storage, not rotating keys, and weak algorithm usage is common.


Mitigation:
----------------
- Start with manual approach. Scanners and tools cannot verify cryptographic weakness. Best way is the review of code, review of used cryptographic algorithm and key management.  

- Ensure strong standard algorithms and strong keys are used,managed,usage of salt and backed up separately.

- Ensure all keys and password are protected from unauthorized access.

For more details :

[OWASP Cryptographic_Storage_Cheat_Sheet](https://www.owasp.org/index.php/Cryptographic_Storage_Cheat_Sheet)

[Owasp Top 10](https://www.owasp.org/index.php/Top_10_2010-A7-Insecure_Cryptographic_Storage)

[Interface Encryptor](https://owasp-esapi-java.googlecode.com/svn/trunk_doc/latest/org/owasp/esapi/Encryptor.html)


CVSS Base Score:
-------------------------

