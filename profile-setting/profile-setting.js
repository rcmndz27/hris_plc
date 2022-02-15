var picValue;

function ImageEncode() {
  var selectedfile = document.getElementById("imgInput").files;
  if (selectedfile.length > 0) {
    var imageFile = selectedfile[0];
    var fileReader = new FileReader();
    fileReader.onload = function (fileLoadedEvent) {
      var srcData = fileLoadedEvent.target.result;
      picValue = srcData;
      // picValue = picValue.replace("data:image/jpeg;base64,", "");
      document.getElementById('imgPic').src = srcData;
    }
    fileReader.readAsDataURL(imageFile);
  }
}

