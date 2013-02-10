<?php
// <error> .... </error>
// 	"Wrong Usage of Registration Process"     ----->  incomplete REQUEST parameters
//	"Invalid UserName"			  ----->  username contains illigal chars , legal chars a-z, A-Z, ., _	
//	"Error in Connection to DataBase".mysql_error()  ----->  could not conect to mysql database, indicated in /include/dbInfo.php
//	"User Already Exist, Please Choose Some Other User Name" 
//	"Query Failed ".mysql_error()
//
//follow goes on success
//    <status>Query Successful</status>;
//    <username>$username</username>;
//    <name>$name</name>;
//
//



require_once( "../include/dbInfo.php" );

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

header('Content-type: text/xml');

/*
foreach( $_GET as $key=> $value )
{
    echo "<br>".$key."---->".$value;
}
*/
echo "<responseData>";

//if the feilds are not set ==> invalid user of this page!!!
if( !isset( $_REQUEST['username'] )  ||  !isset( $_REQUEST['password'])  || !isset( $_REQUEST['email'] )  )
{
    sendError( "Wrong Usage of Registration Process" );
}

//database fields
$username=trim($_REQUEST['username']);
$password=trim($_REQUEST['password']);
$accValUSD=100000;
$name=trim($_REQUEST['name']);
$phone=trim($_REQUEST['phone']);
$college=trim($_REQUEST['college']);
$email=trim($_REQUEST['email']);
$transactions=trim("");





for( $i=0 ; $username[$i] != ""; $i++ )
{
    if( ($username[$i] >= 'a' && $username[$i] <='z')  || ($username[$i] >= 'A' && $username[$i] <='Z') ||  ($username[$i] == '.')  || ($username[$i] == '_') )
    {
	;
    }
    else
    {
	sendError( "Invalid UserName" );
    }
}



$con = mysql_connect( $DB_HOST, $DB_USERNAME, $DB_PASSWD ) or die( sendError("Error in Connection to DataBase ".mysql_error()) ) ;

mysql_select_db( $DB_DATABASENAME, $con );

//checking if the user already exist...if user already exist send an error
$result = mysql_query( "SELECT * FROM userData WHERE username='$username'" ) or die( sendError( "Query Failed ".mysql_error()) )  ;

if( $row = mysql_fetch_array( $result ) )
{
    sendError( "User Already Exist, Please Choose Some Other User Name" );
}




//the query
$sqlQuery = "INSERT INTO userData (`username`, `password`, `accValUSD`, `name`, `phone`, `college`, `transactions`, `equity`) VALUES ('$username', '$password', $accValUSD, '$name', '$phone', '$college', NULL, $accValUSD );";

mysql_query( $sqlQuery ) or die( sendError( "Query Failed ".mysql_error() ) );

echo "<error>#</error>";
echo "<status>Query Successful</status>";
echo "<username>$username</username>";
echo "<name>$name</name>";


echo "</responseData>";



?>






   

