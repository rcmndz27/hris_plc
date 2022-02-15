$(function(){


    function XLSXExport(){
        $("#payrollList").tableExport({
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
        param = {
          Action: "GetPayrollList",

          datefrom: dates[0],
          dateto: dates[1],
          empcode: $("#empCode").val(),
          location: dates[2]
        };
        
        param = JSON.stringify(param);
        // alert(param);
        // exit();
        
        $.ajax({
            type: "POST",
            url: "../payroll/payrollProcess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $("#tableList").html(data);
                XLSXExport();
            },
            error: function (data){
                // console.log("error: "+ data);    
            }
        });

    });


    

});