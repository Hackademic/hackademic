<?php

// Author Divam Gupta
// github.com/divamgupta

// The main vulnerable Web Application

session_start(); 

$username = $password = $userError = $passError = '';


if(isset($_POST['login'])){
  $username = $_POST['username']; $password = $_POST['password'];


  if($username === 'admin' && $password === 'ccedjbvcfrvvuibdhbchdbchdbhcdhccdv'){
    $_SESSION['mode'] = "admin";;
  }
  else if($username === 'user' && $password === 'user'){
    $_SESSION['mode'] = "user";
  }
  else echo "Invalid Login Credentials";
}


if(isset($_POST['comm'])){
  $txt = $_POST['comment']."<hr><hr>";
  $myfile = file_put_contents('logs.html', $txt.PHP_EOL , FILE_APPEND);
}




if(isset($_POST['logout'])){
  unset($_SESSION['mode']);
  session_destroy();
}

$islogin = false;

if(isset($_SESSION['mode']))
  $islogin = true;



?>


<?php if(!($islogin)){ ?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
   <head>
     <meta http-equiv='content-type' content='text/html;charset=utf-8' />
     <title>Login</title>
   </head>
<body>
  <form name='input' action="<?php echo $_SERVER['PHP_SELF'] ;?>" method='post'>
    <label for='username'></label><input type='text' value='' id='username' name='username' />
    <label for='password'></label><input type='password' value='' id='password' name='password' />
    <input type='submit' value='Login' name='login' />
  </form>
  <hr>
  Demo user details : username : user , password : user


</body>
</html>

<?php }  else { 

  if($_SESSION['mode'] == 'admin') $tagLine = "Welcome admin ... The flag is seSSi0n_h!Jack1ng_!s_@wesOmEEEEE! ";
  if($_SESSION['mode'] == 'user') $tagLine = "Welcome user ... Try to break into admin!";


  ?>


<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>
   <head>
     <meta http-equiv='content-type' content='text/html;charset=utf-8' />
     <title>Login</title>
   </head>
<body>


  <h1> <?php echo $tagLine ?> </h1>

   <form name='input' action="<?php echo $_SERVER['PHP_SELF'] ;?>" method='post'>
    <input type='submit' value='logout' name='logout' />
  </form>

  <hr>


  <form name='input' action="<?php echo $_SERVER['PHP_SELF']; ?>" method='post'>
    <label for='Comment'></label><input type='text' placeholder=' Enter a Comment Here ! ' id='comment' name='comment' />
    <input type='submit' value='Post' name='comm' />
  </form>


  <hr>
  <h3>  Comments : </h3>

  <?php  echo file_get_contents("logs.html"); ?> 


</body>
</html>




<?php }  ?>

