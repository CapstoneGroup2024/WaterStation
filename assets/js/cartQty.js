$(document).ready(function () {
    // Function to update total price
    function updateTotalPrice() {
        $('.cart_data').each(function() {
            var qty = parseInt($(this).find('.input-qty').val(), 10); // Parse quantity as integer
            var price = parseFloat($(this).find('.iprice').text());
            var total = qty * price;
            total = Math.round(total); // Round the total to the nearest integer
            $(this).find('.itotal').text(total); // Display total without decimal places
        });
    }

    // Increment button click event handler
    $('.increment-btn').click(function (e) {
        var qtyInput = $(this).siblings('.input-qty');
        var qty = parseInt(qtyInput.val(), 10); // Parse quantity as integer
        qty = isNaN(qty) ? 0 : qty;

        if (qty < 100) {
            qty++;
        } else {
            qty = 1;
        }
        qtyInput.val(qty);
        updateTotalPrice(); // Update total price
    });

    // Decrement button click event handler
    $('.decrement-btn').click(function (e) {
        e.preventDefault();
        var qtyInput = $(this).siblings('.input-qty');
        var qty = parseInt(qtyInput.val(), 10); // Parse quantity as integer
        qty = isNaN(qty) ? 0 : qty;

        if (qty > 1) {
            qty--;
        }
        qtyInput.val(qty);
        updateTotalPrice(); // Update total price
    });

    // Cart button click event handler
    $('.cartBtn').click(function (e) {
        e.preventDefault();
        var qty = parseInt($(this).closest('.input-group').find('.input-qty').val(), 10); // Parse quantity as integer
        var productId = parseInt($('.selectedProduct').val(), 10); // Parse product ID as integer
        var categoryId = parseInt($('.selectedCategory').val(), 10); // Parse category ID as integer

        $.post('process_cart.php', {
            cartBtn: true,
            quantityInput: qty,
            selectedProduct: productId,
            selectedCategory: categoryId
        }, function (response) {
            alert(response);
        });
    });

    // Call updateTotalPrice initially to set the initial total prices
    updateTotalPrice();

    // Trigger change event to ensure display updates when value changes
    $('.input-qty').trigger('change');
});

// Function to calculate subtotal, delivery fee, and grand total
// Function to calculate subtotal, delivery fee, and grand total
// Function to calculate subtotal, delivery fee, and grand total
function calculateTotal() {
    var subtotal = 0;

    // Iterate through each cart item to calculate subtotal
    $('.cart_data').each(function() {
        var qty = parseInt($(this).find('.input-qty').val(), 10); // Parse quantity as integer
        var price = parseFloat($(this).find('.iprice').text().replace('₱', '')); // Parse price as float
        subtotal += qty * price; // Accumulate subtotal
    });

    // Calculate delivery fee (assuming it's a constant value)
    var deliveryFee = 10; // Change this value if the delivery fee varies

    // Calculate grand total
    var grandTotal = subtotal + deliveryFee;

    // Set values to hidden input fields
    $('[name="subtotal"]').val(subtotal.toFixed(2));
    $('[name="delivery"]').val(deliveryFee.toFixed(2));
    $('[name="grand"]').val(grandTotal.toFixed(2));
}

    // Call calculateTotal function when the document is ready
    $(document).ready(function() {
        calculateTotal(); // Calculate total initially
    });

    // Call calculateTotal function before submitting the form
    $('form').submit(function() {
        calculateTotal();
    });


    // Function to update total price
    function updateTotalPrice() {
        var subtotal = 0;

        $('.cart_data').each(function() {
            var qty = parseInt($(this).find('.input-qty').val(), 10); // Parse quantity as integer
            var price = parseFloat($(this).find('.iprice').text().replace('₱', '')); // Parse price as float
            var total = qty * price;
            total = Math.round(total); // Round the total to the nearest integer
            subtotal += total; // Accumulate subtotal
            $(this).find('.itotal').text('₱' + total); // Display total without decimal places and with currency symbol
        });

        // Calculate grand total
        var deliveryFee = 10; // Assuming delivery fee is a constant value of 10
        var grandTotal = subtotal + deliveryFee;

        // Update subtotal, delivery fee, and grand total display
        $('.subtotal-price').text('₱' + subtotal.toFixed(2));
        $('.delivery-fee').text('₱' + deliveryFee.toFixed(2));
        $('.grand-total').text('₱' + grandTotal.toFixed(2));
    }

    // Increment button click event handler
    $('.increment-btn').click(function (e) {
        // Increment quantity and update total price
        // (code unchanged)
    });

    // Decrement button click event handler
    $('.decrement-btn').click(function (e) {
        // Decrement quantity and update total price
        // (code unchanged)
    });

    // Call updateTotalPrice initially to set the initial total prices
    updateTotalPrice();

    // Trigger change event to ensure display updates when value changes
    $('.input-qty').trigger('change');


        
