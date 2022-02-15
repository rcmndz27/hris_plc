$(function(){

    $('#allowancesEntry').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');

    });

    
    function CheckInput(){
    
        var inputValues = [];
    
        inputValues = [
            $('#emp_code'),
            $('#benefit_id'),
            $('#period_cutoff'),
            $('#effectivity_date'),
            $('#amount')          
        ];


        var result = (CheckInputValue(inputValues) === '0') ? true : false;
        return result;
    }



    $('#Submit').click(function(){

        var empcode = $('#emp_code').children("option:selected").val();
        var emp_code = empcode.split(" - ");
        var benefitid = $('#benefit_id').children("option:selected").val();
        var benefit_id = benefitid.split(" - ");


        if (CheckInput() === true) {
   
            param = {
                'Action': 'InseryAllowancesEnt',
                'emp_code': emp_code[0],
                'benefit_id': benefit_id[0],
                'period_cutoff': $( "#period_cutoff option:selected" ).text(),
                'effectivity_date': $('#effectivity_date').val(),
                'amount': $('#amount').val()                   
            }
    
            param = JSON.stringify(param);

            // swal(param);
            // exit();

                     swal({
                          title: "Are you sure you want to add this employee allowance details?",
                          text: "Please make sure all information are true and correct.",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((appEnt) => {
                          if (appEnt) {
                                    $.ajax({
                                        type: 'POST',
                                        url: '../allowances/allowancesent_process.php',
                                        data: {
                                            data: param
                                        },
                                        success: function (result) {
                                            console.log('success: ' + result);
                                            swal({text:"Successfully added employee allowance details!",icon:"success"});
                                            location.reload();
                                        },
                                        error: function (result) {
                                            console.log('error: ' + result);
                                        }
                                    }); //ajax
                          } else {
                            swal({text:"You cancel the submission of your employee allowance details!",icon:"error"});
                          }
                        });

                }else{
                    swal({text:"Please fill-up all required (*) fields. ",icon:"error"});
                }
            });


        });







