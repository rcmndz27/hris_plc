$(function(){

    $('#Submit').click(function(){ 

    var newp = $('#newpassword').val();
    var conf = $('#confirmpassword').val();

        if(newp === '' || conf === ''){
             swal({text:"Please fill-up all required (*) fields. ",icon:"error"});
             return false;
        }else{
                if(newp === conf)
                {

                    param = {
                        "Action":"ChangePass",
                        "newpassword": $('#newpassword').val(),
                        "empCode": $('#empCode').val(),
                        "confirmpassword": $('#confirmpassword').val()
                    };
                    
                    param = JSON.stringify(param);

                             swal({
                                  title: "Are you sure?",
                                  text: "You want to change your password.",
                                  icon: "success",
                                  buttons: true,
                                  dangerMode: true,
                                })
                                .then((appEnt) => {
                                  if (appEnt) {
                                            $.ajax({
                                                type: 'POST',
                                                url: "../controller/changepassprocess.php",
                                                data: {
                                                    data: param
                                                },
                                                success: function (result) {
                                                    console.log('success: ' + result);
                                                    swal({text:"You have succesfully changed your password!",icon:"success"});
                                                    location.reload();
                                                },
                                                error: function (result) {
                                                    console.log('error: ' + result);
                                                }
                                            }); //ajax
                                  } else {
                                    swal({text:"You cancel the changing of your password!",icon:"error"});
                                  }
                                });
                     }else{
                    swal({text:"Password do not match!",icon:"error"});
                    }

        }



        
    });
 });


