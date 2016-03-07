## Challenges Section


This is the place where challenge authors can create and place their challenges. In order to use the power of `docker containers` for effective sandbox, there is a systematic method to create and add challenges which is as follows:

### Creating Challenges:

The vulnerable piece of code is given to the user in an editor called [Ace Editor](/editor/). So here is how you can add challenges based on PHP (only PHP is supported now):

* Make a copy of the entire directory `samplechallenge` and rename it to your challenge name `without spaces` (while renaming, don't give spaces) !

*  Open `index.html`.

* Introduction.

```html
<div class="introdution-text">
    <p id="introdution-title">
        Place the text here
    </p>
</div>
```

* Instructions.

```html
<div class="instructions-text">
    <p class="font2">
        Place your instructions here.
    </p>
</div>
```
* Vulnerable code that needs to be fixed.

```html
<div id="editor">
    Place your vulnerable PHP code here
</div>
```

* Hint text and code.

```html
<div class="hint-text">
    <p class="font" style="font-size:1em;">
        Hint intro here.
    </p>
    <p class="font blue">
        Important info here and links.
    </p>
    <p class="font black">
        Your code here
    </p>
</div>
```


* Change the language mode of editor, default is PHP(Change if your challenge deals with other languages).

```javascript
editor.getSession().setMode({path:"ace/mode/php", inline:true});
```
change ```ace/mode/<Your language here> ```

* After saving the index.html, modify the `unittest.php` which is were we actually execute the submitted code back from the user. A sample is given.

### Verifying challenges:

* In order to make sure challenge is working, go the `challengename/index.html` and try submitting both correct and wrong codes. See if right responses are coming back.


If you come across any bugs, please report it [here](https://github.com/hackademic/hackademic/issues). Thanks !
