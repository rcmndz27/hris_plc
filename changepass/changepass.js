$(function () {

    $('#submit').click(function (e) {
        e.preventDefault();

        if($('#userPassword').val() === $('#reUserPassword').val()){
  
            param = {
                "Action":"UpdatePassword",
                "userpassword": $('#userPassword').val()
            };
            param = JSON.stringify(param);
    
            $.ajax({
                type: "POST",
                url: "../changepass/changepass-process.php",
                data: {data:param} ,
                success: function (data){
                    // console.log("success: "+ data);
                    $('#popUpModal').modal('toggle');
                },
                error: function (data){
                    // console.log("error: "+ data);	
                }
            });//ajax
  
        }else{
            $('#modalText').html('Password Mismatch');
            $('#messageModal').modal('toggle');
        }
  
    });


    $('#close').click(function(e){
        e.preventDefault();
        window.location.replace("../pages/index.php");
    });
});