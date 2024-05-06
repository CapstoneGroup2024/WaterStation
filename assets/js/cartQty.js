$(document).ready(function () {
    $('.increment-btn').click(function (e) {
        e.preventDefault();
        var qtyInput = $(this).siblings('.input-qty');
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty;

        if (qty < 100) {
            qty++;
        } else {
            qty = 1; // Reset to 1 if the quantity reaches 100
        }
        qtyInput.val(qty);
    });

    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var qtyInput = $(this).siblings('.input-qty');
        var qty = parseInt(qtyInput.val(), 10);
        qty = isNaN(qty) ? 0 : qty;

        if (qty > 1) {
            qty--;
        }
        qtyInput.val(qty);
    });

    $('.cartBtn').click(function (e) {
        e.preventDefault();

        var qty = $(this).closest('.input-group').find('.input-qty').val();
        var productId = $('.selectedProduct').val();
        var categoryId = $('.selectedCategory').val();

        // Send quantity, product ID, and category ID to server
        $.post('process_cart.php', {
            cartBtn: true,
            quantityInput: qty,
            selectedProduct: productId,
            selectedCategory: categoryId
        }, function (response) {
            // Handle server response if needed
            alert(response);
        });
    });

    // Trigger change event to ensure the display updates when the value is changed programmatically
    $('.input-qty').trigger('change');
});
