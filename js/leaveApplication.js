var pdfFile;

function GetMedFile() {
    var selectedfile = document.getElementById("medicalfiles").files;
    if (selectedfile.length > 0) {
        var uploadedFile = selectedfile[0];
        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var srcData = fileLoadedEvent.target.result;
            pdfFile =   srcData.replace('data:application/pdf;base64,', '');
        }
        fileReader.readAsDataURL(uploadedFile);
    }
}

$(function(){

    var empname='';
    var leaveCount = 0;
    var allhaftday = 1;

    $('#advancefiling').hide();
    $('#medicalFiles').hide();
    $('#halfdayset').hide();
    
    
    function LoadLeaveList(){

        param = {"Action":"GetLeaveListBlank"};

        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../controller/leaveApprovalProcess.php",
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

    LoadLeaveList();

    $(document).on('click','.btnApprove',function(e){

        var curID = $(this).attr('id').split("-");
        var curDateFrom = $(this).closest('tr').find('td:eq(1)').text();
        var curDateTo = $(this).closest('tr').find('td:eq(2)').text();
        var curLeaveType = $(this).closest('tr').find('td:eq(3)').text();
        var noOfDays = $(this).closest('tr').find('td:eq(4)').text();
        var curApproved = $(this).closest('tr').find("td:eq(5) input").val();
        var thisID = curID[0];

        param = {
            "Action":"ApproveLeave",
            'empName': empname,
            'curLeaveType': curLeaveType,
            "curApproved": curApproved,
            "curDateFrom": curDateFrom,
            "curDateTo": curDateTo,
            "noOfDays": noOfDays,
            "thisID": thisID
        };

        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../controller/leaveApprovalProcess.php",
            data: {data:param} ,
            success: function (data){
                console.log("success: "+ data);
                location.reload();
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax


    });

    $(document).on('click','.btnReject',function(e){

        var curID = $(this).attr('id').split("-");
        var curDateFrom = $(this).closest('tr').find('td:eq(1)').text();
        var curDateTo = $(this).closest('tr').find('td:eq(2)').text();
        var curLeaveType = $(this).closest('tr').find('td:eq(3)').text();
        var noOfDays = $(this).closest('tr').find('td:eq(4)').text();
        var curApproved = $(this).closest('tr').find("td:eq(5) input").val();
        var thisID = curID[0];

        // console.log(thisID +','+ curDateFrom +','+ curDateTo +','+ curLeaveType +','+ noOfDays +', '+ curApproved);

        param = {
            "Action":"RejectLeave",
            'empName': empname,
            'curLeaveType': curLeaveType,
            "curApproved": curApproved,
            "curDateFrom": curDateFrom,
            "curDateTo": curDateTo,
            "noOfDays": noOfDays,
            "thisID": thisID
        };
        
        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../controller/leaveApprovalProcess.php",
            data: {data:param} ,
            success: function (data){
                console.log("success: "+ data);
                location.reload();
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    });

    $(document).on('click','.btnView',function(e){

        var curID = $(this).attr('id').split("-");
        var thisID = curID[0];

        window.open('../controller/leaveApprovalPDF.php?data=' + thisID, '_blank');
        
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
            url: "../controller/leaveApprovalProcess.php",
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
    

    $('#applyLeave').click(function(e){
        e.preventDefault();
        $('#popUpModal').modal('toggle');
    });

    $('#Submit').click(function(){

        if($('#dateFrom').val() <= $('#dateTo').val()){

            console.log(leaveCount);

            param = {
                "Action":"ApplyLeave",
                "leavetype": $('#leaveType').val(),
                "datefrom": $('#dateFrom').val(),
                "dateto": $('#dateTo').val(),
                "leavedesc" : $('#leaveDesc').val(),
                "medicalfile": pdfFile,
                "leaveCount": leaveCount,
                "allhalfdayMark": allhaftday

            };
            
            param = JSON.stringify(param);
            
            $.ajax({
                type: "POST",
                url: "../controller/leaveApplicationProcess.php",
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

        }else{
            $('#errMsg').next().remove();
            $('#errMsg').after('<span class="text-danger">Must be greater than <b>From<b/> date. </span>')
        }
        
    });

    $('#leaveType').change(function(){

        if ($(this).val() == 'Sick Leave') {
            $('#advancefiling').show();
        } else {
            $('#advancefiling').hide();
        }
        
    });

    $('.advancesl').change(function(){
        if($('#advancesl:checked').val() ==='yes'){
            $('#medicalFiles').show();
        }else{
            $('#medicalFiles').hide();
        }
    });

    $('#dateTo').change(function(){

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
            url: "../controller/leaveApplicationProcess.php",
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

});
