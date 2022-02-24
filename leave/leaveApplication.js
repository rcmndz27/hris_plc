var pdfFile;

function GetMedFile() {
    var selectedfile = document.getElementById("medicalfiles").files;
    if (selectedfile.length > 0) {
        var uploadedFile = selectedfile[0];
        var fileReader = new FileReader();
        var fl = uploadedFile.name;

        fileReader.onload = function (fileLoadedEvent) {
            var srcData = fileLoadedEvent.target.result;
            pdfFile =  fl;
        }
        fileReader.readAsDataURL(uploadedFile);
    }
}


function uploadFile() {

   var files = document.getElementById("medicalfiles").files;

   if(files.length > 0 ){

      var formData = new FormData();
      formData.append("file", files[0]);

      var xhttp = new XMLHttpRequest();

      // Set POST method and ajax file path
      xhttp.open("POST", "ajaxfile.php", true);

      // call on request changes state
      xhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {

           var response = this.responseText;
           if(response == 1){
              alert("Upload successfully.");
           }else{
              alert("File not uploaded.");
           }
         }
      };

      // Send request with data
      xhttp.send(formData);

   }else{
      // alert("Please select a file");
   }

}


    

$(function(){

    var empname='';
    var leaveCount = 0;
    var allhaftday = 1;

    var empId;
    var creditLeave;
    var leaveType;
    var dateFrom;
    var dateTo;
    var approvedDays;
    var btnAccessed;

    $('#advancefiling').hide();
    $('#leavepay').hide();
    $('#sickleavebal').hide();
    $('#vacleavebal').hide();
    $('#paternity').hide();
    $('#maternity').hide();
    $('#specialwomen').hide();
    $('#specialviolence').hide();
    $('#soloparent').hide();
    $('#medicalFiles').hide();
    $('#halfdayset').hide();


    
    
    function CheckInput() {

        var inputValues = [];

        inputValues = [
            
            $('#leaveDesc'),
            
        ];

        var result = (CheckInputValue(inputValues) === '0') ? true : false;
        return result;
    }

    function LoadLeaveList(){

        param = {"Action":"GetLeaveListBlank"};

        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../leave/leaveApprovalProcess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $('#employeeLeaveList').remove();
                $('#leaveSummaryList').remove();
                $('#pendingList').append(data);
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    }

    function SetEmployeeCode(element){
        

        param = {"Action":"GetApprovedList", "employee":$(element).attr('value')};

        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../leave/leaveApprovalProcess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);

                $('#approvedList').remove();
                $('#approvedLeaveList').append(data);
               
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    }

    LoadLeaveList();

    $(document).on('click','.btnApproved',function(e){

        empId = this.id;
        rowid = $('.btnApproved').val() ;
        empcode = $('#empcode').val() ;
        dateFrom = $(this).closest('tr').find('td:eq(1)').text();
        dateTo = $(this).closest('tr').find('td:eq(2)').text();
        leaveType = $(this).closest('tr').find('td:eq(3)').text();
        approver = $(this).closest('tr').find('td:eq(5)').text();
        approvedDays = $(this).closest('tr').find("td:eq(6) input").val();


        param = {
            "Action":"ApproveLeave",
            'employee': empId,
            'curLeaveType': leaveType,
            "curApproved": approvedDays,
            "curDateFrom": dateFrom,
            "curDateTo": dateTo,
            "approver": approver,
            "empcode": empcode,
            "rowid": rowid
        };

  
        param = JSON.stringify(param);

        // alert(param);
        // exit();


                        swal({
                          title: "Are you sure?",
                          text: "You want to approve this leave?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((approveLeave) => {
                          if (approveLeave) {
                                        $.ajax({
                                            type: "POST",
                                            url: "../leave/leaveApprovalProcess.php",
                                            data: {data:param} ,
                                            success: function (data){
                                                console.log("success: "+ data);
                                                location.reload();
                                            },
                                            error: function (data){
                                                // console.log("error: "+ data);    
                                            }
                                        });
                          } else {
                            swal("Your cancel the approval of leave!");
                          }
                        });
        


    });

    $(document).on('click','.btnRejectd',function(e){


        empId = this.id;
        rwid = $('.btnRejectd').val();
        empcd = $('#empcode').val();
        dateFrom = $(this).closest('tr').find('td:eq(1)').text();
        dateTo = $(this).closest('tr').find('td:eq(2)').text();
        leaveType = $(this).closest('tr').find('td:eq(3)').text();
        rejecter = $(this).closest('tr').find('td:eq(5)').text();
        approvedDays = $(this).closest('tr').find("td:eq(6) input").val();

        $('#remarksModal').modal('toggle');

        btnAccessed = 'Reject';
    

    });

    $(document).on('click','.btnView',function(e){

        var curID = $(this).attr('id').split("-");
        var thisID = curID[0];

        window.open('../leave/leaveApprovalPDF.php?data=' + thisID, '_blank');
        
    });

    $(document).on('click','.btnPending',function(e){
        e.preventDefault();

        empName = $(this).closest('tr').find('td:eq(0)').text();
        var empCode = this.id;

        empname = empName;

        param = {
            "Action":"GetPendingList",
            "employee": empCode,
        };

        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../leave/leaveApprovalProcess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $('#employeeLeaveList').remove();
                $('#summaryList').append(data);
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    });

    $(document).on('click','.btnViewing',function(e){
        e.preventDefault();

        var empCode = this.id;

        param = {"Action":"GetLeaveHistory", "employee": empCode,};

        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../leave/leaveApprovalProcess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $('#dtrList').remove();
                $('#summaryList').append(data);
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    });
    
    $(document).on('click','.btnVoid',function(e){
        e.preventDefault();

        empId = this.id, 
        creditLeave =  $(this).closest('tr').find('td:eq(6)').text(),
        leaveType= $(this).closest('tr').find('td:eq(1)').text(),

        $('#remarksModal').modal('toggle');

        btnAccessed = 'Void';
    });

    $('.btnRemarks').click(function(e){
        e.preventDefault();

        $('#remarksModal').modal('toggle');

        if(btnAccessed === "Reject"){

            param = {
                "Action":"RejectLeave",
                'curLeaveType': leaveType,
                "curApproved": approvedDays,
                "curDateFrom": dateFrom,
                "curDateTo": dateTo,
                "employee": empId,
                "rwid": rwid,
                "rejecter": rejecter,
                "empcd": empcd,
                "remarks": $('#remarks').val()
            };

        }else{

            param = {
                "Action":"VoidLeave", 
                "employee": empId, 
                "creditleave": creditLeave,
                "leavetype": leaveType,
                "remarks": $('#remarks').val()
            };

        }

        param = JSON.stringify(param);
        
        // alert(param);
        // exit();

                          swal({
                          title: "Are you sure?",
                          text: "You want to reject this leave?",
                          icon: "warning",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((approveLeave) => {
                          if (approveLeave) {

                                        $.ajax({
                                            type: "POST",
                                            url: "../leave/leaveApprovalProcess.php",
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
                            swal("Your cancel the rejection!");
                          }
                        });
        

    });

    $('#applyLeave').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');

        var options = document.getElementById("leaveType").options;
        for (var i = 0; i < options.length; i++) {
          if (options[i].text == "Vacation Leave" && $('#emptype').val() === 'Regular' && $('#vac_leavebal').val() !== '0.0') {
            options[i].selected = true;
            $('#vacleavebal').show();
            $("#leavepay").show();
            break;
          }else if (options[i].text == "Vacation Leave" && $('#emptype').val() === 'Regular' && $('#vac_leavebal').val() === '0.0') {
            options[i].selected = true;
            $('#vacleavebal').show();
            $("#leavepay").show();
            $("#leave_pay2").prop("checked", true);
            $("#wpay").hide();
            break;
          }else if(options[i].text == "Vacation Leave" && $('#emptype').val() === 'Probationary'){
            $("#leavepay").show();
            $("#leave_pay2").prop("checked", true);
            $("#wpay").hide();
          }else{

          }
        }

    });




    $('#Submit').click(function(){


            // console.log(leaveCount);


                var leave_pay ;

                if($('#leaveType').val() === 'Sick Leave' && $('#leave_pay1:checked').val() === 'WithPay'){
                    leave_pay = 'Sick Leave';
                }else if($('#leaveType').val() === 'Sick Leave' && $('#leave_pay2:checked').val() === 'WithoutPay'){
                    leave_pay = 'Sick Leave without Pay';
                        // alert('Sick Leave without Pay');
                }else if($('#leaveType').val() === 'Vacation Leave' && $('#leave_pay1:checked').val() === 'WithPay'){
                    leave_pay = 'Vacation Leave';
                        // alert('Vacation Leave');
                }else if($('#leaveType').val() === 'Vacation Leave' && $('#leave_pay2:checked').val() === 'WithoutPay'){
                    leave_pay = 'Vacation Leave without Pay';
                        // alert('Vacation Leave without Pay');
                }else{
                    leave_pay = $('#leaveType').val();
                    // alert(leave_pay);
                }   

                // exit();

            if (CheckInput() === true) {

                param = {
                    "Action":"ApplyLeave",
                    "leavetype": leave_pay,
                    "datebirth": $('#dateBirth').val(),
                    "datestartmaternity": $('#dateStartMaternity').val(),
                    "datefrom": $('#dateFrom').val(),
                    "dateto": $('#dateTo').val(),
                    "leavedesc" : $('#leaveDesc').val(),
                    "medicalfile": pdfFile,
                    "leaveCount": leaveCount,
                    "allhalfdayMark": allhaftday
    
                };
                
                param = JSON.stringify(param);

                // alert(param);
                // exit();

                    if($('#dateTo').val() >= $('#dateFrom').val()){

                        swal({
                          title: "Are you sure?",
                          text: "You want to apply this leave?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((applyLeave) => {
                          if (applyLeave) {
                                    $.ajax({
                                        type: "POST",
                                        url: "../leave/leaveApplicationProcess.php",
                                        data: {data:param} ,
                                        success: function (data){
                                            console.log("success: "+ data);
                                            $('#popUpModal').modal('toggle');
                                            location.reload();
                                        },
                                        error: function (data){
                                            // console.log("error: "+ data);    
                                        }
                                    });//ajax
                          } else {
                            swal("Your cancel your leave!");
                          }
                        });
                    
                        }else{
                            swal({text:"Leave Date TO must be greater than Leave Date From!",icon:"error"});
                        }


            }else{
                swal({text:"Kindly fill up blank fields.",icon:"warning"});
            }

    
        
    });

    $('#leaveType').change(function(){

        if ($(this).val() == 'Sick Leave' && $('#sick_leavebal').val() === '0.0' && $('#emptype').val() === 'Regular') {
            $("#leave_pay2").prop("checked", true);
            $("#wpay").hide();
            $('#advancefiling').show();
            $('#paternity').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#Attachment').show();
            $('#AddAttachment').hide();
            $('#sickleavebal').show();
            $('#vacleavebal').hide();
            $('#leavepay').show();
            $('#Submit').show();
        }else if ($(this).val() == 'Sick Leave' && $('#sick_leavebal').val() !== '0.0' && $('#emptype').val() === 'Regular') {
            $("#leavepay").show();
            $('#advancefiling').show();
            $('#paternity').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#Attachment').show();
            $('#AddAttachment').hide();
            $('#sickleavebal').show();
            $('#vacleavebal').hide();
            $('#leavepay').show();
            $("#leave_pay1").prop("checked", true);
            $("#leave_pay2").prop("checked", false);
            $("#wpay").show();
            $('#Submit').show();
        }else if ($(this).val() == 'Vacation Leave' && $('#vac_leavebal').val() === '0.0' && $('#emptype').val() === 'Regular') {
            $("#leavepay").show();
            $("#leave_pay2").prop("checked", true);
            $("#wpay").hide();
            $('#paternity').hide();
            $('#leavepay').show();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').show();
            $('#Submit').show();
        }else if ($(this).val() == 'Vacation Leave' && $('#vac_leavebal').val() !== '0.0' && $('#emptype').val() === 'Regular') {
            $("#leavepay").show();
            $("#leave_pay2").prop("checked", false);
            $("#wpay").show();
            $("#leave_pay1").prop("checked", true);
            $('#paternity').hide();
            $('#leavepay').show();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').show();
            $('#Submit').show();
        }else if ($(this).val() == 'Vacation Leave' && $('#emptype').val() === 'Probationary') {
            $("#leavepay").show();
            $("#leave_pay2").prop("checked", true);
            $("#wpay").hide();
            $('#paternity').hide();
            $('#leavepay').show();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#Submit').show();
        }else if ($(this).val() == 'Sick Leave' && $('#emptype').val() === 'Probationary') {
            $("#leavepay").show();
            $("#leave_pay2").prop("checked", true);
            $("#wpay").hide();
            $('#paternity').hide();
            $('#leavepay').show();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#Submit').show();
        }else if ($(this).val() == 'Paternity Leave' && $('#civilstatus').val() == 'Single') {
            $('#paternity').show();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#leavepay').hide();
            $('#Submit').hide();
        }else if ($(this).val() == 'Paternity Leave' && $('#civilstatus').val() == 'Married') {
            $('#paternity').show();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#leavepay').hide();
            $('#Submit').show();
        }else if ($(this).val() == 'Maternity Leave') {
            $('#paternity').hide();
            $('#advancefiling').hide();
            $('#maternity').show();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#leavepay').hide();
            $('#Submit').show();
        }else if ($(this).val() == 'Special Leave for Women') {
            $('#paternity').hide();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').show();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#leavepay').hide();
            $('#vacleavebal').hide();
            $('#Submit').show();
        }else if ($(this).val() == 'Special Leave for Victim of Violence') {
            $('#paternity').hide();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').show();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#leavepay').hide();
            $('#Submit').show();
        }else if ($(this).val() == 'Solo Parent Leave' || $(this).val() == 'Bereavement Leave') {
            $('#paternity').hide();
            $('#advancefiling').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').show();            
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#leavepay').hide();
            $('#Submit').show();
        } else {
            $('#advancefiling').hide();
            $('#paternity').hide();
            $('#maternity').hide();
            $('#specialwomen').hide();
            $('#specialviolence').hide();
            $('#soloparent').hide();
            $('#sickleavebal').hide();
            $('#vacleavebal').hide();
            $('#leavepay').hide();
        }
        
    });


    $('.advancesl').change(function(){
        if($('#advancesl:checked').val() ==='yes'){
            $('#Attachment').show();
        }else{
            $('#Attachment').hide();
        }
    });


            $('#dateTo').change(function(){

                if($('#dateTo').val() < $('#dateFrom').val()){

                    swal({text:"Leave date TO must be greater than Leave Date From!",icon:"error"});

                    var input2 = document.getElementById('dateTo');
                    input2.value = '';               

                }else{
                    // alert('Error');
                }   

            });


            $('#dateFrom').change(function(){

                    var input2 = document.getElementById('dateTo');
                    document.getElementById("dateTo").min = $('#dateFrom').val();
                    input2.value = '';

            });



        if($('#dateFrom').val() !== $('#dateTo').val()){
            $('#halfdayset').show();
            $('#singleHalf').hide();
        }else{
            $('#singleHalf').show();
            $('#halfdayset').hide();
        }
        $("#halfDay").prop("checked", false);
        
        param = {
            "Action":"GetNumberOfDays",
            "datefrom": $('#dateFrom').val(),
            "dateto": $('#dateTo').val()
        };
        
        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../leave/leaveApplicationProcess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                leaveCount = data;
            },
            error: function (data){
                console.log("error: "+ data);	
            }
        });//ajax
        
    });

    $('#halfDay').change(function(){

        if(this.checked){
            leaveCount = 0.5;
        }else{
            leaveCount = 1;
        }

        console.log(this.checked);
    });

    $('#lastDayHalfDay').change(function(){

        if(this.checked){
            $('#multiHalfDay').attr("disabled", true);
            leaveCount = leaveCount - 0.5;
        }else{
            $('#multiHalfDay').removeAttr("disabled");
            leaveCount = leaveCount + 0.5;
        }

        // console.log(leaveCount);
    });

    $('#multiHalfDay').change(function(){

        if(this.checked){
            $('#lastDayHalfDay').attr("disabled", true);
            leaveCount = leaveCount / 2;
            allhaftday = 2;
        }else{
            $('#lastDayHalfDay').removeAttr("disabled");
            leaveCount = leaveCount * 2;
        }

        // console.log(leaveCount);

    });

    $('#search').click(function(e){
        e.preventDefault();

        param = {"Action":"GetEmployeeList", "employee":$('#employeeSearch').val()};

        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../leave/leaveApprovalProcess.php",
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
