var xmlhttp; //AJAX XMLHTTP request

var username; //Stores usernames
var password; //Stores passwords
var name; //Stores clients name
var phone; //Stores clients contact number
var college; //Stores clients college details
var email; //Stores clients email
var captcha;//stores captcha
var security;//stores answer to security question

function GetXmlHttpObject() //Get the correct xmlhttp for the clients browser
{
	if (window.XMLHttpRequest)
		return new XMLHttpRequest();
	if (window.ActiveXObject)
		return new ActiveXObject("Microsoft.XMLHTTP");
	return null;
}

function callServer() //Verify registration data on server
{
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url = "registration/processRegistration.php";
	var params = "username="+username;
	params += "&password="+password;
	params += "&name="+name;
	params += "&phone="+phone;
	params += "&college="+college;
	params += "&email="+email;
	params += "&captcha="+captcha;
	params += "&security="+security;
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
		alert("Registration Sucessful");
		window.location.href = "index.php";
	}
}

function validate() //Validate if user is giving correct input
{
	document.getElementById("error").innerHTML = "";
	var truePass = true;
	var trueSec = true;
	if(security=="Undefined" || security==null)
		trueSec = false;
	if(password.length<6)
		truePass = false;
	/*var nameRegex = new RegExp(/^[A-Z][a-zA-Z]*$/);
	var trueName = nameRegex.test(name);
	var collRegex = new RegExp(/^[A-Z][a-zA-Z]*$/);
	var trueColl = collRegex.test(college);*/
	var truePhone = false;
	if(phone!=="")
	{
		if(!isNaN(phone))
		{
			truePhone = true;
		}
	}
	var emailRegex = new RegExp(/^([\w]+)(.[\w]+)*@([\w]+)(.[\w]{2,3}){1,2}$/);
	var trueEmail = emailRegex.test(email);
	if(!truePass)
		document.getElementById("error").innerHTML = "Password should be atleast 6 characters long<br>";
	/*if(!trueName)
		document.getElementById("error").innerHTML += "Improper Name<br>";*/
	if(!truePhone)
		document.getElementById("error").innerHTML += "Check your Phone Number<br>";
	if(!trueEmail)
		document.getElementById("error").innerHTML += "Give a valid Email Address<br>";
	return  truePhone && trueSec && trueEmail && truePass;
}

function getValues()
{
	username = document.getElementById("username").value;
	password = document.getElementById("password").value;
	name = document.getElementById("name").value;
	phone = document.getElementById("phone").value;
	college = document.getElementById("college").value;
	email = document.getElementById("email").value;
	captcha = document.getElementById("captcha").value;
	security = document.getElementById("question").value;
}

function registerMe() //Act as entry point to the whole login process
{
	getValues();
	if(!validate())
		return;
	callServer();
}

