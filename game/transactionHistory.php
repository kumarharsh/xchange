<?php
//this file displays the Transaction History of the user currently logged in...
//accValUSD, 
//Manohar Kuse


echo "<script type=\"text/javascript\" src=\"javascript/transaction.js\"></script>";
error_reporting(0); 

//gives error xml and exits
function sendError( $errMesg )
{
    echo "<responseData>";
	echo "<error>$errMesg</error>";
    echo "<status></status>";
    echo "<username></username>";
    echo "<name></name>";
    echo "</responseData>";
    exit;
}

function errorReport($errorText)
{
	echo "<msg>".$errorText."</msg></transactionStatus>";
	exit;
}
// replacing the XML tags, and converting into DIVs
// trying to minimize the use of tables
// fixed a bug which prevented the display of college name...
// Kumar Harsh

if(!isset($_COOKIE["login"]) || !isset($_COOKIE["password"]))
{
	errorReport("Cookies not set");
	exit;
}
if(isset($_COOKIE["password"]))
{
	$data = explode("+",$_COOKIE["login"]);
	$username = $data[0];
}

header('Content-type: text/xml');
echo "<div id=\"holder\" style=\"width:800px; margin-top:5%;\">";

$con = mysql_connect( $DB_HOST, $DB_USERNAME, $DB_PASSWD ) or die( sendError("Error in Connection to DataBase ".mysql_error()) ) ;


mysql_select_db( $DB_DATABASENAME, $con ) or die( sendError("Error selecing Database".mysql_error()) );

//Selecting the transaction records by Username...
$result = mysql_query( "SELECT * FROM `transactions` WHERE `username`='$username' ORDER BY active DESC;") or die( sendError("Query Failed ".mysql_error()) );


echo "<div id=\"topBar\">Transaction History</div>";
echo "<div style=\"overflow:auto; height:500px;\">";
echo "<div id=\"error\">$errMesg</div>";
echo "<div class=\"TransCol\" style=\"width:100px; font-weight:bold; font-size:14px;\">Trans-ID</div>
	  <div class=\"TransCol\" style=\"font-weight:bold; font-size:14px;\">Currency</div>
	  <div class=\"TransCol\" style=\"font-weight:bold; font-size:14px;\">Type</div>
  	  <div class=\"TransCol\" style=\"font-weight:bold; font-size:14px;\">Lots</div>
	  <div class=\"TransCol\" style=\"font-weight:bold; font-size:14px;\">Leverage</div>
	  <div class=\"TransCol\" style=\"font-weight:bold; font-size:14px;\">Initial Price</div>
	  <div class=\"TransCol\" style=\"font-weight:bold; font-size:14px;\">Current Price</div>
	  <div class=\"TransCol\" style=\"width:100px; font-weight:bold; font-size:14px;\">Trans-Date</div>
	  <div class=\"TransCol\" style=\"width:150px;font-weight:bold; font-size:14px;\">Status</div>";

while($row = mysql_fetch_array($result))
{
	$xml = simplexml_load_file("$PATH_WEB/webservices/getQuotes.php?data=".$row['currencyName']);
	$bidPrice = $xml->quote[0]->bid;
	$askPrice = $xml->quote[0]->ask;

	echo "<div class=\"pady\"></div>
  	  	  <div class=\"TransCol\" style=\"width:100px;\">".$row['transactionID']."</div>
  	  	  <div class=\"TransCol\">".$row['currencyName']."</div>
		  <div class=\"TransCol\">".$row['type']."</div>
		  <div class=\"TransCol\">".$row['noOfLots']."</div>
		  <div class=\"TransCol\">".$row['leverage']."</div>
		  <div class=\"TransCol\">".$row['initPrice']."</div>";		  
	echo "<div class=\"TransCol\">";
	if($row['type']==="long")
	{
		if($row['initPrice']<$askPrice)
			echo "<font color=\"#00FF00\">".$askPrice."</font>";
		else
			echo "<font color=\"#FF0000\">".$askPrice."</font>";
	}
	else
	{
		if($row['initPrice']>$bidPrice)
			echo "<font color=\"#00FF00\">".$bidPrice."</font>";
		else
			echo "<font color=\"#FF0000\">".$bidPrice."</font>";
	}		  
	echo "</div>";		  
	echo "<div class=\"TransCol\" style=\"width:100px;\">".$row['date']."</div>";
	echo "<div class=\"TransCol\" style=\"width:150px;\">";
	if($row['active']==1)
	{
		echo "<div class=\"btnClose\">";
		echo "<a href=\"#\" onclick=\"closeTransaction('".$username."','".$row['transactionID']."');\"></a>";
		echo "</div>";
	}
	else
		  echo " CLOSED @ ".$row['closePrice']." ";
	echo "</div>";

}
echo "</div>
	  <div class=\"pady\"></div>";
echo "</div>";
mysql_close($con);

?>