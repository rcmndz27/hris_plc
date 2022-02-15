$(function(){


    function XLSXExport(){
        $("#payrollRepList").tableExport({
            headers: true,
            footers: true,
            formats: ['xlsx'],
            filename: 'id',
            bootstrap: false,
            exportButtons: true,
            position: 'top',
            ignoreRows: null,
            ignoreCols: null,
            trimWhitespace: true,
            RTL: false,
            sheetname: 'id'
        });
    }

    $("#search").click(function(e){
        e.preventDefault();
        
        var cutoff = $('#ddcutoff').children("option:selected").val();
        var dates = cutoff.split(" - ");
        var company = $('#compay').children("option:selected").val();
        var companies = company.split(" - ");

        param = {
          Action: "GetPayrollRepList",
          datefrom: dates[0],
          dateto:  dates[1],
          company: companies[0]
        };
        
        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../payroll/payrollrep_rep_process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                // $("#tableList").html(data);
                XLSXExport();
            },
            error: function (data){
                // console.log("error: "+ data);	
            }
        });

    });


    

    


   
    


});