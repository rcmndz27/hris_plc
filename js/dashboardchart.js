function ViewChart(ctx,data,charttype){
    var ctx = new Chart(ctx, {
        type: charttype,
        data: JSON.parse(data),
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
}

$(function(){

    var location = '';

    function ViewLocationList(){
        param = {"Action":"GetLocationList"};
        param = JSON.stringify(param);
        $.ajax({
            type: "POST",
            url: "../controller/dashboardprocess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                var locationListArr = JSON.parse(data);
                var options = '';
                for (var x = 0; x < locationListArr.length; x++){
                    options += '<option value="' + locationListArr[x]['code'] + '">' + locationListArr[x]['desc'] + '</option>';
                }
                $('#locationlist').html(options); 
                $('#locationlist').prepend("<option value=''></option>").val('');
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });//ajax
    }//ViewLocationList

    function GetPopulationCount() {

        $('#population').empty();
        $('#population').html('<canvas id="dash1"  width="400" height="150"></canvas>');

        var bar = document.getElementById('dash1').getContext('2d');

        // console.log(location);

        param = {'Action': 'GetPopulation', 'location' : location};

        param = JSON.stringify(param);
        $.ajax({
            type: 'POST',
            url: '../controller/dashboardprocess.php',
            data: {
                data: param
            },
            success: function (data) {
                // console.log('success: '+ data);
                ViewChart(bar,data,'bar');
            },
            error: function (data) {
                // console.log('error: '+ data);	
            }
        }); //ajax

    } //GetPopulation

    function GetAgeCount() {

        $('#age').empty();
        $('#age').html('<canvas id="dash2" width="400" height="200"></canvas>');
        var line = document.getElementById('dash2').getContext('2d');

        param = {'Action': 'GetAgeCount', 'location' : location};

        param = JSON.stringify(param);
        $.ajax({
            type: 'POST',
            url: '../controller/dashboardprocess.php',
            data: {
                data: param
            },
            success: function (data) {
                // console.log('success: '+ data);
                ViewChart(line,data,'line');
                
            },
            error: function (data) {
                // console.log('error: '+ data);	
            }
        }); //ajax
    } //GetGenderCount

    function GetGenderCount() {


        $('#gender').empty();
        $('#gender').html('<canvas id="dash3"  width="400" height="200"></canvas>');
        var pie = document.getElementById('dash3').getContext('2d');


        param = {'Action': 'GetGenderCount', 'location' : location};

        param = JSON.stringify(param);
        $.ajax({
            type: 'POST',
            url: '../controller/dashboardprocess.php',
            data: {
                data: param
            },
            success: function (data) {
                // console.log('success: '+ data);
                ViewChart(pie,data,'pie');
            },
            error: function (data) {
                // console.log('error: '+ data);	
            }
        }); //ajax
    } //GetGenderCount

    ViewLocationList();

    $('#locationlist').change(function(e){
        e.preventDefault();

        location = $('#locationlist option:selected').text();

        GetPopulationCount();
        GetGenderCount();
        GetAgeCount();

    });

    GetPopulationCount();
    GetGenderCount();
    GetAgeCount();
 
});

