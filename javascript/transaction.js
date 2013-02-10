var xmlhttp; //AJAX XMLHTTP request

function GetXmlHttpObject() //Get the correct xmlhttp for the clients browser
{
	if (window.XMLHttpRequest)
		return new XMLHttpRequest();
	if (window.ActiveXObject)
		return new ActiveXObject("Microsoft.XMLHTTP");
	return null;
}

function transact(lots, type, curr, levg) //Entry point of the transaction process
{
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url = "game/openTransaction.php";
	var params = "lots="+lots;
	params += "&type="+type;
	params += "&curr="+curr;
	params += "&levg="+levg;
	xmlhttp.onreadystatechange=result;
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
}

function closeTransaction(user,tid)
{
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url = "game/closeTransaction.php";
	var params = "username="+user;
	params += "&transactionID="+tid;
	xmlhttp.onreadystatechange=resClose;
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
}

function result() //Write result of server transaction
{
	if(xmlhttp.readyState==4)
  	{
		xmlResponse = xmlhttp.responseXML;
		var msg = xmlResponse.getElementsByTagName("msg")[0].childNodes[0].nodeValue;
		alert(msg);
	}
}
function resClose() //Write result of server transaction
{
	if(xmlhttp.readyState==4)
  	{
		xmlResponse = xmlhttp.responseXML;
		var msg = xmlResponse.getElementsByTagName("msg")[0].childNodes[0].nodeValue;
		alert(msg);
	}
}