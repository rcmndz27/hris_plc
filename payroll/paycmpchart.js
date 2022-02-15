
$(function(){

    var companies = '';

    function ViewCompaniesList(){
        param = {"Action":"GetCompaniesList"};
        param = JSON.stringify(param);
        $.ajax({
            type: "POST",
            url: "../payroll/paycmp_process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                var companiesListArr = JSON.parse(data);
                var options = '';
                for (var x = 0; x < companiesListArr.length; x++){
                    options += '<option value="' + companiesListArr[x]['desc'] + '">' + companiesListArr[x]['desc'] + '</option>';
                }
                $('#companieslist').html(options); 
                $('#companieslist').prepend("<option value=''></option>").val('');
            },
            error: function (data){
                // console.log("error: "+ data);    
            }
        });//ajax
    }//ViewcompaniesList

});

