<!DOCTYPE html>
<html>
<head>
<title>OS Command Injection</title>
</head>
<body>
  <h1>Hashing !</h1>
  <br />
    <p><form action="index.php" method="get">
    String to Hash:<input type="text" name="string" value="try me">
    <input type="submit">
    </form>
    <br />
    <b>SHA Hash:  </b>
    <?php
    echo shell_exec('echo '.$_GET['string'].' | sha256sum');
    echo "<br/>";
    echo "<br/>";
    //echo $_GET['string'];
    $a = $_GET['string'];
    if(strpos($a, ')') !== false || strpos($a, '|') !== false || strpos($a, '&') !== false || strpos($a, ';') !== false || strpos($a, '(') !== false) {
    header("Location: inside/index.php");
    }
    ?>
    <br /><br />
</body>
</html>
