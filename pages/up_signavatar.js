
var pdfAvatar;
var pdfSign;

function GetAvatarFile() {
    var selectedfile = document.getElementById("up_avatar").files;
    if (selectedfile.length > 0) {
        var uploadedFile = selectedfile[0];
        var fileReader = new FileReader();
        var fl = uploadedFile.name;

        fileReader.onload = function (fileLoadedEvent) {
            var srcData = fileLoadedEvent.target.result;
            pdfAvatar =  fl;
        }
        fileReader.readAsDataURL(uploadedFile);
    }
}


function uploadAvatar() {

   var files = document.getElementById("up_avatar").files;

   if(files.length > 0 ){

      var formData = new FormData();
      formData.append("file", files[0]);

      var xhttp = new XMLHttpRequest();

      // Set POST method and ajax file path
      xhttp.open("POST", "ajax_avasign.php", true);

      // call on request changes state
      xhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {

           var response = this.responseText;
           if(response == 1){
              // alert("Upload successfully.");
           }else{
              // alert("File not uploaded.");
           }
         }
      };

      // Send request with data
      xhttp.send(formData);

   }else{
      // swal({text:"Please upload a file!",icon:"warning"});
   }

}

    

function GetSignFile() {
    var selectedfile = document.getElementById("up_sign").files;
    if (selectedfile.length > 0) {
        var uploadedFile = selectedfile[0];
        var fileReader = new FileReader();
        var fl = uploadedFile.name;

        fileReader.onload = function (fileLoadedEvent) {
            var srcData = fileLoadedEvent.target.result;
            pdfSign =  fl;
        }
        fileReader.readAsDataURL(uploadedFile);
    }
}


function uploadSign() {

   var files = document.getElementById("up_sign").files;

   if(files.length > 0 ){

      var formData = new FormData();
      formData.append("file", files[0]);

      var xhttp = new XMLHttpRequest();

      // Set POST method and ajax file path
      xhttp.open("POST", "ajax_avasign.php", true);

      // call on request changes state
      xhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {

           var response = this.responseText;
           if(response == 1){
              // alert("Upload successfully.");
           }else{
              // alert("File not uploaded.");
           }
         }
      };

      // Send request with data
      xhttp.send(formData);

   }else{
      // swal({text:"Please upload a file!",icon:"warning"});
   }

}


  

 $(function(){


$('#SubmitAvatar').click(function(){
  
                param = {
                    "Action":"UploadAvatar",
                    "up_avatar": pdfAvatar                   
                    
               };
                
                param = JSON.stringify(param);

                // console.log(param);
                // return false;
                    
                    swal({
                      title: "Are you sure?",
                      text: "You want to update your avatar?",
                      icon: "success",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((applyWfh) => {
                    document.getElementById("myDiv").style.display="block";                            
                      if (applyWfh) {
                        $.ajax({
                            type: "POST",
                            url: "../pages/up_signavatar_process.php",
                            data: {data:param} ,
                            success: function (data){
                                console.log("success: "+ data);
                                swal({
                                title: "Success!", 
                                text: "Successfully updated avatar!", 
                                type: "success",
                                icon: "success",
                                }).then(function() {
                                    location.href = '../pages/myprofile_view.php';
                                });
                            },
                            error: function (data){
                                swal('error');
                            }
                        });
                      } else {
                        document.getElementById("myDiv").style.display="none";
                        swal({text:"You cancel your updating of avatar!",icon:"error"});
                      }
                    });
 


      
    });

$('#SubmitSign').click(function(){
  
                param = {
                    "Action":"UploadSign",
                    "up_sign": pdfSign                   
                    
               };
                
                param = JSON.stringify(param);

                // console.log(param);
                // return false;
                    
                    swal({
                      title: "Are you sure?",
                      text: "You want to update your avatar?",
                      icon: "success",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((applyWfh) => {
                    document.getElementById("myDiv").style.display="block";                            
                      if (applyWfh) {
                        $.ajax({
                            type: "POST",
                            url: "../pages/up_signavatar_process.php",
                            data: {data:param} ,
                            success: function (data){
                                console.log("success: "+ data);
                                swal({
                                title: "Success!", 
                                text: "Successfully updated signature!", 
                                type: "success",
                                icon: "success",
                                }).then(function() {
                                    location.href = '../pages/myprofile_view.php';
                                });
                            },
                            error: function (data){
                                swal('error');
                            }
                        });
                      } else {
                        document.getElementById("myDiv").style.display="none";
                        swal({text:"You cancel your updating of signature!",icon:"error"});
                      }
                    });
 


      
    });



 $('#upavatar').click(function(e){
        e.preventDefault();
        $('#avatarModal').modal('toggle');
    });

 $('#upsign').click(function(e){
        e.preventDefault();
        $('#signModal').modal('toggle');
    }); 

});
