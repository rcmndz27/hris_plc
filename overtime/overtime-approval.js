$(function(){

    var empId;
    var rowId;

    function SetEmployeeCode(element){

        param = {"Action":"GetApprovedList", "employee":$(element).attr('value')};

        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../overtime/overtime-approval-process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $('#approvedList').remove();
                $('#approvedOvertimeList').append(data);
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    }

    $(document).on('click','.btnApproved',function(e){

        var apvdOt = $(this).closest('tr').find("td:eq(4) input").val();

        param = {"Action":"ApproveOT",'rowid': this.id,'approvedot': apvdOt,'empId':empId};

        param = JSON.stringify(param);

                        swal({
                          title: "Are you sure?",
                          text: "You want to approve this overtime?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((savePayroll) => {
                          if (savePayroll) {
                                            $.ajax({
                                                type: "POST",
                                                url: "../overtime/overtime-approval-process.php",
                                                data: {data:param} ,
                                                success: function (data){
                                                    console.log("success: "+ data);
                                                    location.reload();
                                                },
                                                error: function (data){
                                                    // console.log("error: "+ data);    
                                                }
                                            });//ajax

                          } else {
                            swal("Your cancel the approval of overtime!");
                          }
                        });


      

    });

    $(document).on('click','.btnRejectd',function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');
        rowid = this.id;
    });

    $(document).on('click','.btnPending',function(e){

        empId = this.id;

        param = {"Action":"GetOTDetails",'empId': empId};

        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../overtime/overtime-approval-process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $("#employeeOTDetailList").remove();
                $("#otDetails").append(data);
                // location.reload();
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax

    });
    
    $('#submit').click(function(e){
        e.preventDefault();

        param = {"Action":"RejectOT",'rowid': rowid,'empId':empId, "rjctRsn": $('#rejectReason').val()};

        param = JSON.stringify(param);


                        swal({
                          title: "Are you sure?",
                          text: "You want to reject this overtime?",
                          icon: "error",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((savePayroll) => {
                          if (savePayroll) {
                                    $.ajax({
                                        type: "POST",
                                        url: "../overtime/overtime-approval-process.php",
                                        data: {data:param} ,
                                        success: function (data){
                                            console.log("success: "+ data);
                                            location.reload();
                                        },
                                        error: function (data){
                                            // console.log("error: "+ data);    
                                        }
                                    });//ajax

                          } else {
                            swal("Your cancel the rejection of overtime!");
                          }
                        });


    });

    $('#search').click(function(e){
        e.preventDefault();

        param = {"Action":"GetEmployeeList", "employee":$('#employeeSearch').val()};

        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../overtime/overtime-approval-process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $('#empList').remove();
                $('#list-box').append(data);

                $("#empList li").bind("click",function(){
                    SetEmployeeCode(this);
                    $('#empList').remove();
                });
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    });

    

});