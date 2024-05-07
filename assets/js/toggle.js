function toggleRadio(label) { // TOGGLE RADIO BUTTON THE CHANGE COLOR
    var radios = document.querySelectorAll('input[type="radio"]');
    var labels = document.querySelectorAll('label');

    labels.forEach(function(l) {
        l.style.borderColor = 'transparent'; // SET BORDER COLOR TO TRANSPARENT
    });

    radios.forEach(function(radio) { // SET COLOR IF A RADIO BUTTON IS CLICKED
        if (radio.checked) { // CHECK IF RADIO BUTTON IS CHECKED
            label.style.borderColor = '#6FC7EA'; // SET BORDER COLOR FOR THE CLICKED LABEL
        }
    });
}
