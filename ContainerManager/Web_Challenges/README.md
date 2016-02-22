## Challenges Section


This is the place where challenge authors can create and place their challenges. In order to use the power of `docker containers` for effective sandbox, there is a systematic method to create and add challenges which is as follows:

### Creating Challenges:

The vulnerable piece of code is given to the user in an editor called [Ace Editor](/editor/). So here is how you can add challenges based on PHP (only PHP is supported now):

* Make a copy of the entire directory `sample challenge` and rename it to your challenge name `without spaces` (while renaming, don't give spaces) !

* Open `index.html` and go to div editor which looks like this:

```javascript
<div id="editor">
Place your vulnerable PHP code here
    </div>

```

* After saving the index.html, modify the `unittest.php` which is were we actually execute the submitted code back from the user. A sample is given.

### Verifying challenges:

* In order to make sure challenge is working, go the `challengename/index.html` and try submitting both correct and wrong codes. See if right responses are coming back.


If you come across any bugs, please report it [here](https://github.com/hackademic/hackademic/issues). Thanks !
