

$(document).ready(function(){
const cameraButton=$('#camera-icon');
const interactiveDiv=$('#interactive');
var w = window.innerWidth;
var h = window.innerHeight;

cameraButton.click(function() {
  interactiveDiv.show();
  Quagga.onDetected(function(result){
    var last_code=result.codeResult;
    last_result.push(last_code);
    console.log(last_code);
    //alert(last_code.code);
    $('#barcode-nbr').val(last_code.code);
    Quagga.stop();
    interactiveDiv.hide();

  })

    Quagga.init({
        inputStream : {
          name : "Live",
          type : "LiveStream",
          width: {min: 640},
          height: {min: 480},
          target: document.querySelector('#yourElement')    // Or '#yourElement' (optional)
        },
        locator: {
          patchSize: "medium",
          halfSample: true
      },
        numOfWorkers: 2,
        frequency: 20,
        decoder: {
          readers: [
            'code_128_reader',"ean_reader","ean_8_reader","code_39_reader",
          ],
          debug: {
              drawBoundingBox: false,
              showFrequency: false,
              drawScanline: false,
              showPattern: false
          },
          multiple: false
        },
      }, function(err) {
          if (err) {
              console.log(err);
              return
          }
          console.log("Initialization finished. Ready to start");
          Quagga.start();
      });
      var last_result=[];
    
  });
})




