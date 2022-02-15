$(function(){

      $('#plantillaEntry').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');

    });


    
    function CheckInput(){
    
        var inputValues = [];
    
        inputValues = [
            $('#entry_date'),
            $('#department'),
            $('#position'),
            $('#reporting_to'),
            $('#status'),          
        ];


        var result = (CheckInputValue(inputValues) === '0') ? true : false;
        return result;
    }

    $('#Submit').click(function(){

        if (CheckInput() === true) {
    
            param = {
                'Action': 'InsertPlantillaEnt',
                'entry_date': $('#entry_date').val(),
                'department': $( "#department option:selected" ).text(),
                'position': $( "#position option:selected" ).text(),
                'reporting_to': $( "#reporting_to option:selected" ).text(),
                'status': $('#status').val()                     
            }
    
            param = JSON.stringify(param);

            // swal(param);
            // exit();

                     swal({
                          title: "Are you sure you want to submit this?",
                          text: "Please make sure all information are true and correct.",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((plaEnt) => {
                          if (plaEnt) {
                                    $.ajax({
                                        type: 'POST',
                                        url: '../applicantprofile/plaent_process.php',
                                        data: {
                                            data: param
                                        },
                                        success: function (result) {
                                            console.log('success: ' + result);
                                            location.reload();
                                        },
                                        error: function (result) {
                                            // console.log('error: ' + result);
                                        }
                                    }); //ajax
                          } else {
                            swal({text:"You cancel the submission of your plantilla details!",icon:"error"});
                          }
                        });

                }else{
                }
            });


        });







