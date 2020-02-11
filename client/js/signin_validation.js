function validateNewUser(){
	var fname = document.forms["signupform"]["fname"].value;
	var lname = document.forms["signupform"]["lname"].value;
	var birth = document.forms["signupform"]["brith"].value;
	var email = document.forms["signupform"]["email"].value;
	var pass = document.forms["signupform"]["pass"].value;
	var rpass = document.forms["signupform"]["rpass"].value;
	
	//alphabet only1
	var nameformat = /^[a-zA-Z0-9]*$/;
	//email format
	var emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	//1 lowercase, 1 uppercase, 1 number, at least 8 characters
	var passformat = /(?=(.*[0-9]))((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.{8,}$/;
	
	if(fname == "" || lname == "" || birth == "" || email == "" || pass == "" || rpass == ""){
		alert("Sign up form must be filled in");
		return false;
	}
	else if(!fname.match(nameformat) || !lname.match(nameformat)){
        alert("Incorrect characters used in name");
        return false;
	}
	else if (!email.match(emailformat)){
        alert("Incorrect characters used in email");
		return false;
	}
	else if(!pass.match(passformat) || !rpass.match(passformat)){
        alert("Incorrect characters used in password");
		return false;
	}
	else if(pass != rpass){
        alert("Passwords do not match");
		return false;
	}
	return true;
}

function validateUser(){
	var email = document.forms["loginform"]["email"].value;
	var pass = document.forms["loginform"]["pass"].value;
	
	//email format
	var emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	//1 lowercase, 1 uppercase, 1 number, at least 8 characters
	var passformat = /(?=(.*[0-9]))((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.{8,}$/;
	
	if(email == "" || pass == ""){
		alert("Email and/or password must be filled in");
		return false;
	}
	else if (!email.match(emailformat)){
        alert("Incorrect characters used in email");
		return false;
	}
	else if(!pass.match(passformat)){
        alert("Incorrect characters used in password");
		return false;
	}
	return true;
}

function forgotPassword(){
	var email = document.forms["forgotpassform"]["email"].value;
	
	//email format
	var emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	
	if(email == ""){
		alert("Email must be filled in");
		return false;
	}
	else if (!email.match(emailformat)){
        alert("Incorrect characters used in email");
		return false;
	}
	return true;
}

function validateUserUpdate(){
	var fname = document.forms["edituserform"]["fname"].value;
	var lname = document.forms["edituserform"]["lname"].value;
	var birth = document.forms["edituserform"]["brith"].value;
	var email = document.forms["edituserform"]["email"].value;
	var oldpass = document.forms["edituserform"]["oldpass"].value;
	var newpass = document.forms["edituserform"]["newpass"].value;
	var rpass = document.forms["edituserform"]["rpass"].value;
	
	//alphabet only1
	var nameformat = /^[a-zA-Z0-9]*$/;
	//email format
	var emailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	//1 lowercase, 1 uppercase, 1 number, at least 8 characters
	var passformat = /(?=(.*[0-9]))((?=.*[A-Za-z0-9])(?=.*[A-Z])(?=.*[a-z]))^.{8,}$/;
	
	if(fname == "" || lname == "" || birth == "" || email == "" || pass == "" || rpass == ""){
		alert("Sign up form must be filled in");
		return false;
	}
	else if(!fname.match(nameformat) || !lname.match(nameformat)){
        alert("Incorrect characters used in name");
        return false;
	}
	else if (!email.match(emailformat)){
        alert("Incorrect characters used in email");
		return false;
	}
	else if(!oldpass.match(passformat) || !newpass.match(passformat) || !rpass.match(passformat)){
        alert("Incorrect characters used in password");
		return false;
	}
	else if(newpass != rpass){
        alert("Passwords do not match");
		return false;
	}
	return true;
}
