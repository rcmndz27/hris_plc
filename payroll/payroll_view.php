<?php


    session_start();

    if (empty($_SESSION['userid']))
    {

        echo '<script type="text/javascript">alert("Please login first!!");</script>';
        header( "refresh:1;url=../index.php" );
    }
    else
    {

        include('../_header.php');
        include('../payroll/payroll.php');
        include('../elements/DropDown.php');
        include('../controller/MasterFile.php');
        $empCode = $_SESSION['userid'];
        $empInfo->SetEmployeeInformation($_SESSION['userid']);
        $empUserType = $empInfo->GetEmployeeUserType();
        $empInfo = new EmployeeInformation();
        $mf = new MasterFile();
        $dd = new DropDown();

            if($empUserType == 'Admin' || $empUserType == 'HR Generalist' ||$empUserType == 'HR Manager' || $empUserType == 'Group Head' || $empUserType == 'HR Generalist' ||$empUserType == 'HR Manager' || $empUserType == 'Group Head') {

            }else{
                echo '<script type="text/javascript">swal({text:"You do not have access here!",icon:"error"});';
                echo "window.location.href = '../index.php';";
                echo "</script>";
            }
    }
        
?>

<link rel="stylesheet" href="../payroll/payroll.css">
<script src="<?= constant('NODE'); ?>xlsx/dist/xlsx.core.min.js"></script>
<script src="<?= constant('NODE'); ?>file-saverjs/FileSaver.min.js"></script>
<script src="<?= constant('NODE'); ?>tableexport/dist/js/tableexport.min.js"></script>
<div id = "myDiv" style="display:none;" class="loader"></div>
<body  onload="javascript:generatePayrll();">
<div class="container">
    <div class="section-title">
          <h1>PAYROLL VIEW</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-money-check fa-fw'>
                        </i>&nbsp;PAYROLL VIEW</b></li>
            </ol>
          </nav>

                <div class="form-row">
                    <label for="payroll_period" class="col-form-label pad">PAYROLL PERIOD/LOCATION:</label>
                <div class='col-md-4'>
                    <select class="form-control" id="empCode" name="empCode" value="" hidden>
                        <option value="<?php echo $empCode ?>"><?php echo $empCode ?></option>
                    </select>
                    <?php $dd->GenerateDropDown("ddcutoff", $mf->GetAllCutoffPay("payview")); ?>
                </div>           
                        <button type="button" id="search" class="genpyrll" onmousedown="javascript:generatePayrll()">
                            <i class="fas fa-search-plus"></i> GENERATE                      
                        </button>
                        <button type="button" class="gotopay" >
                                <a href="../payroll/payroll_view_register.php" class="payreggoto" onclick="show()">
                                <i class="far fa-arrow-alt-circle-right"></i> PAYROLL REGISTER</a>
                        </button>                                          
                </div>
                <div class="row pt-5">
                    <div class="col-md-12 mbot"><br>
                        <div id='contents'></div>
                    </div>
                </div>

<div class="modal fade" id="updateAtt" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-sg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">UPDATE EMPLOYEE ATTENDANCE <i class="fas fa-money-check fa-fw"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
        <div class="modal-body">
            <div class="main-body">
                <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad">
                                </legend>
                             </div>
                        <div class="form-row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="dscsb">Code:</label>
                                        <input type="text" class="form-control" name="badge_no"
                                            id="badge_no" readonly> 
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="control-label" for="dscsb">Employee Name:</label>
                                        <input type="text" class="form-control" name="employee"
                                            id="employee" readonly> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="tot_overtime_reg">Regular Overtime:</label>
                                        <input type="number" class="form-control" name="tot_overtime_reg"
                                            id="tot_overtime_reg"> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="tot_overtime_rest">Rest Day Overtime:</label>
                                        <input type="number" class="form-control" name="tot_overtime_rest"
                                            id="tot_overtime_rest"> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="tot_overtime_regholiday">Regular Holiday Overtime:</label>
                                        <input type="number" class="form-control" name="tot_overtime_regholiday"
                                            id="tot_overtime_regholiday"> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="tot_overtime_spholiday">Special Holiday Overtime:</label>
                                        <input type="number" class="form-control" name="tot_overtime_spholiday"
                                            id="tot_overtime_spholiday"> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="tot_overtime_sprestholiday">Special Rest Day Holiday Overtime:</label>
                                        <input type="number" class="form-control" name="tot_overtime_sprestholiday"
                                            id="tot_overtime_sprestholiday"> 
                                    </div>
                                </div>                                                                                                  
                                

                        </div> <!-- form row closing -->
                    </fieldset> 
                                <div class="modal-footer">                                  
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                    <button type="button" class="subbut" onclick="updateAtt()" ><i class="fas fa-check-circle"></i> SUBMIT</button>                                      
                                </div> 
                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->



        </div>
