
var xmlhttp; //AJAX XMLHTTP request

function GetXmlHttpObject() //Get the correct xmlhttp for the clients browser
{
	if (window.XMLHttpRequest)
		return new XMLHttpRequest();
	if (window.ActiveXObject)
		return new ActiveXObject("Microsoft.XMLHTTP");
	return null;
}

function getIm(cur,dur) //Verify username and password on server
{
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url = "webservices/getFigs.php";
	var params = "currency="+cur+"&duration="+dur;
	xmlhttp.onreadystatechange=writeContent;
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	xmlhttp.send(params);
}

function writeContent() //Write result of server verification
{
	if(xmlhttp.readyState==4)
  	{
		xmlResponse = xmlhttp.responseText;
		document.getElementById("image").innerHTML = xmlResponse;
	}
}

function getImage() //Act as entry point to the whole login process
{
	var cur = document.getElementById("currency").value;
	var dur = document.getElementById("duration").value;
	getIm(cur,dur);
}