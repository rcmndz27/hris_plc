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
        // dateTo = $(this).closest('tr').find('td:eq(2)').text();
        leaveType = $(this).closest('tr').find('td:eq(2)').text();
        // approver = $(this).closest('tr').find('td:eq(5)').text();
        approvedDays = $(this).closest('tr').find("td:eq(6) input").val();

        var approver =  $('#apr'+rowid).val();
        var apvL =  $('#apc'+rowid).val();
        var fillv = $('#alertleave').val();
        var upfillv = fillv-apvL;

        // console.log(approver);
        // console.log(apvL);
        // console.log(fillv);
        // console.log(upfillv);
        // return false;

        param = {
            "Action":"ApproveLeave",
            'employee': empId,
            'curLeaveType': leaveType,
            "curApproved": apvL,
            "curDateFrom": dateFrom,
            "curDateTo": dateFrom,
            "approver": approver,
            "empcode": empcode,
            "rowid": rowid
        };

  
        param = JSON.stringify(param);


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
                                                    swal({
                                                    title: "Approved!", 
                                                    text: "Successfully approved leave!", 
                                                    type: "success",
                                                    icon: "success",
                                                    }).then(function() {
                                                        document.getElementById(empcode).innerHTML = upfillv;
                                                        document.getElementById('alertleave').value = upfillv;
                                                        document.querySelector('#clv'+rowid).remove();
                                                    });
                                            },
                                            error: function (data){
                                                console.log("error: "+ data);    
                                            }
                                        });
                          } else {
                            swal({text:"Your cancel the approval of leave!",icon:"error"});
                          }
                        });
        


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


    $(document).on('click','.btnRejectd',function(e){


        empId = this.id;
        rowid = $('.btnRejectd').val();
        empcode = $('#empcode').val();
        dateFrom = $(this).closest('tr').find('td:eq(1)').text();
        dateTo = $(this).closest('tr').find('td:eq(1)').text();
        leaveType = $(this).closest('tr').find('td:eq(2)').text();
        // rejecter = $(this).closest('tr').find('td:eq(5)').text();
        rejecteddDays = $(this).closest('tr').find("td:eq(6) input").val();

        $('#remarksModal').modal('toggle');

        btnAccessed = 'Reject';
    

    });


    $('.btnRemarks').click(function(e){
        e.preventDefault();

        $('#remarksModal').modal('toggle');

        var rejecter =  $('#apr'+rowid).val();
        var apvL =  $('#apc'+rowid).val();
        var fillv = $('#alertleave').val();
        var upfillv = fillv-apvL;

        if(btnAccessed === "Reject"){

            param = {
                "Action":"RejectLeave",
                'curLeaveType': leaveType,
                "curRejected": apvL,
                "curDateFrom": dateFrom,
                "curDateTo": dateTo,
                "employee": empId,
                "rowid": rowid,
                "rejecter": rejecter,
                "empcode": empcode,
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

                          swal({
                          title: "Are you sure?",
                          text: "You want to reject this leave?",
                          icon: "warning",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((rejectLeave) => {
                          if (rejectLeave) {

                                        $.ajax({
                                            type: "POST",
                                            url: "../leave/leaveApprovalProcess.php",
                                            data: {data:param} ,
                                            success: function (data){
                                                 console.log("success: "+ data); 
                                                    swal({
                                                    title: "Rejected!", 
                                                    text: "Successfully rejected leave!", 
                                                    type: "success",
                                                    icon: "success",
                                                    }).then(function() {
                                                        $('#remarksModal').modal('hide');
                                                        $('#remarksModal').on('hidden.bs.modal', function (e) {
                                                          $(this)
                                                            .find("input,textarea,select")
                                                               .val('')
                                                               .end()
                                                            .find("input[type=checkbox], input[type=radio]")
                                                               .prop("checked", "")
                                                               .end();
                                                        })                     
                                                        document.getElementById(empcode).innerHTML = upfillv;
                                                        document.getElementById('alertleave').value = upfillv;
                                                        document.querySelector('#clv'+rowid).remove();
                                                    });
                                            },
                                            error: function (data){
                                                // console.log("error: "+ data);    
                                            }
                                        });//ajax
                          } else {
                             swal({text:"You cancel the rejection !",icon:"error"});
                          }
                        });
        

    });
       

    $('#applyLeave').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');

            $("#Attachment").hide();
            $("#LabelAttachment").hide();
            $("#medicalfiles").hide();
            $("#AddAttachment").show();
            
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

                  var checkBox = document.getElementById("halfDay");
                  if (checkBox.checked == true){
                    leaveCount = 0.5;
                  } else {
                     leaveCount = 1.0;
                  }
                  
                var dte = $('#dateFrom').val();
                var dte_to = $('#dateTo').val();
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      
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
                    "Action":"ApplyLeave",
                    "leavetype": leave_pay,
                    "datebirth": $('#dateBirth').val(),
                    "datestartmaternity": $('#dateStartMaternity').val(),
                    "leaveDate": ite_date,
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
                                            // console.log("success: "+ data);
                                                    swal({
                                                    title: "Wow!", 
                                                    text: "Successfully added leave details!", 
                                                    type: "success",
                                                    icon: "success",
                                                    }).then(function() {
                                                        location.href = '../leave/leaveApplication_view.php';
                                                    });
                                        },
                                        error: function (data){
                                            // console.log("error: "+ data);    
                                        }
                                    });//ajax
                          } else {
                            swal({text:"Your cancel your leave!",icon:"error"});
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
