<?php

/*
* Based on client requests send a performance graph of the currency from...
* 1d,5d,3m,1y
*/

$duration = $_REQUEST["duration"];
$currency = $_REQUEST["currency"];

if($duration==="1d")
{
	echo "<img src='http://ichart.finance.yahoo.com/b?s=".$currency."USD=X' />";
}
else if($duration==="5d")
{
	echo "<img src='http://ichart.finance.yahoo.com/w?s=".$currency."USD=X' />";
}
else if($duration==="3m")
{
	echo "<img src='http://ichart.finance.yahoo.com/3m?".$currency."USD=X' />";
}
else if($duration==="1y")
{
	echo "<img src='http://ichart.finance.yahoo.com/1y?".$currency."USD=X' />";
}

?>