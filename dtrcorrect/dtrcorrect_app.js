
 $(function(){

    $('#dtrtype').change(function(){

        if ($(this).val() == 'Both'){
            document.getElementById("ltimein").style.display="block";
            document.getElementById("time_in").style.display="block";
            document.getElementById("ltimeout").style.display="block";
            document.getElementById("time_out").style.display="block";
            console.log('Both');
        }else if($(this).val() == 'Time-in'){
            document.getElementById("ltimein").style.display="block";
            document.getElementById("time_in").style.display="block";
            document.getElementById("ltimeout").style.display="none";
            document.getElementById("time_out").style.display="none";
            document.getElementById('time_out').value =  null;
            console.log('Time-in Only');
        }else{
            document.getElementById("ltimein").style.display="none";
            document.getElementById("time_in").style.display="none";
            document.getElementById("ltimeout").style.display="block";
            document.getElementById("time_out").style.display="block";
            document.getElementById('time_out').value =  null;
            console.log('Time-out Only');
        }


    
});


$('#dtrc_date').change(function(){
document.getElementById('time_in').value =  null;     
document.getElementById('time_out').value =  null; 

});


    function CheckInput() {

        var inputValues = [];

        inputValues = [
            
            $('#dtrc_date'),
            // $('#time_in'),
            // $('#time_out'),
            $('#remarks')
            
        ];

        var result = (CheckInputValue(inputValues) === '0') ? true : false;
        return result;
    }

$('#Submit').click(function(){

            var e_req = $('#e_req').val();
            var n_req = $('#n_req').val();
            var e_appr = $('#e_appr').val();
            var n_appr = $('#n_appr').val();      

            if (CheckInput() === true) {

                param = {
                    "Action":"ApplyDtrcApp",
                    "dtrc_date": $('#dtrc_date').val(),
                    "time_in": $('#time_in').val(),
                    "time_out": $('#time_out').val(),
                    "dtrc_type": $('#dtrtype').val(),
                    "remarks": $('#remarks').val(),
                    "e_req": e_req,
                    "n_req": n_req,
                    "e_appr": e_appr,
                    "n_appr": n_appr                      
                    
               };
                
                param = JSON.stringify(param);

                // console.log(param);
                // return false;
                    
                    swal({
                      title: "Are you sure?",
                      text: "You want to apply this dtr correction?",
                      icon: "success",
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((applyWfh) => {
                    document.getElementById("myDiv").style.display="block";                            
                      if (applyWfh) {
                        $.ajax({
                            type: "POST",
                            url: "../dtrcorrect/dtrcorrect_app_process.php",
                            data: {data:param} ,
                            success: function (data){
                                console.log("success: "+ data);
                                swal({
                                title: "Success!", 
                                text: "Successfully added dtr correction details!", 
                                type: "success",
                                icon: "success",
                                }).then(function() {
                                    location.href = '../dtrcorrect/dtrcorrect_app_view.php';
                                });
                            },
                            error: function (data){
                                swal('error');
                            }
                        });
                      } else {
                        document.getElementById("myDiv").style.display="none";
                        swal({text:"You cancel your dtr correction!!",icon:"error"});
                      }
                    });
 
            }else{
                swal({text:"Kindly fill up blank fields!",icon:"error"});
            }

      
    });



 $('#applydtrcorrect').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');
    });

});
