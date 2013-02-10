<?php

/*
* This file takes two input parameters
*1. username --- username of the person wanting to close their transaction
*2. transactionID --- trascationID of trasaction to be closeds
*  This also checks two cookies
*1. login
*2. password
* the file closes the transaction of <username> with tid <transactionID>
*/

include("../include/dbInfo.php");
include("../include/equity.php");

//Report error and quit
function errorReport($errorText)
{
	echo "<msg>".$errorText."</msg></transactionStatus>";
	//mysql_close($con);
	exit;
}
	
//Stores fuctions to close transactions and calculate equity

header('Content-type: text/xml');
echo "<transactionStatus>";

//Check if all input parameters are set
if(!isset($_COOKIE["login"]) || !isset($_COOKIE["password"]))
{
	errorReport("Cookies not set!\nYour session may have expired\nPlease login again");
	exit;
}
if(isset($_COOKIE["password"]))
{
	$tmp = explode("+",$_COOKIE["password"]);
	if(strcmp($tmp[1],md5(str_rot13($tmp[0])))!=0)
	{
		errorReport("Cheater!!");
		exit;
	}
}
if(!isset($_REQUEST["username"]) && !isset($_REQUEST["transactionID"]))
{
	errorReport("Incorrect Use of Page");
	exit;
}

//Connect to database
$con = mysql_connect($DB_HOST,$DB_USERNAME,$DB_PASSWD) or die(errorReport(mysql_error()));
mysql_select_db($DB_DATABASENAME,$con) or die(errorReport(mysql_error()));

//Set input parameters
$transactionID = $_REQUEST["transactionID"];
$username = $_REQUEST["username"];
$result = mysql_query( "SELECT * FROM `transactions` WHERE `username`='$username' AND `transactionID`=$transactionID;") or die(errorReport(mysql_error()));
$row=mysql_fetch_array($result);
$active = $row['active'];
if($active==1)
{
	$currency = $row['currencyName'];
	
	//Get prices
	include("../include/pathInfo.php");
	$xml = simplexml_load_file("$PATH_WEB/webservices/getQuotes.php?data=".$currency);
	$bidPrice = $xml->quote[0]->bid;
	$askPrice = $xml->quote[0]->ask;
	
	
	$type = $row['type'];
	$noOfLots = $row['noOfLots'];
	$leverage = $row['leverage'];
	$principal = $row['principal'];
	$date = $row['date'];
	$amt = calculateClosePrice($currency, $type, $noOfLots, $leverage, $principal, $date);
	$result = mysql_query( "SELECT `accValUSD` FROM `userData` WHERE `username`='$username';") or die(mysql_error());
	$row=mysql_fetch_array($result);
	$account = $row["accValUSD"] + $amt;

	$result = mysql_query( "SELECT `type` FROM `transactions` WHERE `username`='$username' AND `transactionID`=$transactionID;") or die(mysql_error());
	$row=mysql_fetch_array($result);
	$type = $row["type"];

	$equity = equity($username);
	mysql_query("UPDATE `userData` SET `accValUSD`=$account WHERE `username`='$username';");
	if($type==="long")
		mysql_query("UPDATE `transactions` SET `closePrice`=$askPrice WHERE `username`='$username' AND `transactionID`=$transactionID;") or die(mysql_error());
	else
		mysql_query("UPDATE `transactions` SET `closePrice`=$bidPrice WHERE `username`='$username' AND `transactionID`=$transactionID;") or die(mysql_error());
	mysql_query("UPDATE `userData` SET `equity`='$equity WHERE `username`='$username';");
	mysql_query("UPDATE `transactions` SET `active`=0 WHERE `username`='$username' AND `transactionID`=$transactionID;");
	errorReport("Transaction Closed\nPlease check back after some moments as we update your history");
}
else
	errorReport("Transaction has already been closed");


?>