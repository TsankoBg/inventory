$(document).ready(function () {
    var inputBarcode = $("#input-barcode");
    var priceText = $("#price-text");
    var nameText = $("#name-text");

    inputBarcode.on('keyup', function (e) {
        if (e.keyCode === 13) {
            try {
                checkPrice(inputBarcode.val());
            } catch (error) {
                console.error(error);
                inputBarcode.val('');
            }
        }
    });

    function checkPrice(barcode) {
        inputBarcode.val('');
        $.ajax({
            type: "POST",
            url: '/product/' + barcode,
            // data: some , // serializes the form's elements.
            success: function (data) {
                const parsedData = JSON.parse(data);
                console.log(parsedData);
                assigneProductFields(parsedData);
            },
            error: function () {
                priceText.text("0.00лв");
                nameText.text('');
            },
        });
    }

    function assigneProductFields(product) {
        priceText.text(parseFloat(product.price).toFixed(2) + "лв");
        nameText.text(product.name);
    }
});