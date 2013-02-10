<?php
//this file does the sorting of the table by the field 
//accValUSD, 
//Manohar Kuse

//Input Paramters
//	http://server/forex/game/toplist.php?count=20
//this should produce a list of 20 topers. If you dont
//send the paramet, it would give out top 10


//Output format:::
//<responseData>
//<error>...</error>
//<count>...</count>
//<ranking>
//	<user>
//		<username>...</username>
//		<accValUSD>...</accValUSD>
//		<name>...</name>
//		<college>...</college>
//	</user>
//	.
//	.
//	.
//</ranking>
//</responseData>
//



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
// replacing the XML tags, and converting into DIVs
// trying to minimize the use of tables
// fixed a bug which prevented the display of college name...
// Kumar Harsh

header('Content-type: text/xml');
echo "<div id=\"holder\" style=\"width:640px; margin-top:5%\">";

	$con = mysql_connect( $DB_HOST, $DB_USERNAME, $DB_PASSWD ) or die( sendError("Error in Connection to DataBase ".mysql_error()) ) ;


mysql_select_db( $DB_DATABASENAME, $con ) or die( sendError("Error selecing Database".mysql_error()) );

//sorting the database in decending order
$result = mysql_query( "SELECT username, equity, name, college FROM userData ORDER BY equity DESC;" ) or die( sendError("Query Failed ".mysql_error()) );   

//this is the parameter to this php
if( !isset( $_REQUEST['count'] ) )
{
    $count=10; //this is the default count
}
else
{
    $count = $_REQUEST['count'];
    if( $count < 10 )
	$count=10;
}
$max=$count;
echo "<div id=\"topBar\">Top-".$count."</div>";
echo "<div id=\"error\">$errMesg</div>";
echo "<div class=\"rankCol\" style=\"font-weight:bold; width:50px; font-size:17px;\">Rank</div>
	  <div class=\"rankCol\" style=\"font-weight:bold; font-size:17px;\">Username</div>
	  <div class=\"rankCol\" style=\"font-weight:bold; font-size:17px;\">Equity</div>
  	  <div class=\"rankCol\" style=\"width:120px; font-weight:bold; font-size:17px;\">Real Name</div>
	  <div class=\"rankCol\" style=\"width:220px; font-weight:bold; font-size:17px;\">College</div>";
while( ($row = mysql_fetch_array( $result )) && $count>0 )
{
	echo "<div class=\"pady\"></div>
  	  	  <div class=\"rankCol\" style=\"width:50px\">".($max-$count+1)."</div>
  	  	  <div class=\"rankCol\">".$row['username']."</div>";
	printf("<div class=\"rankCol\">%0.4f</div>",$row['equity']);
	echo "<div class=\"rankCol\" style=\"width:120px\">".$row['name']."</div>
		  <div class=\"rankCol\" style=\"width:220px\">".$row['college']."</div>";

	$count--;
}
echo "<div class=\"pady\"></div>";
echo "</div>";
mysql_close( $con);

?>
