$(function(){


    $('#Submit').click(function(){

        if($('#newpassword').val() === $('#confirmpassword').val()){


            param = {
                "Action":"ChangePass",
                "newpassword": $('#newpassword').val(),
                "empCode": $('#empCode').val(),
                "confirmpassword": $('#confirmpassword').val()
            };
            
            param = JSON.stringify(param);

            // swal(param);
            // exit();
            
            $.ajax({
                type: "POST",
                url: "../controller/changepassprocess.php",
                data: {data:param} ,
                success: function (data){
                    console.log("success: "+ data);
                    $('#popUpModal').modal('toggle');
                    swal({text:"You have succesfully changed your password!",icon:"success"});
                    // location.reload();
                },
                error: function (data){
                    // console.log("error: "+ data);	
                }
            });//ajax

        }else{
            swal({text:"Password do not match!",icon:"error"});
        }
        
    });

});
