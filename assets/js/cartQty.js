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
    
            // Update database with new subtotal and grand total
            $.ajax({
                url: 'update_total_price.php',
                method: 'POST',
                data: { subtotal: subtotal, grandTotal: grandTotal },
                success: function(response) {
                    // Database updated successfully
                }
            });
        }

    function updateQuantity(cartId, qty) {
        $.ajax({
            url: 'update_quantity.php',
            method: 'POST',
            data: { cart_id: cartId, quantity: qty },
            success: function(response) {
                updateTotalPrice();
            }
        });
    }

    $('.increment-btn').click(function (e) {
        var qtyInput = $(this).siblings('.input-qty');
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty;
        var cartId = $(this).closest('.cart_data').find('input[name="cart_id"]').val();

        if (qty < 100) {
            qty++;
        } else {
            qty = 1;
        }
        qtyInput.val(qty);
        updateQuantity(cartId, qty);
    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var qtyInput = $(this).siblings('.input-qty');
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty;
        var cartId = $(this).closest('.cart_data').find('input[name="cart_id"]').val();

        if (qty > 1) {
            qty--;
        }
        qtyInput.val(qty);
        updateQuantity(cartId, qty);
    });

    $('.input-qty').on('change', function() {
        var qty = parseInt($(this).val(), 10);
        var cartId = $(this).closest('.cart_data').find('input[name="cart_id"]').val();
        updateQuantity(cartId, qty);
    });

    $('.changeQuantity').click(function (e) {
        e.preventDefault();

        var quantity = $(this).closest(".input-group").find('.input-qty').val();
        var product_id = $(this).closest(".input-group").find('.product_id').val();

        var data = {
            'quantity': quantity,
            'product_id': product_id,
        };

        $.ajax({
            url: 'update-to-cart.php',
            type: 'POST',
            data: data,
            success: function () {
                // Update total prices after successful update
                updateTotalPrice();
                // Reload the page or update other elements as needed
                window.location.reload();
            }
        });
    });

    updateTotalPrice(); // Initial call to set values
});