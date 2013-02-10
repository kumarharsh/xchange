var xmlhttp; //AJAX XMLHTTP request

function GetXmlHttpObject() //Get the correct xmlhttp for the clients browser
{
	if (window.XMLHttpRequest)
		return new XMLHttpRequest();
	if (window.ActiveXObject)
		return new ActiveXObject("Microsoft.XMLHTTP");
	return null;
}

function callServer(username, password) //Verify username and password on server
{
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url = "login.php";
	var params = "user="+username+"&pass="+password;
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
		xmlResponse = xmlhttp.responseXML;
		var error = xmlResponse.getElementsByTagName("error")[0].childNodes[0].nodeValue;
		if(error!="#")
		{
			 document.getElementById("error").innerHTML = error;
			 return;
		}
		window.location.href = "game.php?data=trading"
	}
}

function login() //Act as entry point to the whole login process
{
	var username = document.getElementById("username").value;
	var password = hex_md5(document.getElementById("password").value);
	callServer(username,password);
}