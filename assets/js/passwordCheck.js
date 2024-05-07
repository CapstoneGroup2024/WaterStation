document.addEventListener('DOMContentLoaded', function() {
    var password = document.getElementById("password"); 
    var msg = document.getElementById("message");
    var str = document.getElementById("strength");
    var uppercaseRegex = /[A-Z]/; // UPPERCASE
    var digitRegex = /\d/; // DIGITS
    var symbolRegex = /[\W_]/; // SYMBOLS

    if (password) { // CHECK IF PASSWORD ELEMENT EXISTS
        password.addEventListener('input', function() { // ADD INPUT EVENT LISTENER TO THE PASSWORD FIELD
            var passwordValue = password.value;
            var isWeak = passwordValue.length < 4 || !uppercaseRegex.test(passwordValue) || !digitRegex.test(passwordValue) || !symbolRegex.test(passwordValue);
            
            if (msg) { // CHECK IF MSG ELEMENT EXIST
                // SHOW OR HIDE MESSAGE BASED ON PASSWORD INPUT
                if (passwordValue.length > 0) {
                    msg.style.display = "block";
                } else {
                    msg.style.display = "none";
                }
            }
            
            if (str) { // CHECK IF STR ELEMENT EXISTS
                // SET PASSWORD STRENGTH MESSAGE AND STYLE
                if (isWeak) {
                    str.innerHTML = "Password is weak";
                    password.style.borderColor = "#ff5925";
                    if (msg) msg.style.color = "#ff5925";
                } else if (passwordValue.length >= 4 && passwordValue.length < 8) {
                    str.innerHTML = "Password is medium";
                    password.style.borderColor = "yellow";
                    if (msg) msg.style.color = "yellow";
                } else if (passwordValue.length >= 8) {
                    str.innerHTML = "Password is strong";
                    password.style.borderColor = "#26d730";
                    if (msg) msg.style.color = "#26d730";
                }
            }
        });
    }
});
