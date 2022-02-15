$(function(){

    $('#usersEntry').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');

    });

    
    function CheckInput(){
    
        var inputValues = [];
    
        inputValues = [
            $('#emp_code'),
            $('#password')
        ];


        var result = (CheckInputValue(inputValues) === '0') ? true : false;
        return result;
    }



    $('#Submit').click(function(){

        var empcode = $('#emp_code').children("option:selected").val();
        var emp_code = empcode.split(" - ");


        if (CheckInput() === true) {
   
            param = {
                'Action': 'InsertUsersEnt',
                'userid': emp_code[0],
                'username': emp_code[1],
                'userpassword': $('#password').val(),
                'usertype': $('#emp_level').val(),
                'status': $( "#status option:selected" ).text()
              

            }
    
            param = JSON.stringify(param);

            // swal(param);
            // exit();

                     swal({
                          title: "Are you sure you want to add this users details?",
                          text: "Please make sure all information are true and correct.",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((appEnt) => {
                          if (appEnt) {
                                    $.ajax({
                                        type: 'POST',
                                        url: '../users/usersent_process.php',
                                        data: {
                                            data: param
                                        },
                                        success: function (result) {
                                            console.log('success: ' + result);
                                            swal({text:"Successfully added employee login details!",icon:"success"});
                                            location.reload();
                                        },
                                        error: function (result) {
                                            console.log('error: ' + result);
                                        }
                                    }); //ajax
                          } else {
                            swal({text:"You cancel the submission of your employee login details!",icon:"error"});
                          }
                        });

                }else{
                    swal({text:"Please fill-up all required (*) fields. ",icon:"error"});

                }
            });


        });







