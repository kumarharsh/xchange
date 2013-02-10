<?php

/*
* This takes two parametric inputs by either GET or POST
* 1. email --- The emal address of the fellow who is complaining
* 2. message --- The text of the message the fellow sends
*
* For proper usage the server running this file must have the smtp settings done properly
* because phps mail() function uses these smtp stings to send the email
*/


if(!isset($_REQUEST["email"]) && !isset($_REQUEST["message"]))
	exit;

mail("vivacity2010+fx@gmail.com", "Feedback from".$subject, $_REQUEST["email"]."~+~".$_REQUEST["message"])

?>