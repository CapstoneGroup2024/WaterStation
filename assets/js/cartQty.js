$(document).ready(function () {
    function updateTotalPrice() {
        var subtotal = 0;
        var finalAdd = 0;
    
        $('.cart_data').each(function() {
            var qty = parseInt($(this).find('.input-qty').val(), 10);
            var price = parseFloat($(this).find('.iprice').text().replace('₱', ''));
            var additional_price = parseFloat($(this).find('.additional_price_hidden').text().replace('₱', ''));
            var total = qty * price;
            total = Math.round(total);
            subtotal += total;
            finalAdd += additional_price;
            $(this).find('.itotal').text('₱' + total);
        });
    
            var grandTotal = subtotal + finalAdd;
    
            $('.subtotal-price').text('₱' + subtotal.toFixed(2));
            $('.additional-fee').text('₱' + finalAdd.toFixed(2));
            $('.grand-total').text('₱' + grandTotal.toFixed(2));
    
        }
        $('.increment-btn').click(function (e) {
            var qtyInput = $(this).siblings('.input-qty');
            var qty = parseInt(qtyInput.val(), 10);
            qty = isNaN(qty) ? 0 : qty;
            var cartId = $(this).closest('.cart_data').find('input[name="cart_id"]').val();
            var productId = $(this).closest('.cart_data').find('input[name="product_id"]').val(); // Add this line to get product ID
        
            if (qty < 100) {
                qty++;
            } else {
                qty = 1;
            }
            qtyInput.val(qty);
            updateQuantity(cartId, productId, qty); // Pass all three parameters
        });
        
        $('.decrement-btn').click(function (e) {
            e.preventDefault();
            var qtyInput = $(this).siblings('.input-qty');
            var qty = parseInt(qtyInput.val(), 10);
            qty = isNaN(qty) ? 0 : qty;
            var cartId = $(this).closest('.cart_data').find('input[name="cart_id"]').val();
            var productId = $(this).closest('.cart_data').find('input[name="product_id"]').val(); // Add this line to get product ID
        
            if (qty > 1) {
                qty--;
            }
            qtyInput.val(qty);
            updateQuantity(cartId, productId, qty); // Pass all three parameters
        });
        

    $('.input-qty').on('change', function() {
        var qty = parseInt($(this).val(), 10);
        var cartId = $(this).closest('.cart_data').find('input[name="cart_id"]').val();
        updateQuantity(cartId, qty);
    });

    function updateQuantity(cartId, productId, qty) {
        $.ajax({
            url: 'update-to-cart.php',
            method: 'POST',
            data: { cart_id: cartId, product_id: productId, quantity: qty },
            success: function(response) {
                updateTotalPrice();
            }
        });
    }
    
    $('.changeQuantity').click(function (e) {
        e.preventDefault();
    
        var quantity = $(this).closest(".input-group").find('.input-qty').val();
        var cartId = $(this).closest(".input-group").find('.cart_id').val();
        var productId = $(this).closest(".input-group").find('.product_id').val(); // Get the product ID
    
        var data = {
            'quantity': quantity,
            'cart_id': cartId,
            'product_id': productId // Include product ID in the data object
        };
    
        $.ajax({
            url: 'update-to-cart.php',
            type: 'POST',
            data: data,
            success: function (response) {
                // Update total prices after successful update
                updateTotalPrice();
                // Reload the page or update other elements as needed
                window.location.reload();
            },
            error: function (xhr, status, error) {
                // Display error message if AJAX request fails
                alert('Failed to update quantity: ' + error);
            }
        });
    });
    
    

    updateTotalPrice(); // Initial call to set values
});