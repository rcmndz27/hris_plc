
function GetCompanyList(){
    param = {"Action":"GetCompanyList"};
    param = JSON.stringify(param);
    $.ajax({
        type: "POST",
        url: "../admin_tool/newhire-access-process.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            var companyListArr = JSON.parse(data);
            var options = '';
            options += "<option value=''</option>";
            for (var x = 0; x < companyListArr.length; x++){
                options += '<option value="' + companyListArr[x]['code'] + '">' + companyListArr[x]['desc'] + '</option>';
            }
            $('#companylist').html(options); 
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });
}

function GetLocationList(){
    param = {"Action":"GetLocationList"};
    param = JSON.stringify(param);
    $.ajax({
        type: "POST",
        url: "../admin_tool/newhire-access-process.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            var locationListArr = JSON.parse(data);
            var options = '';
            options += "<option value=''</option>";
            for (var x = 0; x < locationListArr.length; x++){
                options += '<option value="' + locationListArr[x]['code'] + '">' + locationListArr[x]['desc'] + '</option>';
            }
            $('#locationlist').html(options); 
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });
}

function GetDepartmentList(){
    param = {"Action":"GetDepartmentList"};
    param = JSON.stringify(param);
    $.ajax({
        type: "POST",
        url: "../admin_tool/newhire-access-process.php",
        data: {data:param} ,
        success: function (data){
            // console.log("success: "+ data);
            var departmentListArr = JSON.parse(data);
            var options = '';
            options += "<option value=''</option>";
            for (var x = 0; x < departmentListArr.length; x++){
                options += '<option value="' + departmentListArr[x]['code'] + '">' + departmentListArr[x]['desc'] + '</option>';
            }
            $('#departmentlist').html(options); 
        },
        error: function (data){
            // console.log("error: "+ data);	
        }
    });
}

function GetPositionList() {
    param = {
        'Action': 'GetPositionList'
    };
    param = JSON.stringify(param);
    $.ajax({
        type: 'POST',
        url: "../admin_tool/newhire-access-process.php",
        data: {
            data: param
        },
        success: function (data) {
            // console.log('success: '+ data);
            var positionListArr = JSON.parse(data);
            var options = '';
            options += "<option value=''</option>";
            options += "<option value='Others'>Others</option>";
            $.each(positionListArr, function (key, value) {
                
                options += '<option value=' + value['code'] + '>' + value['desc'] + '</option>';
            });
            $('#positionList').html(options);
            
        },
        error: function (data) {
            // console.log('error: '+ data);	
        }
    }); //ajax
}

function GetEmployeeTypeList() {
    param = {
        'Action': 'GetEmployeeTypeList'
    };
    param = JSON.stringify(param);
    $.ajax({
        type: 'POST',
        url: "../admin_tool/newhire-access-process.php",
        data: {
            data: param
        },
        success: function (data) {
            // console.log('success: '+ data);
            var positionListArr = JSON.parse(data);
            var options = '';
            options += "<option value=''</option>";
            
            $.each(positionListArr, function (key, value) {
                
                options += '<option value=' + value['code'] + '>' + value['desc'] + '</option>';
            });
            $('#employeetypelist').html(options);
            
        },
        error: function (data) {
            // console.log('error: '+ data);	
        }
    }); //ajax
}

function GetEmployeeReportingToList() {
    param = {
        'Action': 'GetEmployeeReportingToList'
    };
    param = JSON.stringify(param);
    $.ajax({
        type: 'POST',
        url: "../admin_tool/newhire-access-process.php",
        data: {
            data: param
        },
        success: function (data) {
            // console.log('success: '+ data);
            var employeeReportingToListArr = JSON.parse(data);
            var options = '';
            options += "<option value=''</option>";
            
            $.each(employeeReportingToListArr, function (key, value) {
                
                options += '<option value=' + value['code'] + '>' + value['desc'] + '</option>';
            });
            $('#employeereportingtolist').html(options);
            
        },
        error: function (data) {
            // console.log('error: '+ data);	
        }
    }); //ajax
}

function GetEmployeeTypeList() {
    param = {
        'Action': 'GetEmployeeTypeList'
    };
    param = JSON.stringify(param);
    $.ajax({
        type: 'POST',
        url: "../admin_tool/newhire-access-process.php",
        data: {
            data: param
        },
        success: function (data) {
            // console.log('success: '+ data);
            var positionListArr = JSON.parse(data);
            var options = '';
            options += "<option value=''</option>";
            
            $.each(positionListArr, function (key, value) {
                
                options += '<option value=' + value['code'] + '>' + value['desc'] + '</option>';
            });
            $('#employeetypelist').html(options);
            
        },
        error: function (data) {
            // console.log('error: '+ data);	
        }
    }); //ajax
}

function GetEmployeeLevelList() {
    param = {
        'Action': 'GetEmployeeLevelList'
    };
    param = JSON.stringify(param);
    $.ajax({
        type: 'POST',
        url: "../admin_tool/newhire-access-process.php",
        data: {
            data: param
        },
        success: function (data) {
            // console.log('success: '+ data);
            var employeeLevelListArr = JSON.parse(data);
            var options = '';
            options += "<option value=''</option>";
            
            $.each(employeeLevelListArr, function (key, value) {
                
                options += '<option value=' + value['code'] + '>' + value['desc'] + '</option>';
            });
            $('#levellist').html(options);
            
        },
        error: function (data) {
            // console.log('error: '+ data);	
        }
    }); //ajax
}

GetCompanyList();
GetDepartmentList();
GetLocationList();
GetPositionList();
GetEmployeeTypeList();
GetEmployeeReportingToList();
GetEmployeeLevelList();

$('#otherpositionholder').hide();

$('#positionList').change(function (e) {
    e.preventDefault();
    if ($(this).val() == 'Others') {
        $('#otherpositionholder').show();
    } else {
        $('#otherpositionholder').hide();
    }
});

function CheckInput(){

    var inputValues = [];

    inputValues = [
        $('#employeecode'),
        $('#firstname'),
        $('#middlename'),
        $('#lastname'),
        $('#companylist'),
        $('#locationlist'),
        $('#departmentlist'),
        $('#positionList'),
        $('#employeetypelist'),
        $('#employeereportingtolist'),
        $('#levellist')
    ];

    var result = (CheckInputValue(inputValues) === '0') ? true : false;
    return result;
}

$('#submit').click(function(){

    if (CheckInput() === true) {

        param = {
            'Action': 'AddNewHire',
            'employeecode': $('#employeecode').val(),
            'firstname': $('#firstname').val(),
            'middlename': $('#middlename').val(),
            'lastname': $('#lastname').val(),
            'companylist': $( "#companylist option:selected" ).val(),
            'locationlist': $( "#locationlist option:selected" ).text(),
            'departmentlist': $( "#departmentlist option:selected" ).text(),
            'positionList': $( "#positionList option:selected" ).text(),
            'otherposition': $('#otherposition').val(),
            'employeetypelist': $( "#employeetypelist option:selected" ).text(),
            'employeereportingtolist': $( "#employeereportingtolist option:selected" ).val(),
            'datehired':$( "#datehired" ).val(),
            'levellist':$( "#levellist option:selected" ).text()
        }

        param = JSON.stringify(param);
        $.ajax({
            type: 'POST',
            url: 'newhire-access-process.php',
            data: {
                data: param
            },
            success: function (result) {
                console.log('success: ' + result);
                location.reload();
            },
            error: function (result) {
                // console.log('error: ' + result);
            }
        }); //ajax
    }
});







