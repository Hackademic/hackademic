
<!---
DOM based XSS
-->
Synopsis
---------------
This cheatsheet addresses DOM (Document Object Model) based XSS and is an extension (and assumes comprehension of) the XSS Prevention Cheatsheet. 

Description
-----------------
In order to understand DOM based XSS, one needs to see the fundamental difference between Reflected and Stored XSS when compared to DOM based XSS. Reflected and Stored XSS are server side execution issues while DOM based XSS is a client (browser) side execution issue. All of this code originates on the server, which means it is the application owner's responsibility to make it safe from XSS, regardless of the type of XSS flaw it is. 

Mitigation
---------------
* One example of an attribute which is usually safe is innerText. Some papers or guides advocate its use as an alternative to innerHTML to mitigate against XSS in innerHTML. 
* Untrusted data should only be treated as displayable text. Never treat untrusted data as code or markup within JavaScript code. 
* Be Careful when Inserting Untrusted Data into the Event Handler and JavaScript code Subcontexts within an Execution Context.
*  HTML Escape then JavaScript Escape Before Inserting Untrusted Data into HTML Subcontext within the Execution Context.

For more information visit,

[OWASP DOM BASED XSS] https://www.owasp.org/index.php/DOM_based_XSS_Prevention_Cheat_Sheet
