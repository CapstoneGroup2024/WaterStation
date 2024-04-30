function toggleRadio(label) {
    var radios = document.querySelectorAll('input[type="radio"]');
    var labels = document.querySelectorAll('label');

    // Remove border color from all labels
    labels.forEach(function(l) {
        l.style.borderColor = 'transparent';
    });

    // Set border color for the clicked label if a radio button is checked
    radios.forEach(function(radio) {
        if (radio.checked) {
            label.style.borderColor = '#6FC7EA';
        }
    });
}