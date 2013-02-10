<?php

/*
* This page checks the two parameters passed to it
* 1. username- username of the fellow who wants to log in
* 2. password- an md5crypted version of the users password
* If data is consistent with the database then it sets the login cookies
* and redirects to the game page
*/

require_once( "include/dbInfo.php" );
error_reporting(0); 

function errorReport($error)
{
	mysql_close( $con );
	header('Content-type: text/xml');
	echo "<response>";
	echo "<error>$error</error></response>";
	exit;
}


if(!isset($_REQUEST["user"]) && !isset($_REQUEST["pass"]))
{
	echo errorReport("Input data not set");
	exit;
}

$username=addslashes(trim($_REQUEST['user']));
$password=addslashes(trim($_REQUEST['pass']));

$con = mysql_connect($DB_HOST,$DB_USERNAME,$DB_PASSWD) or die(errorReport(mysql_error()));
mysql_select_db($DB_DATABASENAME,$con) or die(errorReport(mysql_error()));
$result = mysql_query( "SELECT password FROM userData WHERE username='$username'") or die(errorReport(mysql_error()));
if($row = mysql_fetch_array( $result ))
{
	if($password===md5($row[0]))
	{
		setcookie("login",$username."+".$password,time()+60*60,"/");
		setcookie("password",$password."+".md5(str_rot13($password)),time()+60*60,"/");
		errorReport("#");
	}
	else
		errorReport("Incorrect Password");
}
else
	errorReport("User does not exist");

?>