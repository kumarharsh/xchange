<html>
<head>
<meta http-equiv="pragma" content="no-cache" />
<title>X-Change</title>
<link href="css/styleIndex.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container">
  	<div id="header">
	  <a href="index.php"><img src="css/images/FXlogo.png" alt="X-Change" align="left" style="padding:inherit" /></a>
	  <a href="http://www.vivacity.lnmiit.ac.in"><img src="css/images/vivalogo2.png" alt="Vivacity 2010" height="150" style="float:right; padding:inherit" /></a>
	</div>
	<div id="menu">
		<div class="menuItem"><a href="index.php?data=home">HOME</a></div>
	    <div class="menuItem"><a href="index.php?data=trouble">RULES</a></div>
	    <div class="menuItem" style="float:right"><a href="register.html">REGISTER</a></div>
  	</div>
<script type='text/javascript' src='javascript/login.js'></script>
<?php
	/*
	* If login is successful, then cookie has been set
	* so just goto the main trading page
	* else login
	*/
	if(isset($_COOKIE['login']) && isset($_COOKIE['password']))
	{
		$data = explode("+",$_COOKIE['login']);
		$pass = explode("+",$_COOKIE['password']);
		if($pass[0]!=md5($pass[1]))
		{
			include("login/signedin.html");
		}
		echo "<script type='text/javascript'>";
		printf ("callServer( '%s', '%s' )",  $data[0], $data[1] );
		echo "</script>";
	}
	else
	{
		if(!isset($_REQUEST["data"]) || $_REQUEST["data"]==="home")
		{
			printf("<script type=\"text/javascript\" src=\"javascript/md5-min.js\"></script>");
			include("login/basicdata.html");
			echo "<div class=\"pady\"></div>";
			echo "</div>
				  <div id=\"footer\">";
		}
		else if($_REQUEST["data"]==="trouble")
		{
			echo "<div class=\"pady\"></div>";
			include("troubleshooting.html");
			echo "<div class=\"pady\"></div>";
			echo "</div>
				  <div id=\"footer\">";
		}
		else
		{
			include("error.html");
			echo "<div class=\"pady\"></div>";
			echo "</div>
				  <div id=\"footer\">";
		}
	}
?>

	This site is best viewed at a resolution of 1024x768 or better<br />
    This site is currently runs best in <a href="www.mozilla.com/firefox">Firefox 3.0</a> | <a href="http://www.google.com/chrome">Google Chrome 3.0</a> | <a href="http://www.opera.com/download/">Opera 8+</a><br /><br />
 	&copy; CLUELESS 2010<br />
</div>
</body>
</html>
