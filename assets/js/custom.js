$(document).ready(function (){ // ENSURES THAT THE DOM IS FULLY LOADED BEFORE EXECUTING JQUERY CODE
    $('.increment-btn').click(function(e) {
        e.preventDefault(); // PREVENTS THE BROWSER OF BEHAVIORAL CLICK EVENT 
        var qty = $('.quantityInput').val();
        var value = parseInt(qty, 10); 
        value = isNaN(value) ? 0 : value;

        if(value < 10){
            value++;
            $('.quantityInput').val(value); // UPDATE THE VALUE OF THE QUANTITY INPUT FIELD
        }
    });

    $('.decrement-btn').click(function(e) {
        e.preventDefault(); // PREVENTS THE BROWSER OF BEHAVIORAL CLICK EVENT 
        var qty = $('.quantityInput').val();
        var value = parseInt(qty, 10);
        value = isNaN(value) ? 0 : value;

        if(value > 0){
            value--;
            $('.quantityInput').val(value); // UPDATE THE VALUE OF THE QUANTITY INPUT FIELD
        }
    });
});
