---
layout: post
title: C-Based Toolchain Hardening
---
<!---
C-Toolchain
-->
Synopsis
---------
C-Based Toolchain Hardening is a treatment of project settings that will help you deliver reliable and secure code when using C, C++ and Objective C languages in a number of development environments.

Description
------------
There are four areas to be examined when hardening the toolchain: configuration, preprocessor, compiler, and linker. Nearly all areas are overlooked or neglected when setting up a project.For a more in-depth treatment of this topic view:- [OWASP Guide on CBased Toolchain hardening](https://www.owasp.org/index.php/C-Based_Toolchain_Hardening)

Mitigation
-----------
Scanners and tools cannot verify cryptographic weakness. Best way is the review of code,cryptographic algorithm and key management.  

 - Ensure strong standard algorithms and strong keys are used,managed and backed up separately.
 - Ensure passwords are hashed with strong standard algorithm and appropriate salt is used.
 - Ensure all keys and password are protected from unauthorized access.

Advantages of it include enhanced warnings and static analysis, and self-debugging code. To create executables with firmer defensive postures and increased integration with the available platform security follow the steps provided here:- [ C-Based Toolchain Hardening Cheat Sheet](https://www.owasp.org/index.php/C-Based_Toolchain_Hardening_Cheat_Sheet)


CVSS Base Score:
----------------

[Calculator](http://nvd.nist.gov/cvss.cfm?calculator&version=2)

