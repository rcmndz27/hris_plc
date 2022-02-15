var selectedForm = 'Personal';
var applicant_code = '';
var picValue;
var idno;

function ImageEncode() {
    var selectedfile = document.getElementById("imgInput").files;
    if (selectedfile.length > 0) {
        var imageFile = selectedfile[0];
        var fileReader = new FileReader();
        fileReader.onload = function (fileLoadedEvent) {
            var srcData = fileLoadedEvent.target.result;
            picValue = srcData;
            // picValue = picValue.replace("data:image/jpeg;base64,", "");
            document.getElementById('imgPic').src = srcData;
        }
        fileReader.readAsDataURL(imageFile);
    }
}


$(function () {

    
    $('#spouseCredentials').hide();
    $('#spouseInfo').hide();
    $('#children').hide();
    $('#otherpositionholder').hide();
    $('#crimeDetails').removeClass("d-flex").addClass("d-none");
    $('#illnessDetails').removeClass("d-flex").addClass("d-none");


    function ViewPositionList() {
        param = {
            'Action': 'GetPositionList'
        };
        param = JSON.stringify(param);
        $.ajax({
            type: 'POST',
            url: 'applicantProfileProcess.php',
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
    } //ViewPositionList


    function ViewRelationshipList() {
        param = {
            'Action': 'GetRelationshipList'
        };
        param = JSON.stringify(param);
        $.ajax({
            type: 'POST',
            url: 'applicantProfileProcess.php',
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
                $('#relationshipList').html(options);
            },
            error: function (data) {
                // console.log('error: '+ data);	
            }
        }); //ajax
    } //ViewRelationshipList

    function GetApplicantNumber() {
        param = {
            'Action': 'GetApplicantNumber'
        };
        param = JSON.stringify(param);
        $.ajax({
            type: 'POST',
            url: 'applicantProfileProcess.php',
            data: {
                data: param
            },
            success: function (data) {
                // console.log('success: '+ data);
                applicant_code = data;
            },
            error: function (data) {
                // console.log('error: '+ data);
            }
        }); //ajax

    } //GetApplicantNumber

    function CheckInput() {

        var inputValues = [];

        switch (selectedForm) {
            case 'Family':
                inputValues = [
                    $('#contactPerson'),
                    $('#contactNumber'),
                    $('#contactAddress'),
                    $('#contactPerson1'),
                    $('#contactNumber1'),
                    $('#contactAddress1')
                ];
                break;
            case 'Education':
                break;
            case 'Job History':
                inputValues = [
                    
                    $('#employer1'),
                    $('#employerContanctNo1'),
                    $('#positionHeld1'),
                    $('#salary1'),
                    $('#monthsOfService1'),
                    $('#reasonForLeaving1'),

                    $('#refName1'),
                    $('#refContactNo1'),
                    $('#refEmail1'),
                    $('#refCompany1'),
                    $('#refPosition1'),

                    $('#refName2'),
                    $('#refContactNo2'),
                    $('#refEmail2'),
                    $('#refCompany2'),
                    $('#refPosition2'),

                    $('#refName3'),
                    $('#refContactNo3'),
                    $('#refEmail3'),
                    $('#refCompany3'),
                    $('#refPosition3')

                ];
                break;
            case 'Other Information':
                break;    
            default:
                inputValues = [
                    $('#positionList'),
                    $('#imgInput'),
                    $('#firstname'),
                    $('#middlename'),
                    $('#lastname'),
                    $('#gender'),
                    $('#bloodtype'),
                    $('#civilstatus'),
                    $('#birthday'),
                    $('#email'),
                    $('#cellphone'),
                    $('#otherCellphone'),
                    $('#presentAddress'),
                    $('#permanentAddress'),
                    $('#tin'),
                    $('#sss'),
                    $('#philhealth'),
                    $('#pagibig')
                ];
        }
        var result = (CheckInputValue(inputValues) === '0') ? true : false;
        return result;
    } //CheckPersonalInfo

    function ClearTabs(stats) {
        switch (selectedForm) {
            case 'Family':
                if (stats === '1') {

                    $('#mother').val('');
                    $('#motherAddress').val('');
                    $('#motherContact').val('');
                    $('#father').val('');
                    $('#fatherAddress').val('');
                    $('#fatherContact').val('');
                    $('#spouse').val('');
                    $('#spouseBirthdate').val('');
                    $('#spouseOccupation').val('');
                    $('#spouseTIN').val('');
                    $('#spouseSSS').val('');
                    $('#child1').val('');
                    $('#child1Birthdate').val('');
                    $('#child1Gender').val('');
                    $('#child2').val('');
                    $('#child2Birthdate').val('');
                    $('#child2Gender').val('');
                    $('#child3').val('');
                    $('#child3Birthdate').val('');
                    $('#child3Gender').val('');
                    $('#child4').val('');
                    $('#child4Birthdate').val('');
                    $('#child4Gender').val('');
                    $('#child5').val('');
                    $('#child5Birthdate').val('');
                    $('#child5Gender').val('');
                    $('#contactPerson').val('');
                    $('#contactNumber').val('');
                    $('#contactAddress').val('');

                    $('#contactPerson1').val('');
                    $('#contactNumber1').val('');
                    $('#contactAddress1').val('');

                    $('#companyPersonel').val('');
                    $('#companyPersonelRelationship').val('');

                    $('#education-tab').addClass('active');
                    $('#education').addClass('active show');
                    
                    $('#family-tab').removeClass('active');
                    $('#family').removeClass('active show');

                    selectedForm = 'Education';

                    $('#popUpModal').modal('toggle');
                }
                break;
            case 'Education':
                if (stats === '1') {
                    $('#elementary').val('');
                    $('#elementaryDate').val('');
                    $('#highschool').val('');
                    $('#highschoolDate').val('');
                    $('#college').val('');
                    $('#collegeCourse').val('');
                    $('#collegeDate').val('');
                    $('#higherstudies').val('');
                    $('#higherstudiesCourse').val('');
                    $('#higherstudiesDate').val('');

                    $('#job-tab').addClass('active');
                    $('#job').addClass('active show');

                    $('#education-tab').removeClass('active');
                    $('#education').removeClass('active show');

                    selectedForm = 'Job History';

                    $('#popUpModal').modal('toggle');
                }
                break;
            case 'Job History':
                if (stats === '1') {
                    $('#employer1').val('');
                    $('#employerContanctNo1').val('');
                    $('#positionHeld1').val('');
                    $('#salary1').val('');
                    $('#monthsOfService1').val('');
                    $('#reasonForLeaving1').val('');

                    $('#employer2').val('');
                    $('#employerContanctNo2').val('');
                    $('#positionHeld2').val('');
                    $('#salary2').val('');
                    $('#monthsOfService2').val('');
                    $('#reasonForLeaving2').val('');

                    $('#employer3').val('');
                    $('#employerContanctNo3').val('');
                    $('#positionHeld3').val('');
                    $('#salary3').val('');
                    $('#monthsOfService3').val('');
                    $('#reasonForLeaving3').val('');

                    $('#refName1').val('');
                    $('#refContactNo1').val('');
                    $('#refEmail1').val('');
                    $('#refCompany1').val('');
                    $('#refPosition1').val('');

                    $('#refName2').val('');
                    $('#refContactNo2').val('');
                    $('#refEmail2').val('');
                    $('#refCompany2').val('');
                    $('#refPosition2').val('');

                    $('#refName3').val('');
                    $('#refContactNo3').val('');
                    $('#refEmail3').val('');
                    $('#refCompany3').val('');
                    $('#refPosition3').val('');

                    $('#others-tab').addClass('active');
                    $('#others').addClass('active show');

                    $('#job-tab').removeClass('active');
                    $('#job').removeClass('active show');

                    selectedForm = 'Other Information';

                    $('#popUpModal').modal('toggle');
                }
            break;
            case 'Other Information':
                if (stats === '1') {

                    $('#skillset').val('');
                    $('#convictedToCrimes').val('');
                    $('#crime').val('');
                    $('#hospitalized').val('');
                    $('#illness').val('');
                    $('#explanationText').val('');
                    
                    // $('#popUpModal').modal('toggle');

                    window.open('pdf_generator.php?data=' + applicant_code, '_blank');
                    location.reload();
                }
                break;
            default:
                if (stats === '1') {
                    ViewPositionList();
                    $('#otherPosition').val('');
                    $('#firstname').val('');
                    $('#middlename').val('');
                    $('#lastname').val('');
                    $('#suffix').val('');
                    $('#gender').val('');
                    $('#bloodtype').val('');
                    $('#civilstatus').val('');
                    $('#birthday').val('');
                    $('#email').val('');
                    $('#telephone').val('');
                    $('#cellphone').val('');
                    $('#otherCellphone').val('');
                    $('#presentAddress').val('');
                    $('#permanentAddress').val('');
                    $('#tin').val('');
                    $('#sss').val('');
                    $('#philhealth').val('');
                    $('#pagibig').val('');
                    $('#prclicense').val('');
                    $('#prcexpirydate').val('');
                    $('#driverslicense').val('');
                    $('#driversexpirydate').val('');

                    $('#personal-tab').removeClass('active');
                    $('#personal').removeClass('active show');

                    $('#family-tab').addClass('active');
                    $('#family').addClass('active show');

                    selectedForm = 'Family';

                    $('#popUpModal').modal('toggle');

                } // if
        } // switch
    } // ClearTabs

    function GetGovernmentIdDuplicate(idno,idtype){
        $('#'.idtype).after('');
        param = {
            'Action': 'GetGovernmentIdDuplicate',
            'idtype': idtype,
            'idno': idno
        };

        param = JSON.stringify(param);
        $.ajax({
            type: 'POST',
            url: 'applicantProfileProcess.php',
            data: {
                data: param
            },
            success: function (data) {
                // console.log('success:'+ data);

                var retData = JSON.parse(data);

                if(retData[0].result === '1'){
                    switch(retData[0].idtype){
                        case 'tin':
                            $('#tin').next($('.errmsg')).remove();
                            $('#tin').after('<span class="errmsg">Already been used</span>');
                            $('#tin').addClass('error');
                        break;
                        case 'sss':
                            $('#sss').next($('.errmsg')).remove();
                            $('#sss').after('<span class="errmsg">Already been used</span>');
                            $('#sss').addClass('error');
                        break;
                        case 'philhealth':
                            $('#philhealth').next($('.errmsg')).remove();
                            $('#philhealth').after('<span class="errmsg">Already been used</span>');
                            $('#philhealth').addClass('error');
                        break;
                        case 'pagibig':
                            $('#pagibig').next($('.errmsg')).remove();
                            $('#pagibig').after('<span class="errmsg">Already been used</span>');
                            $('#pagibig').addClass('error');
                        break;
                    }
                }else{
                    switch(retData[0].idtype){
                        case 'tin':
                            $('#tin').removeClass('error');
                        break;
                        case 'sss':
                            $('#tin').removeClass('error');
                        break;
                        case 'philhealth':
                            $('#philhealth').removeClass('error');
                        break;
                        case 'pagibig':
                            $('#pagibig').removeClass('error');
                        break;
                    }  
                }

            },
            error: function (data) {
                // console.log('error: '+ data);	
            }
        }); //ajax
    } //GetGovernmentIdDuplicate

    ViewPositionList();
    ViewRelationshipList();

    GetApplicantNumber();

   

    $('#submit').click(function (e) {
        e.preventDefault();
        $('#popUpModal').modal('toggle');
        // console.log(picValue);
    });

    $('#OK').click(function (e) {

        e.preventDefault();

        if (CheckInput() === true) {
            switch (selectedForm) {
                case 'Family':
                    param = {
                        'Action': 'Insert',
                        'ActiveForm': 'Family',
                        'applicantcode': applicant_code,
                        'civilstatus': $('#civilstatus').val(),
                        'mother': $('#mother').val(),
                        'motherAddress': $('#motherAddress').val(),
                        'motherContact': $('#motherContact').val(),
                        'father': $('#father').val(),
                        'fatherAddress': $('#fatherAddress').val(),
                        'fatherContact': $('#fatherContact').val(),
                        'spouse': $('#spouse').val(),
                        'spouseBirthdate': $('#spouseBirthdate').val(),
                        'spouseOccupation': $('#spouseOccupation').val(),
                        'spouseTIN': $('#spouseTIN').val(),
                        'spouseSSS': $('#spouseSSS').val(),
                        'child1': $('#child1').val(),
                        'child1Birthdate': $('#child1Birthdate').val(),
                        'child1Gender': $('#child1Gender').val(),
                        'child2': $('#child2').val(),
                        'child2Birthdate': $('#child2Birthdate').val(),
                        'child2Gender': $('#child2Gender').val(),
                        'child3': $('#child3').val(),
                        'child3Birthdate': $('#child3Birthdate').val(),
                        'child3Gender': $('#child3Gender').val(),
                        'child4': $('#child4').val(),
                        'child4Birthdate': $('#child4Birthdate').val(),
                        'child4Gender': $('#child4Gender').val(),
                        'child5': $('#child5').val(),
                        'child5Birthdate': $('#child5Birthdate').val(),
                        'child5Gender': $('#child5Gender').val(),

                        'contactPerson': $('#contactPerson').val(),
                        'contactNumber': parseInt($('#contactNumber').val()),
                        'contactAddress': $('#contactAddress').val(),

                        'contactPerson1': $('#contactPerson1').val(),
                        'contactNumber1': parseInt($('#contactNumber1').val()),
                        'contactAddress1': $('#contactAddress1').val(),

                        'companyPersonel': $('#companyPersonel').val(),
                        'companyPersonelRelationship': $('#companyPersonelRelationship').val()
                    };
                    break;
                case 'Education':
                    param = {
                        'Action': 'Insert',
                        'ActiveForm': 'Education',
                        'applicantcode': applicant_code,
                        'elementary': $('#elementary').val(),
                        'elementaryDate': $('#elementaryDate').val(),
                        'highschool': $('#highschool').val(),
                        'highschoolDate': $('#highschoolDate').val(),
                        'college': $('#college').val(),
                        'course': $('#collegeCourse').val(),
                        'collegeDate': $('#collegeDate').val(),
                        'higherstudies': $('#higherstudies').val(),
                        'higherstudiesCourse': $('#higherstudiesCourse').val(),
                        'higherstudiesDate': $('#higherstudiesDate').val()
                    };
                    break;
                case 'Job History':
                    param = {
                        'Action': 'Insert',
                        'ActiveForm': 'JobHistory',
                        'applicantcode': applicant_code,

                        'employer1': $('#employer1').val(),
                        'employerContanctNo1': $('#employerContanctNo1').val(),
                        'positionHeld1': $('#positionHeld1').val(),
                        'salary1': parseInt($('#salary1').val()),
                        'monthsOfService1': parseInt($('#monthsOfService1').val()),
                        'reasonForLeaving1': $('#reasonForLeaving1').val(),

                        'employer2': $('#employer2').val(),
                        'employerContanctNo2': $('#employerContanctNo2').val(),
                        'positionHeld2': $('#positionHeld2').val(),
                        'salary2': parseInt($('#salary2').val()),
                        'monthsOfService2': parseInt($('#monthsOfService2').val()),
                        'reasonForLeaving2': $('#reasonForLeaving2').val(),

                        'employer3': $('#employer3').val(),
                        'employerContanctNo3': $('#employerContanctNo3').val(),
                        'positionHeld3': $('#positionHeld3').val(),
                        'salary3': parseInt($('#salary3').val()),
                        'monthsOfService3': parseInt($('#monthsOfService3').val()),
                        'reasonForLeaving3': $('#reasonForLeaving3').val(),

                        'refName1': $('#refName1').val(),
                        'refContactNo1': $('#refContactNo1').val(),
                        'refEmail1': $('#refEmail1').val(),
                        'refCompany1': $('#refCompany1').val(),
                        'refPosition1': $('#refPosition1').val(),

                        'refName2': $('#refName2').val(),
                        'refContactNo2': $('#refContactNo2').val(),
                        'refEmail2': $('#refEmail2').val(),
                        'refCompany2': $('#refCompany2').val(),
                        'refPosition2': $('#refPosition2').val(),

                        'refName3': $('#refName3').val(),
                        'refContactNo3': $('#refContactNo3').val(),
                        'refEmail3': $('#refEmail3').val(),
                        'refCompany3': $('#refCompany3').val(),
                        'refPosition3': $('#refPosition3').val()

                    };
                    break;
                case 'Other Information':
                    param = {
                        'Action': 'Insert',
                        'ActiveForm': 'Others',
                        'applicantcode': applicant_code,
                        
                        'skillset': $('#skillset').val(),
                        'convictedtocrimes': $('#convictedToCrimes').val(),
                        'crime': $('#crime').val(),
                        'hospitalized': $('#hospitalized').val(),
                        'illness': $('#illness').val(),
                        'explanation': $('#explanationText').val()
                    };
                    break;
                default:
                    param = {
                        'Action': 'Insert',
                        'ActiveForm': 'Personal',
                        'applicantcode': applicant_code,
                        'position': $('#positionList option:selected').text(),
                        'otherposition': $('#otherPosition').val(),
                        'firstname': $('#firstname').val(),
                        'middlename': $('#middlename').val(),
                        'lastname': $('#lastname').val(),
                        'suffix': $('#suffix').val(),
                        'gender': $('#gender').val(),
                        'bloodtype': $('#bloodtype').val(),
                        'civilstatus': $('#civilstatus').val(),
                        'birthday': $('#birthday').val(),
                        'email': $('#email').val(),
                        'telephone': parseInt($('#telephone').val()),
                        'cellphone': parseInt($('#cellphone').val()),
                        'othercellphone': parseInt($('#otherCellphone').val()),
                        'presentaddress': $('#presentAddress').val(),
                        'permanentaddress': $('#permanentAddress').val(),
                        'tin': $('#tin').val(),
                        'sss': $('#sss').val(),
                        'philhealth': $('#philhealth').val(),
                        'pagibig': $('#pagibig').val(),
                        'prclicense': $('#prclicense').val(),
                        'prcexpirydate': $('#prcexpirydate').val(),
                        'driverslicense': $('#driverslicense').val(),
                        'driversexpirydate': $('#driversexpirydate').val(),
                        'applicantpic': picValue

                    };
            } //switch

            param = JSON.stringify(param);
            $.ajax({
                type: 'POST',
                url: 'applicantProfileProcess.php',
                data: {
                    data: param
                },
                success: function (result) {
                    console.log('success: ' + result);
                    ClearTabs(result);
                },
                error: function (result) {
                    // console.log('error: ' + result);
                }
            }); //ajax

        }
    });

    $('#setpermanentaddress').change(function (e) {
        e.preventDefault();
        if (this.checked) {
            $('#permanentAddress').val($('#presentAddress').val());
        } else {
            $('#permanentAddress').val('');
        }
    });

    $('#civilstatus').change(function (e) {
        e.preventDefault();
        if ($(this).val() !== 'Single') {
            $('#spouseInfo').show();
            $('#children').show();
        } else {
            $('#spouseInfo').hide();
            $('#children').hide();
        }
    });

    $('#myTab li a').click(function (e) {
        e.preventDefault();
        selectedForm = $(this).text();
    });

    $('#positionList').change(function (e) {
        e.preventDefault();
        if ($(this).val() == 'Others') {
            $('#otherpositionholder').show();
        } else {
            $('#otherpositionholder').hide();
        }
    });

    $('.convictedToCrimes').change(function(){
        if($('#convictedToCrimes:checked').val() ==='yes'){
            $('#crimeDetails').addClass("d-flex").removeClass("d-none");
            $('#convictedToCrimes').val('yes');
        }else{
            $('#crimeDetails').removeClass("d-flex").addClass("d-none");
            $('#convictedToCrimes').val('no');
        }
    });

    $('.hospitalized').change(function(){
        if($('#hospitalized:checked').val() ==='yes'){
            $('#illnessDetails').addClass("d-flex").removeClass("d-none");
            $('#hospitalized').val('yes');
        }else{
            $('#illnessDetails').removeClass("d-flex").addClass("d-none");
            $('#hospitalized').val('no');
        }
    });

    $('#tin').change(function(){
        GetGovernmentIdDuplicate($(this).val(),'tin');
    }); //tin

    $('#sss').change(function(){
        GetGovernmentIdDuplicate($(this).val(),'sss');
    }); //sss

    $('#philhealth').change(function(){
        GetGovernmentIdDuplicate($(this).val(),'philhealth');
    }); //philhealth

    $('#pagibig').change(function(){
        GetGovernmentIdDuplicate($(this).val(),'pagibig');
    }); //pagibig

    $('#firstjob').change(function(){
        
        if (this.checked) {
            $('#tin').val('000-000-000');
            $('#sss').val('00-0000000-0');
            $('#philhealth').val('00-000000000-0');
            $('#pagibig').val('0000-0000-0000');
        } else {
            $('#tin').val('');
            $('#sss').val('');
            $('#philhealth').val('');
            $('#pagibig').val('');
        }
        
    });

    $('#relationshipList').change(function(e){
        
        e.preventDefault();

        if ($(this).val() === '2') {

            $('#spouseCredentials').show();

        } else {

            $('#spouseCredentials').hide();
        }

    });


});