// GET DATA FROM HTML FILE
var password = document.getElementById("pw"); 
var msg = document.getElementById("message");
var str = document.getElementById("strenght");
var uppercaseRegex = /[A-Z]/; // UPPERCASE
var digitRegex = /\d/; // DIGITS
var symbolRegex = /[\W_]/; // SYMBOLS

password.addEventListener('input', () => {
    var passwordValue = password.value;
    var isWeak = passwordValue.length < 4 || !uppercaseRegex.test(passwordValue) || !digitRegex.test(passwordValue) || !symbolRegex.test(passwordValue);
    
    // CHECK IF THERE IS INPUT
    if(passwordValue.length > 0){
        msg.style.display = "block";
    } else {
        msg.style.display = "none"; // IF EMPTY DISPLAY NONE
    }
    
    if (isWeak) { // IF WEAK OR MATCHES THE CONDITIONS IN VARIABLE isWeak
        str.innerHTML = "Password is weak";
        password.style.borderColor = "#ff5925";
        msg.style.color = "#ff5925";
    } else if(passwordValue.length >= 4 && passwordValue.length < 8) {
        str.innerHTML = "Password is medium";
        password.style.borderColor = "yellow";
        msg.style.color = "yellow";
    } else if (passwordValue.length >= 8){
        str.innerHTML = "Password is strong";
        password.style.borderColor = "#26d730";
        msg.style.color = "#26d730";
    }
});
