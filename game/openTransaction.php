<?php

/*
* This file takes two input parameters
*1. lots --- no of lots to be bought
*2. type --- long or short
*3. curr --- the 2nd currency in the pair
*4. levg --- leverage(A decimal value)
*  This also checks two cookies
*1. login
*2. password
* the file creates a trasaction with the given input details
*/

//Report error and quit
function errorReport($errorText)
{
	echo "<msg>".$errorText."</msg></transactionStatus>";
	exit;
}

include("../include/dbInfo.php");
include("../include/pathInfo.php");
include("../include/equity.php");

header('Content-type: text/xml');

echo "<transactionStatus>";

//Check if all input parameters are set
if(!isset($_COOKIE["login"]) || !isset($_COOKIE["password"]))
{
	errorReport("Cookies not set");
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
if(!isset($_REQUEST["lots"]) && !isset($_REQUEST["type"]) && !isset($_REQUEST["curr"]) && !isset($_REQUEST["levg"]))
{
	errorReport("Incorrect Use of Page");
	exit;
}

//Connect to database
$con = mysql_connect($DB_HOST,$DB_USERNAME,$DB_PASSWD) or die(errorReport(mysql_error()));
mysql_select_db($DB_DATABASENAME,$con) or die(errorReport(mysql_error()));

//Define all input parameters
$tmp = explode("+",$_COOKIE["login"]);
$username = $tmp[0];
$lots = $_REQUEST["lots"];
$typeOfTransaction = $_REQUEST["type"];
$currency = $_REQUEST["curr"];
$lotSize = 100000;
$leverage = $_REQUEST["levg"];
$date = date("d/m/y");
$result = mysql_query( "SELECT `transactions`,`accValUSD` FROM `userData` WHERE `username`='$username'") or die(errorReport(mysql_error()));
$tmp = mysql_fetch_array($result);
$transactions = $tmp[0];
$account = $tmp[1];
if($account <= 0)
	errorReport("Insufficient Balance\nCan not complete Transaction");
	
//Get prices
$xml = simplexml_load_file("$PATH_WEB/webservices/getQuotes.php?data=".$currency);
$bidPrice = $xml->quote[0]->bid;
$askPrice = $xml->quote[0]->ask;
//Process transaction
// BUY at BID price
// SELL at ASK price
if($typeOfTransaction==="long")
{
	$principal = (double)((1-$leverage)*$lots*$lotSize/(double)$bidPrice);		// principal is amount that broker pays
	$account = $account - (double)($leverage*$lots*$lotSize/(double)$bidPrice);

	$file=fopen("test1.txt","a");
	fwrite($file,"$principal = (1-$leverage)*$lots*$lotSize/$bidPrice;\t\t");
	fclose($file);

	mysql_query("INSERT INTO `transactions` (`currencyName`, `type`, `noOfLots`, `leverage`, `initPrice`, `date`,`username`,`principal`) 
				VALUES ('$currency', '$typeOfTransaction', $lots, $leverage, $bidPrice, '$date', '$username', $principal);");
	$result = mysql_query( "SELECT `transactionID` FROM `transactions` 
						    WHERE `username`='$username' AND `currencyName`='$currency' AND `type`='$typeOfTransaction'
							ORDER BY `transactionID` DESC;") or die(errorReport(mysql_error()));
	$tmp = mysql_fetch_array($result);
}
else
{
	$principal = (double)((1-$leverage)*$lots*$lotSize/(double)$askPrice);		// principal is amount that broker pays ALWAYS +ve
	$account = $account + (double)($leverage*$lots*$lotSize/(double)$askPrice);
	mysql_query("INSERT INTO `transactions` (`currencyName`, `type`, `noOfLots`, `leverage`, `initPrice`, `date`,`username`,`principal`)
				VALUES ('$currency', '$typeOfTransaction', $lots, $leverage, $askPrice, '$date', '$username', $principal);");
	$result = mysql_query( "SELECT `transactionID` FROM `transactions` 
						    WHERE `username`='$username' AND `currencyName`='$currency' AND `type`='$typeOfTransaction'
							ORDER BY `transactionID` DESC;") or die(errorReport(mysql_error()));
	$tmp = mysql_fetch_array($result);
}

$equity = equity($username);
$transactions = $transactions."+".$tmp[0];
mysql_query("UPDATE `userData` SET `accValUSD`=$account WHERE `username`='$username'");
mysql_query("UPDATE `userData` SET `equity`=$equity WHERE `username`='$username'");
mysql_query("UPDATE `userData` SET `transactions`='$transactions' WHERE `username`='$username'");

echo "<msg>Transaction complete!\nRemember to CLOSE your transaction from the Transaction History Page!</msg></transactionStatus>";
mysql_close( $con )

?>