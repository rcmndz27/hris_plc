$(function(){

    var empId;
    var rowId;

    function SetEmployeeCode(element){

        param = {"Action":"GetApprovedList", "employee":$(element).attr('value')};

        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../ob/ob-approval-process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $('#approvedList').remove();
                $('#approvedObList').append(data);
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    }

    $(document).on('click','.btnApproved',function(e){

        var apvdOb = $(this).closest('tr').find("td:eq(5) input").val();

        param = {"Action":"ApproveOB",'rowid': this.id,'approvedob': apvdOb,'empId':empId};

        param = JSON.stringify(param);

                        swal({
                          title: "Are you sure?",
                          text: "You want to approve this official business?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((savePayroll) => {
                          if (savePayroll) {
                                            $.ajax({
                                                type: "POST",
                                                url: "../ob/ob-approval-process.php",
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
                             swal({text:"You cancel the approval of official business!",icon:"error"});

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

        param = {"Action":"GetOBDetails",'empId': empId};

        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../ob/ob-approval-process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $("#employeeOBDetailList").remove();
                $("#obDetails").append(data);
                // location.reload();
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax

    });
    
    $('#submit').click(function(e){
        e.preventDefault();

        param = {"Action":"RejectOB",'rowid': rowid,'empId':empId, "rjctRsn": $('#rejectReason').val()};

        param = JSON.stringify(param);

       
        // swal(param);
        // exit();
                        swal({
                          title: "Are you sure?",
                          text: "You want to reject this official business?",
                          icon: "error",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((rejPayroll) => {
                          if (rejPayroll) {
                                    $.ajax({
                                        type: "POST",
                                        url: "../ob/ob-approval-process.php",
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
                            swal({text:"You cancel the rejection of official business!",icon:"error"});
                          }
                        });


    });

    $('#search').click(function(e){
        e.preventDefault();

        param = {"Action":"GetEmployeeList", "employee":$('#employeeSearch').val()};

        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../ob/ob-approval-process.php",
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