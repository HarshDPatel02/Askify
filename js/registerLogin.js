

function validateEmail(email){
    let emailRegx = /^[a-z0-9]+@[a-z0-9]+\.[a-z]{2,}$/;
    return emailRegx.test(email);
}

function validatePassword(password){
    if (password.length > 6 && !password.includes(" ")) {
        return true; 
      } else {
        return false; 
      }
}

function validateLoginForm(event){
    let email = document.getElementById("email");
	let password = document.getElementById("password");
	let formIsValid = true;

	if (!validateEmail(email.value)) {
	document.getElementById("email").classList.add("error");
	document.getElementById("error-text-username").classList.remove("hidden");
    email.style.borderColor = "red";
    email.style.borderWidth = "5px";
	formIsValid = false;
	} 
	else {
	document.getElementById("email").classList.remove("error");
	document.getElementById("error-text-username").classList.add("hidden");	
	}
	if (!validatePassword(password.value)) {
	document.getElementById("password").classList.add("error");
	document.getElementById("error-text-password").classList.remove("hidden");
    password.style.borderColor = "red";
    password.style.borderWidth = "5px";	
	formIsValid = false;
	} 
	else {
	document.getElementById("password").classList.remove("error");
	document.getElementById("error-text-password").classList.add("hidden");
	}

	if (!formIsValid) {
		event.preventDefault();
	} else {
		console.log("Validation successful, sending data to the server");
	}
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("login-button").addEventListener("click", validateLoginForm);
  });




 