$(document).ready(function () {
    $('.increment-btn').click(function (e) { // EVENT HANDLER FOR INCREMENT BUTTON CLICK
        e.preventDefault(); // STOP THE DEFAULT BEHAVIOR ASSOCIATED WITH A SPECIFIC EVENT
        var qtyInput = $('.quantityInput');
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty; // IF qty IS NaN, SET IT TO 0 

        if (qty < 100) { // CHECK IF QTY IS LESS THAN 100
            qty++;
            qtyInput.val(qty); // UPDATE QUANTITY INPUT FIELD VALUE
        }
    });

    $('.decrement-btn').click(function (e) { // EVENT HANDLER FOR DECREMENT BUTTON CLICK
        e.preventDefault(); // STOP THE DEFAULT BEHAVIOR ASSOCIATED WITH A SPECIFIC EVENT
        var qtyInput = $('.quantityInput');
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty; // IF qty IS NaN, SET IT TO 0 

        if (qty > 0) { // CHECK IF QTY IS GREATER THAN 0
            qty--; 
            qtyInput.val(qty);  // UPDATE QUANTITY INPUT FIELD VALUE
        }
    });

    $('.cartBtn').click(function (e) { // EVENT HANDLER FOR BUTTON CLICK
        e.preventDefault(); // STOP THE DEFAULT BEHAVIOR ASSOCIATED WITH A SPECIFIC EVENT

        var qty = $('.quantityInput').val(); 
        var productId = $('.selectedProduct').val(); 
        var categoryId = $('.selectedCategory').val(); 
 
        $.post('process_cart.php', {  // SEND QUANTITY, PRODUCT ID, AND CATEGORY ID TO SERVER USINNNG AJAX POST REQUEST
            cartBtn: true,
            quantityInput: qty,
            selectedProduct: productId,
            selectedCategory: categoryId
        }, function (response) { // HANDLE SERVER RESPONSE IF NEEDED
            alert(response); // DISPLAY SERVER RESPONSE
        });
    });
});
