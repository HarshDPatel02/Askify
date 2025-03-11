
  function validateName(name) {
    let nameRegEx = /^[a-zA-Z]+$/;
    return nameRegEx.test(name);
}

function validatePassword(pwd) {
    if (pwd.length > 6 && !pwd.includes(" ")) {
        return true;
    } else {
        return false;
    }
}

function validateDOB(dob) {
    let dobRegEx = /^\d{4}-\d{2}-\d{2}$/;
    return dobRegEx.test(dob);
}

function validateEmail(email) {
    let emailRegx = /^[a-z0-9]+@[a-z0-9]+\.[a-z]{2,}$/;
    return emailRegx.test(email);
}

function validateUsername(uname) {
    let unameRegEx = /^[a-zA-Z0-9_]{4,20}$/;
    return unameRegEx.test(uname);
}

function validateAvatar(avatar) {
    
	let avatarRegEx = /^[^\n]+.[a-zA-Z]{3,4}$/;

	if (avatarRegEx.test(avatar))
		return true;
	else
		return false;
}

function validateSignUpForm(event) {
    
    let fname = document.getElementById("fname");
    let lname = document.getElementById("lname");
    let password = document.getElementById("password");
    let confirmPassword = document.getElementById("confirmPassword");
    let dob = document.getElementById("dob");
    let email = document.getElementById("email");
    let username = document.getElementById("username");
    let avatar = document.getElementById("profilephoto");

    let formIsValid = true;

    if (!validateName(fname.value)) {
        document.getElementById("fname").classList.add("error");
        document.getElementById("error-text-fname").classList.remove("hidden");
        fname.style.borderColor = "red";
        fname.style.borderWidth = "5px";
        formIsValid = false;
        } 
        else {
        document.getElementById("fname").classList.remove("error");
        document.getElementById("error-text-fname").classList.add("hidden");	
        }

        if (!validateName(lname.value)) {
            document.getElementById("lname").classList.add("error");
            document.getElementById("error-text-lname").classList.remove("hidden");
            lname.style.borderColor = "red";
            lname.style.borderWidth = "5px";
            formIsValid = false;
            } 
            else {
            document.getElementById("lname").classList.remove("error");
            document.getElementById("error-text-lname").classList.add("hidden");	
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

                if (validatePassword(password.value !== confirmPassword.value)) {
                    document.getElementById("confirmPassword").classList.add("error");
                    document.getElementById("error-text-confirm-password").classList.remove("hidden");
                    confirmPassword.style.borderColor = "red";
                    confirmPassword.style.borderWidth = "5px";
                    formIsValid = false;
                    } 
                    else {
                    document.getElementById("confirmPassword").classList.remove("error");
                    document.getElementById("error-text-confirm-password").classList.add("hidden");	
                    }

                    if (!validateDOB(dob.value)) {
                        document.getElementById("dob").classList.add("error");
                        document.getElementById("error-text-dob").classList.remove("hidden");
                        dob.style.borderColor = "red";
                        dob.style.borderWidth = "5px";
                        formIsValid = false;
                        } 
                        else {
                        document.getElementById("dob").classList.remove("error");
                        document.getElementById("error-text-dob").classList.add("hidden");	
                        }
               
                    if (!validateEmail(email.value)) {
                        document.getElementById("email").classList.add("error");
                        document.getElementById("error-text-email").classList.remove("hidden");
                        email.style.borderColor = "red";
                        email.style.borderWidth = "5px";
                        formIsValid = false;
                        } 
                        else {
                        document.getElementById("email").classList.remove("error");
                        document.getElementById("error-text-email").classList.add("hidden");	
                        }

                        if (!validateUsername(username.value)) {
                            document.getElementById("username").classList.add("error");
                            document.getElementById("error-text-username").classList.remove("hidden");
                            username.style.borderColor = "red";
                            username.style.borderWidth = "5px";
                            formIsValid = false;
                            } 
                            else {
                            document.getElementById("username").classList.remove("error");
                            document.getElementById("error-text-username").classList.add("hidden");	
                            }

                            if (!validateAvatar(avatar.value)) {
                                document.getElementById("profilephoto").classList.add("error");
                                document.getElementById("error-text-photo").classList.remove("hidden");
                                avatar.style.borderColor = "red";
                                avatar.style.borderWidth = "5px";
                                formIsValid = false;
                                } 
                                else {
                                document.getElementById("avatar").classList.remove("error");
                                document.getElementById("error-text-photo").classList.add("hidden");	
                                }

                                if (!formIsValid) {
                                    event.preventDefault();
                                } else {
                                    console.log("Validation successful, sending data to the server");
                                }

                    }

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('sign-button').addEventListener('click', validateSignUpForm);
});


  