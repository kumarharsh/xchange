<?php

echo "<script type=\"text/javascript\" src=\"javascript/transaction.js\"></script>";


error_reporting(0); 

//gives error xml and exits
function sendError( $errMesg )
{
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

//Get data for all listed currencies
$curFile = fopen("./include/currencyInfo.txt","r");
$curData = fread($curFile, filesize("./include/currencyInfo.txt"));
fclose($curFile);
$curData = explode(",",$curData);

//Get data for all currencies
$noOfCurr = count($curData);
$xml = simplexml_load_file("$PATH_WEB/webservices/getQuotes.php");
$ctr = 0;

foreach ($curData as $i)
{
	echo "<div class=\"currencyInfo\">";
	echo "<div class=\"currTitle\">".$i."</div>";
	echo "<div class=\"currLeft\">
			<div class=\"currValue\">".$xml->quote[$ctr]->bid."</div>
			<div class=\"currInfo\">Bid Price</div>
		  </div>";
	echo "<div class=\"currRight\">
			<div class=\"currValue\">".$xml->quote[$ctr]->ask."</div>
			<div class=\"currInfo\">Ask Price</div>
		  </div>";
	echo "<div class=\"currLeft\">
			<div class=\"currValue\">
					<select id=\"".$i."leverage\" style=\"margin-top:5px;\">
					<option value=\"0.25\">1:25</option>
					<option value=\"0.125\">1:50</option>
					<option value=\"0.01\">1:100</option>
         			<option value=\"0.005\">1:200</option></select>
			</div>
			<div class=\"currInfo\">Leverage</div>
		  </div>";
	echo "<div class=\"currRight\">
			<div class=\"currValue\">
					<select id=\"".$i."lots\" style=\"margin-top:5px;\">
		  			<option value=\"10\">10</option>
		  			<option value=\"50\">50</option>
		 			<option value=\"100\">100</option>
          			<option value=\"200\">200</option></select>
			</div>
			<div class=\"currInfo\">Lots</div>
		  </div>";
	echo "<div class=\"currButtons\">
		 		<div class=\"currLong\">
				<a href=\"#\" onclick=\"transact(document.getElementById('".$i."lots').value,
										'long','".$i."',document.getElementById('".$i."leverage').value);\"></a>
				
				</div>
				<div class=\"currShort\">
				<a href=\"#\" onclick=\"transact(document.getElementById('".$i."lots').value,
										'short','".$i."',document.getElementById('".$i."leverage').value);\"></a>
					
		  </div>
		  </div>";
	echo "</div>";
	$ctr++;
	//	<a href=\"#\" onclick=\"transact(".$i."lots.value,'long','".$i."',".$i."leverage.value);\"></a>
	// <a href=\"#\" onclick=\"transact(".$i."lots.value,'short','".$i."',".$i."leverage.value);\"></a>
}

?>