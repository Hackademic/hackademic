<html>
  <body style="background-color:black">
<?php
if ((isset($_COOKIE["User"])) && ($_COOKIE["User"] != "Marcous"))
{
  print ('<p style="color:white">Forbidden! You are not authed. Please leave this page.');
  print("<i>Your forbidden attempt to access this page has been recorded</i>");
}
else
{
  print('<p style="color:white">Hello Admin, your password in order to continue is the following <<48bb6e862e54f2a795ffc4e541caed4d>>. Do not forget to decrypt it!</p>');
}
?>