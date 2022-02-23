$(function(){

    function XLSXExport(){
        $("#empDtrList").tableExport({
            headers: true,
            footers: true,
            formats: ['xlsx'],
            filename: 'employeedtr',
            bootstrap: false,
            exportButtons: true,
            position: 'top',
            ignoreRows: null,
            ignoreCols: null,
            trimWhitespace: true,
            RTL: false,
            sheetname: 'Attendance List'
        });
    }

$('#search').click(function(e){
    e.preventDefault();


    if($('#empCode').val()== '' || $('#dateTo').val()== '' ){

            swal({text:"Kindly fill up blank fields!",icon:"warning"});

       }else{    

            param = {
                "Action":"GetEmployeeAttendannce",
                "dateFrom":$('#dateFrom').val(),
                "dateTo":$('#dateTo').val(),
                "empCodeParam":$('#empCode').val()

            };
            
            param = JSON.stringify(param);

            
            $.ajax({
                type: "POST",
                url: "../dtr/dtr-viewing-process.php",
                data: {data:param} ,
                success: function (data){
                    // console.log("success: "+ data);
                    $('#empDtrList').remove();
                    $('#dtrViewList').append(data);
                    XLSXExport();

                },
                error: function (data){
                    // console.log("error: "+ data);	
                }
            });//ajax
          }

    });
    
});