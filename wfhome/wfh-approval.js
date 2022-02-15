$(function(){

    var empId;
    var rowId;

    function SetEmployeeCode(element){

        param = {"Action":"GetApprovedList", "employee":$(element).attr('value')};

        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../wfhome/wfh-approval-process.php",
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

        param = {"Action":"ApproveWfh",'rowid':this.id,'empId':empId,};


        param = JSON.stringify(param);

                   swal({
                          title: "Are you sure?",
                          text: "You want to approve this work from home?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((approveWfh) => {
                          if (approveWfh) {
                                      $.ajax({
                                            type: "POST",
                                            url: "../wfhome/wfh-approval-process.php",
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
                            swal("Your cancel the approval of work from home!");
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

        param = {"Action":"GetWfhDetails",'empId': empId};

        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../wfhome/wfh-approval-process.php",
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

        param = {"Action":"RejectWfh",'rowid': rowid,'empId':empId, "rjctRsn": $('#rejectReason').val()};

        param = JSON.stringify(param);

        // alert(rowid);
        // exit();

                    swal({
                          title: "Are you sure?",
                          text: "You want to reject this work from home?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((approveWfh) => {
                          if (approveWfh) {
                                    $.ajax({
                                        type: "POST",
                                        url: "../wfhome/wfh-approval-process.php",
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
                            swal("Your cancel the rejection of work from home!");
                          }
                        });


    });

    $('#search').click(function(e){
        e.preventDefault();

        param = {"Action":"GetEmployeeList", "employee":$('#employeeSearch').val()};

        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../wfhome/wfh-approval-process.php",
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