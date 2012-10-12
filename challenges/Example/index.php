<html>
<head>
<meta http-equiv="Content-Language" content="en-us">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1253">
<title>Challenge Template Example</title>
</head>

<body >
<div>Hi!
<p>
This is a simple challenge template to illustrate the only two constraints of any hackademic challenge.</p>
1. Every challenge should come with a .xml file describing the challenge which is like this:</div>
<div>
<pre>
&lt;?xml version="1.0" encoding="UTF-8"?&gt;
&lt;challenge&gt;
    &lt;title>Example Template For Challenge .xml Files creation&lt;/title&gt;
    &lt;author&gt;
	Name or email or both
    &lt;/author&gt;
    &lt;category>In what category does your challenge belong?(web? crypto? networks?)&lt;/category&gt;
    &lt;description&gt;
	Insert some text describing the scenario of the challenge(what the users are supposed to do and if there is any fictional story)
    &lt;/description&gt;
    &lt;level&gt;
	Either an interger from 1  to 10 with 1 being the easiest , or one of beginner, intermediate, advanced , hide_yo_wife, bad1d3a
	The level will be the max points a user can get.
	beginner:	2pts	
	intermediate	4pts
	advanced	6pts
	hide_yo_wife	8pts
	bad1d3a		10pts
    &lt;/level&gt;
	&lt;duration&gt;
	The duration after which a user is disqualified.
	The timer starts when a username starts a challenge for first time.
	&lt;/duration&gt;
&lt;/challenge&gt;
</pre>
</div>
<pre>
2. In order to update a user's score in the hackademic database one must include the following
	This include (once the session has started)
	<code>require_once($_SESSION['hackademic_path']."pages/challenge_monitor.php");</code>
	The following on challenge success
	<code>$monitor->update(CHALLENGE_SUCCESS);</code>
	And the following for every challenge failure
	<code>$monitor->update(CHALLENGE_FAILURE);</code>
Simple?
Enjoy


The rest depend on your administrator policies regarding what is considered a valid challenge.
</pre>
</body>


</html>
