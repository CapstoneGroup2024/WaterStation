$(document).ready(function () {
    $('.increment-btn').click(function (e) { // EVENT HANDLER FOR INCREMENT BUTTON CLICK
        var qtyInput = $(this).siblings('.input-qty'); // GET THE QUANTITY INPUT ELEMENT ASSOCIATED WITH INCREMENT BUTTON
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty;  // IF qty IS NaN, SET IT TO 0 

        if (qty < 100) { // CHECK IF QTY IS LESS THAN 100
            qty++; 
        } else {
            qty = 1; // RESET QUANTITY TO 1 IF REACHED 100
        }
        qtyInput.val(qty); // UPDATE QUANTITY INPUT FIELD VALUE
    });

    $('.decrement-btn').click(function (e) { // EVENT HANDLER FOR DECREMENT BUTTON CLICK
        e.preventDefault();
        var qtyInput = $(this).siblings('.input-qty'); // GET THE QUANTITY INPUT ELEMENT ASSOCIATED WITH DECREMENT BUTTON
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty; // IF qty IS NaN, SET IT TO 0 

        if (qty > 1) { // CHECK IF QTY IS GREATER THAN 1
            qty--;
        }
        qtyInput.val(qty); // UPDATE QUANTITY INPUT FIELD VALUE
    });

    $('.cartBtn').click(function (e) {  // EVENT HANDLER FOR CART BUTTON CLICK
        e.preventDefault();
        var qty = $(this).closest('.input-group').find('.input-qty').val();         // GET QUANTITY VALUE FROM THE CLOSEST INPUT GROUP ASSOCIATED WITH THE CLICKED CART BUTTON
        var productId = $('.selectedProduct').val(); 
        var categoryId = $('.selectedCategory').val(); 

        $.post('process_cart.php', { // SEND QUANTITY, PRODUCT ID, AND CATEGORY ID TO SERVER USINNNG AJAX POST REQUEST
            cartBtn: true,
            quantityInput: qty,
            selectedProduct: productId,
            selectedCategory: categoryId
        }, function (response) { // HANDLE SERVER RESPONSE IF NEEDED
            alert(response); // DISPLAY SERVER RESPONSE
        });
    });
    $('.input-qty').trigger('change'); // TRIGGER CHANGE EVENT TO ENSURE DISPLAY UPDATES WHEN VALUE CHANGES
});
