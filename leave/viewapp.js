$(function(){

    function XLSXExport(){
        $("#LeaveListTab").tableExport({
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
            sheetname: 'Approved Leaves'
        });
    }


    $("#searchLeaveApp").click(function(e){

        e.preventDefault();
        document.getElementById("myDiv").style.display="block";

        var cutoff = $('#ddcutoff').children("option:selected").val();
        var det = cutoff.split(" - ");
 
        param = {
          Action: "GetAppLeave",
          date_from: det[0],
          date_to: det[1]
        };
        
        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../leave/viewappleave_process.php",
            data: {data:param} ,
            success: function (data){
                document.getElementById("myDiv").style.display="none"; 
                $("#LeaveListTab").html(data);
                XLSXExport();
                $(".fa-file-export").remove();
                $(".xprtxcl").prepend('<i class="fas fa-file-export"></i>');
            },
            error: function (data){
                
                document.getElementById("myDiv").style.display="none"; 
            }
        });

    });  


 function XLSXExportOt(){
        $("#OtListTab").tableExport({
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
            sheetname: 'Approved OT'
        });
    }


    $("#searchOtApp").click(function(e){

        e.preventDefault();
        document.getElementById("myDiv").style.display="block";

        var cutoff = $('#ddcutoff').children("option:selected").val();
        var det = cutoff.split(" - ");
 
        param = {
          Action: "GetAppOt",
          date_from: det[0],
          date_to: det[1]
        };
        
        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../leave/viewappleave_process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                document.getElementById("myDiv").style.display="none"; 
                $("#OtListTab").html(data);
                XLSXExportOt();
                $(".fa-file-export").remove();
                $(".xprtxcl").prepend('<i class="fas fa-file-export"></i>');
            },
            error: function (data){
                
                document.getElementById("myDiv").style.display="none"; 
            }
        });

    });   

 function XLSXExportWfh(){
        $("#WfhListTab").tableExport({
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
            sheetname: 'Approved Wfh'
        });
    }


    $("#searchWfhApp").click(function(e){

        e.preventDefault();
        document.getElementById("myDiv").style.display="block";

        var cutoff = $('#ddcutoff').children("option:selected").val();
        var det = cutoff.split(" - ");
 
        param = {
          Action: "GetAppWfh",
          date_from: det[0],
          date_to: det[1]
        };
        
        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../leave/viewappleave_process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                document.getElementById("myDiv").style.display="none"; 
                $("#WfhListTab").html(data);
                XLSXExportWfh();
                $(".fa-file-export").remove();
                $(".xprtxcl").prepend('<i class="fas fa-file-export"></i>');
            },
            error: function (data){
                
                document.getElementById("myDiv").style.display="none"; 
            }
        });

    });    

function XLSXExportOb(){
        $("#ObListTab").tableExport({
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
            sheetname: 'Approved Ob'
        });
    }


    $("#searchObApp").click(function(e){

        e.preventDefault();
        document.getElementById("myDiv").style.display="block";

        var cutoff = $('#ddcutoff').children("option:selected").val();
        var det = cutoff.split(" - ");
 
        param = {
          Action: "GetAppOb",
          date_from: det[0],
          date_to: det[1]
        };
        
        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../leave/viewappleave_process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                document.getElementById("myDiv").style.display="none"; 
                $("#ObListTab").html(data);
                XLSXExportOb();
                $(".fa-file-export").remove();
                $(".xprtxcl").prepend('<i class="fas fa-file-export"></i>');
            },
            error: function (data){              
                document.getElementById("myDiv").style.display="none"; 
            }
        });

    });    

function XLSXExportDtrc(){
        $("#DtrcListTab").tableExport({
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
            sheetname: 'Approved Dtrc'
        });
    }


    $("#searchDtrcApp").click(function(e){

        e.preventDefault();
        document.getElementById("myDiv").style.display="block";

        var cutoff = $('#ddcutoff').children("option:selected").val();
        var det = cutoff.split(" - ");
 
        param = {
          Action: "GetAppDtrc",
          date_from: det[0],
          date_to: det[1]
        };
        
        param = JSON.stringify(param);

        $.ajax({
            type: "POST",
            url: "../leave/viewappleave_process.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                document.getElementById("myDiv").style.display="none"; 
                $("#DtrcListTab").html(data);
                XLSXExportDtrc();
                $(".fa-file-export").remove();
                $(".xprtxcl").prepend('<i class="fas fa-file-export"></i>');
            },
            error: function (data){
                
                document.getElementById("myDiv").style.display="none"; 
            }
        });

    });                 

});