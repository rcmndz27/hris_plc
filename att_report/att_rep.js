$(function(){


    function XLSXExport(){
        $("#attRepListTab").tableExport({
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
            sheetname: 'Attendance'
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

        var dfdateFr = new Date($("#dateFrom").val());
        var dfmonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var dfrmM = dfmonths[dfdateFr.getMonth()];
        var dfrmD = dfdateFr.getDate();

        var dfdateTo = new Date($("#dateTo").val());
        var dtoM = dfmonths[dfdateTo.getMonth()];
        var dtoD = dfdateTo.getDate();
        var dtoY = dfdateTo.getFullYear();        
                
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
                document.getElementById('pfromt').innerHTML = 'from '+dfrmM+' '+dfrmD;
                document.getElementById('ptot').innerHTML = ' to '+dtoM+' '+dtoD+', '+dtoY;
            },
            error: function (data){
                
                document.getElementById("myDiv").style.display="none";
                // console.log("error: "+ data);	
            }
        });

        }

    });    

    function XLSXExportLate(){
        $("#attRepListTab").tableExport({
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
            sheetname: 'Attendance'
        });
    }    


    $("#searchLate").click(function(e){

         e.preventDefault();
        document.getElementById("myDiv").style.display="block";

        if($('#dateToL').val()== '' ){
            swal({text:"Kindly fill up blank fields!",icon:"warning"});
            document.getElementById("myDiv").style.display="none";
       }else{   

        param = {
          Action: "GetLateList",
          datefrom: $("#dateFromL").val(),
          dateto: $("#dateToL").val()
        };
        
        param = JSON.stringify(param);

        var dfdateFr = new Date($("#dateFromL").val());
        var dfmonths = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        var dfrmM = dfmonths[dfdateFr.getMonth()];
        var dfrmD = dfdateFr.getDate();

        var dfdateTo = new Date($("#dateToL").val());
        var dtoM = dfmonths[dfdateTo.getMonth()];
        var dtoD = dfdateTo.getDate();
        var dtoY = dfdateTo.getFullYear();        
                
        $.ajax({
            type: "POST",
            url: "../att_report/attrepProcess.php",
            data: {data:param} ,
            success: function (data){
                // console.log("success: "+ data);
                $("#lateListTab").html(data);
                XLSXExportLate();
                $(".xprtxcl").prepend('<i class="fas fa-file-export"></i> ');
                document.getElementById("myDiv").style.display="none";
                document.getElementById('pfromt').innerHTML = 'from '+dfrmM+' '+dfrmD;
                document.getElementById('ptot').innerHTML = ' to '+dtoM+' '+dtoD+', '+dtoY;
            },
            error: function (data){
                
                document.getElementById("myDiv").style.display="none";
                // console.log("error: "+ data);    
            }
        });

        }

    });      

});