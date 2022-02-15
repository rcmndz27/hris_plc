$(function(){


    function XLSXExport(){
        $("#dtrList").tableExport({
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

        param = {
          Action: "GetAttendanceList",

          datefrom: $("#dateFrom").val(),
          dateto: $("#dateTo").val(),
          empcode: $("#empCode").val(),
        };
        
        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../controller/dtrProcess.php",
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