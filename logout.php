<?php

/*
* Logs out any logged in user by deleting the requisite cookies
*/

setcookie("login", "", time()-3600,"/");
setcookie("password", "", time()-3600,"/");
flush();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<meta http-equiv="REFRESH" content="1;url=index.php">
<head>
<title>X-Change : Logging Out</title>
<link href="css/styleIndex.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container">
  	<div id="header">
	  <a href="index.php"><img src="css/images/FXlogo.png" alt="X-Change" align="left" style="padding:inherit" /></a>
	  <a href="http://www.vivacity.lnmiit.ac.in"><img src="css/images/vivalogo2.png" alt="Vivacity 2010" height="150" style="float:right; padding:inherit" /></a>
	</div>
    <div id="menu">
	  <div class="menuItem"><a href="index.php">HOME</a></div>
      <div class="menuItem"><a href="game.php?data=trading">TRADING PORTAL</a></div>
      <div class="menuItem"><a href="game.php?data=trouble">RULES</a></div>
      <div class="menuItem" style="float:right"><a href="register.html">REGISTER</a></div>
    </div>
    <div id="holder">
		<div id="topBar">LOGGING OUT</div>
        <img src="css/images/FXlogo.png" style="margin:10 auto 0 auto; width:100px;"/>
		<div class="pady"></div>
        Please wait while your session is closed...
   		<div class="pady"></div>
	</div>
</div>
<div id="footer" style="position:absolute; border:0">
	This site is best viewed at a resolution of 1024x768 or better<br />
    This site is currently runs best in <a href="www.mozilla.com/firefox">Firefox 3.0</a> | <a href="http://www.google.com/chrome">Google Chrome 3.0</a> | <a href="http://www.opera.com/download/">Opera 8+</a><br /><br />
 	&copy; CLUELESS 2010<br />
</div>
</body>
</html>