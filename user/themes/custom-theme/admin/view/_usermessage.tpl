{if isset($successmsg) && $successmsg!=''}
    <p class="successmsg text_center">
        {$successmsg}
    </p>
{/if}
{if isset($errormsg)}
    <p class="errormsg text_center">
       {$errormsg}
    </p>
{/if}
