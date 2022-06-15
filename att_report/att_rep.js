$(function(){


    function XLSXExport(){
        $("#attrepList").tableExport({
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

    $("#searchPerfect").click(function(e){

         e.preventDefault();
        document.getElementById("myDiv").style.display="block";

        if($('#dateTo').val()== '' ){

            swal({text:"Kindly fill up blank fields!",icon:"warning"});
            document.getElementById("myDiv").style.display="none";

       }else{   

        param = {
          Action: "GetAttRepList",

          datefrom: $("#dateFrom").val(),
          dateto: $("#dateTo").val()
        };
        
        param = JSON.stringify(param);
        
        $.ajax({
            type: "POST",
            url: "../att_report/attrepProcess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $("#attRepListTab").html(data);
                XLSXExport();
                $(".xprtxcl").prepend('<i class="fas fa-file-export"></i> ');
                document.getElementById("myDiv").style.display="none";
            },
            error: function (data){
                
                document.getElementById("myDiv").style.display="none";
                // console.log("error: "+ data);	
            }
        });

        }

    });    

});