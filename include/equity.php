<?php

/*
* This php file contains  two functions
* 1. equity() --- calculates the equity of any user
* 2. calculateClosePrice() --- add this value when you want to close a particular transaction
*/



//Function returs the equity of a user given by username
function equity($username)
{
	$lotSize = 10000;
	$equity = 0;
	$amt = 0;
	//Connect to database
	include("dbInfo.php");
	$con = mysql_connect($DB_HOST,$DB_USERNAME,$DB_PASSWD) or die(errorReport(mysql_error()));
	mysql_select_db($DB_DATABASENAME,$con) or die(errorReport(mysql_error()));
	//Process users info from database
	$result = mysql_query( "SELECT `accValUSD` FROM `userData` WHERE `username`='$username'") or die(mysql_error());
	$row = mysql_fetch_array($result);
	$equity = $row['accValUSD'];			// Initially, EQUITY is equal to your Bank Account Balance
	
	//Process each of the users transactions
	$result = mysql_query( "SELECT * FROM `transactions` WHERE `username`='$username'") or die(mysql_error());
	while($row=mysql_fetch_array($result))
	{
		$currency = $row['currencyName'];
		$type = $row['type'];
		$noOfLots = $row['noOfLots'];
		$leverage = $row['leverage'];
		$principal = $row['principal'];
		$date = $row['date'];
		if($row['active']==1)
				$amt += calculateClosePrice($currency, $type, $noOfLots, $leverage, $principal, $date);
	}
	$equity += $amt;
	return $equity;
}

//Claculate the price of closing the transaction just add this to the account balance to get the balance after close
function calculateClosePrice($currency, $type, $noOfLots, $leverage, $principal, $date)
{
	$lotSize = 10000;
	$brokerInterest = 0.01;
	$amt = 0;
	$timeInterval = 1;
	//Get prices
	include("pathInfo.php");
	$xml = simplexml_load_file("$PATH_WEB/webservices/getQuotes.php?data=".$currency);
	$bidPrice = $xml->quote[0]->bid;
	$askPrice = $xml->quote[0]->ask;
	//If transaction is of type long
	if($type==="long")
	{
		$amt = $noOfLots*$lotSize/$askPrice - $principal - $brokerInterest*$principal;
	}
	//If transaction is of type short
	else
	{
		$amt = -$noOfLots*$lotSize/$bidPrice - $principal - $brokerInterest*$principal;
	}
	$file=fopen("test.txt","a");
	fwrite($file,"amount = $amt dollars  \n");
	fclose($file);
	return $amt;
}

?>