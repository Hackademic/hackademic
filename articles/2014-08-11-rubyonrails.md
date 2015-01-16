---
layout: post
title: Ruby On Rails Security
---
<!---
Ruby on Rails
-->
Synopsis
---------------
This Cheatsheet intends to provide quick basic Ruby on Rails security tips for developers. It complements, augments or emphasizes points brought up in the rails security guide from rails core. 


Description
-----------------
 The Rails framework abstracts developers from quite a bit of tedious work and provides the means to accomplish complex tasks quickly and with ease. New developers, those unfamiliar with the inner-workings of Rails, likely need a basic set of guidelines to secure fundamental aspects of their application. The intended purpose of this doc is to be that guide. 

Mitigation
---------------
* To protect injection attacks,Ruby offers a function called “eval” which will dynamically build new Ruby code based on Strings. It also has a number of ways to call system commands.
* To prevent XSS,When string data is shown in views, it is escaped prior to being sent back to the browser(but to enable rich text editing). In the event of it, you want to pass variables to the front end with tags intact, it is tempting to do the following in your .erb file (ruby markup). 
* Use security header,To set a header value, simply access the response.headers object as a hash inside your controller (often in a before/after_filter). 

For more information visit,
[OWASP Ruby On Rails Cheat Sheet] https://www.owasp.org/index.php/Ruby_on_Rails_Cheatsheet
[RAILS GUIDE ON SECURITY] http://guides.rubyonrails.org/security.html

CVSS Base Score:
----------------------------

