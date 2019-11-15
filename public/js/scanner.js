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
    Quagga.stop;product_name
    interactiveDiv.hide();
  })
  // on camera button click open camera 
  cameraButton.click(function () {
    //show camera placeholder
    interactiveDiv.show();
    //on scan detected
    Quagga.onDetected(function (result) {
      var last_code = result.codeResult;
      last_result.push(last_code);
      // check if object which scanned barcode exists
      checkProduct(last_code.code);
      inputProductBarcode.val(last_code.code);

      Quagga.stop();
      interactiveDiv.hide();

    })
    //Initialize barcode scanner api
    Quagga.init({
      inputStream: {
        name: "Live",
        type: "LiveStream",
        width: { min: 640 },
        height: { min: 480 },
        target: document.querySelector('#yourElement')    // Or '#yourElement' (optional)
      },
      locator: {
        patchSize: "high",
        halfSample: true
      },
      numOfWorkers: 2,
      frequency: 20,
      decoder: {
        readers:
          ["ean_reader"]
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

  //on file change
  $("#product_file").change(function () {
    readURL(this);
  });
  // ajax call request on success returns found product and assigns the field 
  function checkProduct(barcode) {
    console.log('here');
    clearFields();
    $.ajax({
      type: "POST",
      url: '/product/' + barcode,
      // data: some , // serializes the form's elements.
      success: function (data) {
        //alert(data); // show response from the php script.
        const parsedData = JSON.parse(data);
        //alert(parsedData.name);

        assignFields(parsedData);

      }
    });
  }
  //assigns all fields accordingly to given product data
  function assignFields(parsedData) {
    inputProductName.val(parsedData.name);
    inputProductBarcode.val(parsedData.barcode)
    inputProductQuantity.val(parsedData.quantity);
    //inputProductPrice.val(parsedData.price);
    inputProductPriceBought.val(parsedData.price_bought);
    if (parsedData.image == '' || null || 'null') {
      inputProductImage.attr('src', 'assets/fruitVeggy.png');
    }
    else {
      inputProductImage.attr('src', 'uploads/images/' + parsedData.image);
    }
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
  // clear all text fields
  function clearFields() {
    inputProductName.val('');
    inputProductBarcode.val('')
    inputProductQuantity.val(0);
    inputProductPrice.val(0);
    inputProductPriceBought.val(0);
    inputProductImage.attr('src', 'assets/fruitVeggy.png');
  }


  // ajax add product form submission
  $("#add-product-form").submit(function (e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var url = form.attr('action');

    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(), // serializes the form's elements.
      success: function (data) {
        //alert(data); // show response from the php script.
        let product = JSON.parse(data);
        $.notify(product.name + " беше добавен", 'success');
        clearFields();
      },
      error: function (data) {
        $.notify("Грешка", 'error');
      },
    });
  });

  //typeahead search and select products
  inputProductName.typeahead({
    source: function (query, result) {
      $.ajax({
        url: "/products",
        data: 'query=' + query,
        dataType: "json",
        type: "POST",
        success: function (data) {
          result($.map(data, function (item) {
            return item;
          }));
        }
      });
    },
    afterSelect: function (item) {
     console.log(item);
     assignFields(item);
  }
  });
})








