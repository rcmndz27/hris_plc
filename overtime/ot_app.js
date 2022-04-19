 $(function(){

   $('#planot').hide();

    function CheckInput() {

        var inputValues = [];

        inputValues = [

            $('#remarks'),
            $('#otstartdtime')           
        ]

        var result = (CheckInputValue(inputValues) === '0') ? true : false;
        return result;
    }


            $('#otdateto').change(function(){

                if($('#otdateto').val() < $('#otdate').val()){

                    swal({text:"OT date TO must be greater than OT Date From!",icon:"error"});

                    var input2 = document.getElementById('otdateto');
                    input2.value = '';               

                }   

            });


            $('#otdate').change(function(){

                    var input2 = document.getElementById('otdateto');
                    document.getElementById("otdateto").min = $('#otdate').val();
                    input2.value = '';

            });


            $('#otstartdtime').change(function(){
                $('#planot').show();
                document.getElementById('otenddtime').value = ''; 
                document.getElementById('otreqhrs').value = 0; 
            });


$('#Submit').click(function(){

    

            var dte = $('#otdate').val();
            var dte_to = $('#otdateto').val();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
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
                    "Action":"ApplyOtApp",
                    "otdate": ite_date,
                    "otstartdtime": $('#otstartdtime').val(),
                    "otenddtime": $('#otenddtime').val(),
                    "otreqhrs": $('#otreqhrs').val(),
                    "remarks": $('#remarks').val()
                };
                
                param = JSON.stringify(param);

                    if($('#otdateto').val() >= $('#otdate').val()){

                            swal({
                              title: "Are you sure?",
                              text: "You want to apply this overtime?",
                              icon: "info",
                              buttons: true,
                              dangerMode: true,
                            })
                            .then((applyOT) => {
                              if (applyOT) {
                                        $.ajax({
                                        type: "POST",
                                        url: "../overtime/ot_app_process.php",
                                        data: {data:param} ,
                                        success: function (data){
                                            // console.log("success: "+ data);
                                                    swal({
                                                    title: "Wow!", 
                                                    text: "Successfully added overtime details!", 
                                                    type: "success",
                                                    icon: "success",
                                                    }).then(function() {
                                                        location.href = '../overtime/ot_app_view.php';
                                                    });
                                        },
                                        error: function (data){
                                            // alert('error');
                                        }
                                    });//ajax

                              } else {
                                swal({text:"Your cancel your overtime!",icon:"error"});
                              }
                            });
                        }else{
                            swal({text:"OT date TO must be greater than OT Date From!",icon:"error"});
                        }
                 
            }else{
                swal({text:"Kindly fill up blank fields!",icon:"error"});
            }
                        
      
        
    });



 $('#applyOvertime').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');

    });

});
