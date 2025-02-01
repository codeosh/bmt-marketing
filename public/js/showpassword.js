document.getElementById("showPassword").addEventListener("change", function () {
    let passwordField = document.getElementById("password");
    passwordField.type = this.checked ? "text" : "password"; //  the "text" : "password" is nag-gekan sila sa type= sa input which is checkbox
});

//javascript to handle loading effect
document.addEventListener('DOMContentLoaded', function () { //after ma fully loaded na ang tanan mo execute ang inside ani. 
    const loginForm = document.querySelector('form');
    const loginButton = document.getElementById('loginButton');
    const buttonText = document.getElementById('buttonText');
    const buttonSpinner = document.getElementById('buttonSpinner');

    loginForm.addEventListener('submit', function () {
        
        loginButton.disabled = true;
        buttonText.textContent = "Logging in...";
        buttonSpinner.classList.remove('d-none');
    });
});
