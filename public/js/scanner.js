$(document).ready(function () {
  const cameraButton = $('#camera-icon');
  const tempButton = $('#temp-icon');
  const interactiveDiv = $('#interactive');

  var inputProductName = $('#product_name');
  var inputProductQuantity = $('#product_quantity');
  var inputProductBarcode = $('#product_barcode');
  var inputProductPrice = $('#product_price');
  var inputProductPriceBought = $('#product_price_bought');
  var inputProductImage = $('#product_image');
  //var w = window.innerWidth;
  //var h = window.innerHeight;

  tempButton.click(function () {
    checkProduct(inputProductBarcode.val());
  })
  interactiveDiv.click(function () {
    Quagga.stop;
    interactiveDiv.hide();
  })

  cameraButton.click(function () {
    interactiveDiv.show();
    Quagga.onDetected(function (result) {
      var last_code = result.codeResult;
      last_result.push(last_code);
      //console.log(last_code.code);
      //alert(last_code.code);
      //inputProductBarcode.val(last_code.code);
      clearFields();
      checkProduct(last_code.code);

      Quagga.stop();
      interactiveDiv.hide();

    })

    Quagga.init({
      inputStream: {
        name: "Live",
        type: "LiveStream",
        width: { min: 640 },
        height: { min: 480 },
        target: document.querySelector('#yourElement')    // Or '#yourElement' (optional)
      },
      locator: {
        patchSize: "medium",
        halfSample: true
      },
      numOfWorkers: 2,
      frequency: 20,
      decoder: {
        readers:
          ['code_128_reader', "ean_reader", "ean_8_reader", "code_39_reader",]
        ,
        debug: {
          drawBoundingBox: false,
          showFrequency: false,
          drawScanline: false,
          showPattern: false
        },
        multiple: false
      },
    }, function (err) {
      if (err) {
        console.log(err);
        return
      }
      console.log("Initialization finished. Ready to start");
      Quagga.start();
    });
    var last_result = [];

  });


  $("#product_file").change(function () {
    readURL(this);
  });

  function checkProduct(barcode)
  {
    $.ajax({
      type: "POST",
      url: '/product/' + barcode,
      // data: some , // serializes the form's elements.
      success: function (data) {
        //alert(data); // show response from the php script.
        const parsedData = JSON.parse(data);
        //alert(parsedData.name);
        clearFields();
        inputProductName.val(parsedData.name);
        inputProductBarcode.val(parsedData.barcode)
        inputProductQuantity.val(parsedData.quantity);
        inputProductPrice.val(parsedData.price);
        inputProductPriceBought.val(parsedData.price_bought);
        if (parsedData.image == '' || null || 'null') {
          inputProductImage.attr('src', 'assets/fruitVeggy.png');
        }
        else {
          inputProductImage.attr('src', 'uploads/images/' + parsedData.image);
        }
      }
    });
  }
  //show image
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
        $('#product_image').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function clearFields() {
    inputProductName.val('');
    inputProductBarcode.val('')
    inputProductQuantity.val(0);
    inputProductPrice.val(0);
    inputProductPriceBought.val(0);
    inputProductImage.attr('src', 'assets/fruitVeggy.png');
  }

})








