$(document).ready(function () {
    $('input[name="placeOrderBtn"]').click(function() {
        // Calculate subtotal and grand total
        var subtotal = parseFloat($('.subtotal-price').text().replace('₱', ''));
        var additionalFee = parseFloat($('.additional-fee').text().replace('₱', ''));
        var grandTotal = parseFloat($('.grand-total').text().replace('₱', ''));

        // Assign subtotal and grand total values to hidden input fields
        $('input[name="subtotal"]').val(subtotal); // Add this line
        $('input[name="additional_fee"]').val(additionalFee);
        $('input[name="grandtotal"]').val(grandTotal);

        // Submit the form
        $('form').submit();
    });
});
