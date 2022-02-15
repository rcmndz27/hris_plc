var applicantid;

$('#search').click(function(e){
    e.preventDefault();

    param = {
        "Action":"ViewApplicantList",
        "keyword":$('#keyword').val()
    };
    
    param = JSON.stringify(param);
    
    $.ajax({
        type: "POST",
        url: "../controller/applicantapprovalprocess.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            $('#applicantList').remove();

            $('#applicantTable').html(data);
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });//ajax
    
});

function ViewCompanyList(){
    param = {"Action":"GetCompanyList"};
    param = JSON.stringify(param);
    $.ajax({
        type: "POST",
        url: "../controller/applicantapprovalprocess.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            var companyListArr = JSON.parse(data);
            var options = '';
            for (var x = 0; x < companyListArr.length; x++){
                options += '<option value="' + companyListArr[x]['code'] + '">' + companyListArr[x]['desc'] + '</option>';
            }
            $('#companylist').html(options); 
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });//ajax
}//ViewCompanyList

function ViewEmployeeTypeList(){
    param = {"Action":"GetEmployeeTypeList"};
    param = JSON.stringify(param);
    $.ajax({
        type: "POST",
        url: "../controller/applicantapprovalprocess.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            var employeeTypeListArr = JSON.parse(data);
            var options = '';
            for (var x = 0; x < employeeTypeListArr.length; x++){
                options += '<option value="' + employeeTypeListArr[x]['code'] + '">' + employeeTypeListArr[x]['desc'] + '</option>';
            }
            $('#employeetypelist').html(options); 
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });//ajax
}//ViewEmployeeTypeList

function ViewLocationList(){
    param = {"Action":"GetLocationList"};
    param = JSON.stringify(param);
    $.ajax({
        type: "POST",
        url: "../controller/applicantapprovalprocess.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            var locationListArr = JSON.parse(data);
            var options = '';
            for (var x = 0; x < locationListArr.length; x++){
                options += '<option value="' + locationListArr[x]['code'] + '">' + locationListArr[x]['desc'] + '</option>';
            }
            $('#locationlist').html(options); 
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });//ajax
}//ViewLocationList

function ViewDepartmentList(){
    param = {"Action":"GetDepartmentList"};
    param = JSON.stringify(param);
    $.ajax({
        type: "POST",
        url: "../controller/applicantapprovalprocess.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            var departmentListArr = JSON.parse(data);
            var options = '';
            for (var x = 0; x < departmentListArr.length; x++){
                options += '<option value="' + departmentListArr[x]['code'] + '">' + departmentListArr[x]['desc'] + '</option>';
            }
            $('#departmentlist').html(options); 
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });//ajax
}//ViewDepartmentList


ViewCompanyList();
ViewEmployeeTypeList();
ViewLocationList();
ViewDepartmentList();

$(document).on('click','.btnView',function(e){
    e.preventDefault();

    applicantid = $(this).closest('tr').find('td:eq(0)').text();

    param = {
        "Action":"ViewApplicantInfo",
        "applicantid": applicantid
    };
    
    param = JSON.stringify(param);
    
    $.ajax({
        type: "POST",
        url: "../controller/applicantapprovalprocess.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            $('#applicantinfo').remove();
            $('.viewerModal').append(data);
            $('#informationModal').modal('toggle');
            $("#informationModalTitle").text("Applicant Information : "+applicantid);

        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });//ajax

    


});

$(document).on('click','.btnApprove',function(e){
    e.preventDefault();
    applicantid = $(this).closest('tr').find('td:eq(0)').text();

    $('#hire').show();
    $('#reject').hide();
    $('#formModal').modal('toggle');
    $("#formModalTitle").text("Hiring Information : "+applicantid);

});

$(document).on('click','.btnReject',function(e){
    e.preventDefault();

    applicantid = $(this).closest('tr').find('td:eq(0)').text();

    $('#hire').hide();
    $('#reject').show();
    $('#formModal').modal('toggle');

});

$('#formModalSubmit').click(function(e){
    e.preventDefault();

    if($('#hire').is(':visible')){
        param = {
            "Action":"HireApplicant",
            "applicantid":applicantid,
            "companyid":$('#companylist').val(),
            "employeecode":$('#employeecode').val(),
            "datehired":$('#datehired').val(),
            "employeetypelist":$('#employeetypelist').val(),
            "locationlist":$('#locationlist').val(),
            "departmentlist":$('#departmentlist').val()
        };
    }
    else{
        param = {
            "Action":"RejectApplicant",
            "applicantid":applicantid,
            "reason":$('#reason').val()
        };
    }
    
    param = JSON.stringify(param);
    
    $.ajax({
        type: "POST",
        url: "../controller/applicantapprovalprocess.php",
        data: {data:param} ,
        success: function (data){
            console.log("success: "+ data);
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });//ajax

});





