<?php

/*
* This is the game portal... all people playng this game will have to come here
* This page takes one input parameter - 
* 1. data --- this is the name of the page which needs to be opened
* it checks for two cookies "login" and "password" which are set when an user logs in
* The page dynmically loads whichever page is being required from the user
* static content on the page is mainly the header and the menu bar
*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/styleIndex.css" rel="stylesheet" type="text/css" />
<script src="javascript/marquee.js" type="text/javascript"></script>
<title>X-Change : Trading Portal</title>
</head>
<body>
<div id="container">
  	<div id="header">
  	  <a href="index.php"><img src="css/images/FXlogo.png" alt="X-Change" align="left" style="padding:inherit" /></a>
	  <a href="http://www.vivacity.lnmiit.ac.in"><img src="css/images/vivalogo2.png" alt="Vivacity 2010" height="150" style="float:right; padding:inherit" /></a>
	</div>
	<div id="menu">
		<div class="menuItem"><a href="game.php?data=trading">TRADING PORTAL</a></div>
    	<div class="menuItem"><a href="game.php?data=transaction">TRANSACTION HISTORY</a></div>
	    <div class="menuItem"><a href="game.php?data=toplist">TOP INVESTORS</a></div>
        <div class="menuItem"><a href="game.php?data=market">MARKET HISTORY</a></div>
	    <div class="menuItem"><a href="game.php?data=trouble">RULES</a></div>
        <div class="menuItem"><a onclick="window.location.reload()"><img src="css/images/reload.gif" /></a></div>
	    <div class="menuItem" style="float:right"><a href="logout.php">LOGOUT
		<?php 
		if(isset($_COOKIE["password"]))
			{
				$data = explode("+",$_COOKIE["login"]);
				$username = $data[0];
			}
			echo "($username)";
		?></a></div>
	</div>
<!-- although the extra DIV tags seem unnecessary, they are essential to display the marquee correctly... -->
	<div id="ticker">
    	<div class="dmarquee">
        <?php
			include("include/dbInfo.php");
//			include("include/equity.php");
			
			if(isset($_COOKIE["password"]))
			{
				$data = explode("+",$_COOKIE["login"]);
				$username = $data[0];
			}
			$con = mysql_connect($DB_HOST,$DB_USERNAME,$DB_PASSWD) or die(mysql_error());
			mysql_select_db($DB_DATABASENAME,$con) or die(mysql_error());
			$result = mysql_query( "SELECT `accValUSD`, `equity` FROM `userData` WHERE `username`='$username'") or die(mysql_error());
			$tmp = mysql_fetch_array($result);
			mysql_close($con);
			echo "<div><div>";
    	    printf("※※※ Your current Account Value is <span style=\"color:#fff;\">USD %0.4f</span> ※※",$tmp['accValUSD']);
    	    printf("※ Your current Equity is <span style=\"color:#fff;\">USD %0.4f</span> ※※※",$tmp['equity']);
			echo "</div></div>";
//			echo "Your current equity is ".equity($username)."</div></div>";
		?>
        </div>
    </div>
    <div class="pady"></div>
	<div id="board">
<?php
	//Check if login data is correct
	if($_REQUEST["data"] === "trouble") {}
	else
	{
		if(!isset($_COOKIE["login"]) || !isset($_COOKIE["password"]))
		{
			printf("<script type='text/javascript'>window.location.href = \"./index.php\";</script>");
			exit;
		}
		if(isset($_COOKIE["password"]))
		{
			$tmp = explode("+",$_COOKIE["password"]);
			if(strcmp($tmp[1],md5(str_rot13($tmp[0])))!=0)
			{
				printf("<script type='text/javascript'>window.location.href = \"./logout.php\";</script>");
				exit;
			}
		}
	}
	include("include/pathInfo.php");
	include("include/equity.php");
	include("include/dbInfo.php");
	//Depending on argument load respective page
	if($_REQUEST["data"]==="trading")
		include("game/tradingportal.php");
	else if($_REQUEST["data"]==="transaction")
		include("game/transactionHistory.php");
	else if($_REQUEST["data"]==="toplist")
		include("game/toplist.php");
	else if($_REQUEST["data"]==="trouble")
		include("troubleshooting.html");
	else if($_REQUEST["data"]==="market")
		include("game/market.php");
	else
		include("error.html");
?>
	</div>
    <span> </span>
</div>
<div id="footer">
	This site is best viewed at a resolution of 1024x768 or better<br />
    This site is currently runs best in <a href="www.mozilla.com/firefox">Firefox 3.0</a> | <a href="http://www.google.com/chrome">Google Chrome 3.0</a> | <a href="http://www.opera.com/download/">Opera 8+</a><br /><br />
 	&copy; CLUELESS 2010<br />
</div>
</body>
</html>