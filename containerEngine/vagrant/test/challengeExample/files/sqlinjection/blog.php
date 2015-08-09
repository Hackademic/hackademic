
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../../Downloads/bootstrap-3.0.0/assets/ico/favicon.png">

    <title>Welcome to the first challenge!</title>

    <!-- Bootstrap core CSS -->
    <link href="static/css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="navbar.css" rel="stylesheet">

   
</head>

<body>

<!--<script type="text/javascript">
    $(document).ready(function() {
        $("body").css("display", "none");

        $("body").fadeIn(2000);

        $("a").click(function(event){
            event.preventDefault();
            linkLocation = this.href;
            $("body").fadeOut(1000, redirectPage);
        });

        function redirectPage() {
            window.location = linkLocation;
        }
    });
</script>-->

<div class="container">

    <!-- Static navbar -->
    <div class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Wowe</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li class="active"><a href="doge.php">Such</a></li>
                <li><a href="doge.php">Dead</a></li>
                <li><a href="doge.php">Hrefs</a></li>
                <li><a href="doge.php">Many</a></li>
                <li><a href="doge.php">Sadness</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>

   
    <div class="jumbotron">
        <p>Please enter your user ID so you can read/make blog posts
        
       </p>
      <p></p>   
       <p>
            <b>CHALLENGE TWO:</b><br/>
            <br><pre>
       <form method="GET"> 
	
		
		<input type="text" class="form-control" name="id">
                <input type="submit" value="submit" name="Submit"></input>
       </form>
         <?php
    if(isset($_GET['Submit'])){
	$id = $_GET['id'];

	$con = mysql_connect("localhost","root","");
        mysql_select_db("ctf");

	$getid = "SELECT name FROM flag WHERE id = '$id'";

	$result = mysql_query($getid) or die('<pre>' . mysql_error(). '</pre>');

	$num = mysql_numrows($result);
	$i = 0;

	
	while ($i < $num){
	$first = mysql_result($result,$i,'name');
        echo '<pre>';  
	echo 'ID : ' . $id . ' <br>Flag : ' . $first .' ';
	echo '</pre>';
	
	$i++;


}
}
?>   
   </pre>
    </div>
</div>

<!--
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../../../Downloads/bootstrap-3.0.0/assets/js/jquery.js"></script>
<script src="static/js/bootstrap.min.js"></script>
<script src="static/js/background.js" type="text/javascript"></script>
</body>
</html>

