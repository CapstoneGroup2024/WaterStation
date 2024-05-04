$(document).ready(function (){ 
    $('.increment-btn').click(function(e) {
        e.preventDefault(); 
        var qtyInput = $('.quantityInput');
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty;

        if(qty < 10){
            qty++;
            qtyInput.val(qty); 
        }
    });

    $('.decrement-btn').click(function(e) {
        e.preventDefault(); 
        var qtyInput = $('.quantityInput');
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty;

        if(qty > 0){
            qty--;
            qtyInput.val(qty); 
        }
    });

    $('.cartBtn').click(function (e){
        e.preventDefault(); 

        var qty = $('.quantityInput').val();
        var productId = $('.selectedProduct').val(); 
        var categoryId = $('.selectedCategory').val(); 

        // Send quantity, product ID, and category ID to server
        $.post('process_cart.php', { cartBtn: true, quantityInput: qty, selectedProduct: productId, selectedCategory: categoryId }, function(response) {
            // Handle server response if needed
            alert(response); 
        });
    });
});
