document.addEventListener('DOMContentLoaded', function() {
    var password = document.getElementById("password"); 
    var msg = document.getElementById("message");
    var str = document.getElementById("strength");
    var uppercaseRegex = /[A-Z]/; // UPPERCASE
    var digitRegex = /\d/; // DIGITS
    var symbolRegex = /[\W_]/; // SYMBOLS

    // Check if the password element exists
    if (password) {
        // Add input event listener to the password field
        password.addEventListener('input', function() {
            var passwordValue = password.value;
            var isWeak = passwordValue.length < 4 || !uppercaseRegex.test(passwordValue) || !digitRegex.test(passwordValue) || !symbolRegex.test(passwordValue);
            
            // Check if the message element exists
            if (msg) {
                // Show or hide message based on password input
                if (passwordValue.length > 0) {
                    msg.style.display = "block";
                } else {
                    msg.style.display = "none";
                }
            }
            
            // Check if the strength element exists
            if (str) {
                // Set password strength message and styling
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