</div>
</body>
<script>


function show() {
    document.getElementById("myDiv").style.display="block";
}



    function editAttModal(empname,empcd,regot,restot,reghot,spot,sphresot){
          
        $('#updateAtt').modal('toggle');

        var empnamem = document.getElementById('employee');
        empnamem.value =  empname;

        var empcdm = document.getElementById('badge_no');
        empcdm.value =  empcd;      

        var hidful = document.getElementById('tot_overtime_reg');
        hidful.value =  regot;   

        var bnkt = document.getElementById('tot_overtime_rest');
        bnkt.value =  restot;  

        var bno = document.getElementById('tot_overtime_regholiday');
        bno.value =  reghot; 

        var sts = document.getElementById('tot_overtime_spholiday');
        sts.value =  spot;  

        var ghdsa = document.getElementById('tot_overtime_sprestholiday');
        ghdsa.value =  sphresot;          
                                 

    }

    function updateAtt()
    {


        var url = "../payroll/updateAtt_process.php";
        var badge_no = document.getElementById("badge_no").value;
        var tot_overtime_reg = document.getElementById("tot_overtime_reg").value;
        var tot_overtime_rest = document.getElementById("tot_overtime_rest").value;
        var tot_overtime_regholiday = document.getElementById("tot_overtime_regholiday").value;
        var tot_overtime_spholiday = document.getElementById("tot_overtime_spholiday").value;
        var tot_overtime_sprestholiday = document.getElementById("tot_overtime_sprestholiday").value;                

                        swal({
                          title: "Are you sure?",
                          text: "You want to update this employee attendance details?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((updateAtt) => {
                          if (updateAtt) {
                                $.post (
                                    url,
                                    {
                                        action: 1,
                                        badge_no: badge_no ,
                                        tot_overtime_reg: tot_overtime_reg ,
                                        tot_overtime_rest: tot_overtime_rest ,
                                        tot_overtime_regholiday: tot_overtime_regholiday, 
                                        tot_overtime_spholiday: tot_overtime_spholiday, 
                                        tot_overtime_sprestholiday: tot_overtime_sprestholiday                                        
                                    },
                                    function(data) {     
                                    console.log(data);                                        
                                            swal({
                                            title: "Wow!", 
                                            text: "Successfully updated the attendance details!", 
                                            type: "success",
                                            icon: "success",
                                        }).then(function() {
                                            location.href = '../payroll/payroll_view.php';
                                        }); 
                                    }
                                );

                          } else {
                            swal({text:"You cancel the updating of employee details!",icon:"error"});
                          }
                        });
   
                }



function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("payrollList");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}  

    function ApprovePayView()
    {   
                $("body").css("cursor", "progress");
                var empCode = $('#empCode').children("option:selected").val();
                var url = "../payroll/payrollViewProcess.php";

                $('#contents').html('');
  
              
                        swal({
                          title: "Are you sure?",
                          text: "You want to save this payroll?",
                          icon: "info",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((savePayroll) => {
                          if (savePayroll) {
                                    $.post (
                                        url,
                                        {
                                            choice: 1,
                                            emp_code: empCode
                                        },
                                        function(data) {window.location.replace("../payroll/payroll_view_register.php"); }
                                    );
                                    
                      } else {
                            swal({text:"You cancel the saving of payroll!",icon:"error"});
                          }
                        });

    
    }


    function generatePayrll()
    {

        document.getElementById("myDiv").style.display="block";
        $("body").css("cursor", "progress");
        var url = "../payroll/payrollrep_process.php";
        var cutoff = $('#ddcutoff').children("option:selected").val();
        var dates = cutoff.split(" - ");
        var empCode = $('#empCode').children("option:selected").val();

        $('#contents').html('');

        $.post (
            url,
            {
                _action: 1,
                _from: dates[0],
                _to: dates[1],
                _location: dates[2],
                _empCode: empCode
                
            },
            function(data) { 
                $("#contents").html(data).show();
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
            sheetname: 'Payroll Attendance'
        });
        $(".xprtxcl").prepend('<i class="fas fa-file-export"></i> ');
                document.getElementById("myDiv").style.display="none"; 
            }
        );
    }


</script>


<?php include('../_footer.php');  ?>
