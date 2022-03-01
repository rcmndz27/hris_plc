 $(function(){

   
    function CheckInput() {

        var inputValues = [];

        inputValues = [
            
            $('#ob_destination'),
            $('#ob_purpose'),
            $('#ob_percmp')
            
        ];

        var result = (CheckInputValue(inputValues) === '0') ? true : false;
        return result;
    }


            $('#ob_to').change(function(){

                if($('#ob_to').val() < $('#ob_from').val()){

                    swal({text:"OB date TO must be greater than OB Date From!",icon:"error"});

                    var input2 = document.getElementById('ob_to');
                    input2.value = '';               

                }else{
                    // alert('Error');
                }   

            });


            $('#ob_from').change(function(){

                    var input2 = document.getElementById('ob_to');
                    document.getElementById("ob_to").min = $('#ob_from').val();
                    input2.value = '';

            });



$('#Submit').click(function(){


            var dte = $('#ob_from').val();
            var dte_to = $('#ob_to').val();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
            dateArr = []; //Array where rest of the dates will be stored

            //creating JS date objects
            var start = new Date(dte);
            var date = new Date(dte_to);
            var end = date.setDate(date.getDate() + 1);

            //Logic for getting rest of the dates between two dates("FromDate" to "EndDate")
            while(start < end){
               dateArr.push(moment(start).format('MM-DD-YYYY'));
               var newDate = start.setDate(start.getDate() + 1);
               start = new Date(newDate);  
            }

            const ite_date = dateArr.length === 0  ? dte : dateArr ;

            if (CheckInput() === true) {

                param = {
                    "Action":"ApplyObApp",
                    "ob_date": ite_date,
                    "ob_time": $('#ob_time').val(),
                    "ob_destination": $('#ob_destination').val(),
                    "ob_purpose": $('#ob_purpose').val(),
                    "ob_percmp": $('#ob_percmp').val()
                };
                
                param = JSON.stringify(param);

                // swal(param);
                // exit();

                    if($('#ob_to').val() >= $('#ob_from').val()){

                            swal({
                              title: "Are you sure?",
                              text: "You want to apply this official business?",
                              icon: "success",
                              buttons: true,
                              dangerMode: true,
                            })
                            .then((applyOb) => {
                              if (applyOb) {
                                        $.ajax({
                                        type: "POST",
                                        url: "../ob/ob_app_process.php",
                                        data: {data:param} ,
                                        success: function (data){
                                            console.log("success: "+ data);
                                            // $('#popUpModal').modal('toggle');
                                            location.reload();
                                        },
                                        error: function (data){
                                            // alert('error');
                                        }
                                    });//ajax

                              } else {
                                swal({text:"You cancel your official business!",icon:"error"});
                              }
                            });
                        }else{
                            swal({text:"OB DATE TO must be greater than OB DATE FROM!",icon:"error"});
                    }                
            }
                              
    });



 $('#applyOfBus').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');

    });

});
