<?php


session_start();

if (empty($_SESSION['userid']))
{

    include_once('../loginfirst.php');
    exit();
}
else
{

    include('../_header.php');
    include('../payroll_att/gen_att.php');
    include('../elements/DropDown.php');
    include('../controller/MasterFile.php');

    $mf = new MasterFile();
    $dd = new DropDown();
    $empCode = $_SESSION['userid'];

    if ($empUserType == 'Admin' || $empUserType == 'HR Generalist' ||$empUserType == 'HR Manager' || $empUserType == 'Group Head' || $empUserType == 'President')
    {

    }else{
        echo '<script type="text/javascript">swal({text:"You do not have access here!",icon:"error"});';
        echo "window.location.href = '../index.php';";
        echo "</script>";
    }

}

?>

<!-- <link rel="stylesheet" type="text/css" href="../payslip/payslip.css"> -->
<link rel="stylesheet" type="text/css" href="../newhireaccess/newemp.css">
<div id = "myDiv" style="display:none;" class="loader"></div>
<div class="container">
    <div class="section-title">
          <h2></h2>
        </div>
    <div class="main-body mbt">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-users fa-fw'>
                        </i>&nbsp; GENERATE SCRIPTS MODULE</b></li>
            </ol>
          </nav>

                <ul class="nav nav-tabs tabrec" id="myTab" name="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="attendance-tab" name="attendance-tab" data-toggle="tab"
                            href="#attendance" role="tab" aria-controls="attendance" aria-selected="true">Attendance</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="leave-tab" name="leave-tab" data-toggle="tab" href="#leave"
                            role="tab" aria-controls="leave" aria-selected="false">Leave</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="overtime-tab" name="overtime-tab" data-toggle="tab" href="#overtime" role="tab"
                            aria-controls="overtime" aria-selected="false">Overtime</a>
                    </li>
                </ul>
               
                <!-- ATTENDANCE -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                      <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad">
                                    Generate Attendance For Payroll
                                </legend>
                             </div>
                             <div class="form-row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="employeepaylist" class="col-form-label pad">PAYROLL PERIOD:</label>   

                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <?php $dd->GenerateDropDown("ungenpco", $mf->GetUnGenPayrollCutoff("ungenpco")); ?>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <button type="button" id="search" class="genpyrll" onclick="genAttPay();">
                                            <i class="fas fa-search-plus"></i>GENERATE                       
                                        </button> 
                                    </div>
                                </div>
                            </div>      
                    </fieldset>
                </div>
                <!-- leave -->
                <div class="tab-pane fade" id="leave" role="tabpanel" aria-labelledby="leave-tab">
                    <fieldset class="fieldset-border">
                        <div class="d-flex justify-content-center">
                            <legend class="fieldset-border pad">
                                Generate Leave for Payroll
                            </legend>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="employeepaylist" class="col-form-label pad">PAYROLL PERIOD:</label>   

                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <?php $dd->GenerateDropDown("ungenleave", $mf->UnGetAllCutoffPay("unpayview")); ?>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <button type="button" id="search" class="genpyrll" onclick="genLeavePay();">
                                        <i class="fas fa-search-plus"></i>GENERATE                       
                                    </button> 
                                </div>
                            </div>
                        </div>      
                    </fieldset>
                </div>

                    <div class="tab-pane fade" id="overtime" role="tabpanel" aria-labelledby="overtime-tab">
                    <fieldset class="fieldset-border">
                        <div class="d-flex justify-content-center">
                            <legend class="fieldset-border pad">
                                Generate Overtime for Payroll
                            </legend>
                        </div>
                        <div class="form-row">
                            <div class="col-lg-2">
                                <div class="form-group">
                                    <label for="employeepaylist" class="col-form-label pad">PAYROLL PERIOD:</label>   

                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="form-group">
                                    <?php $dd->GenerateDropDown("ungenot", $mf->UnGetAllCutoffPay("unpayview")); ?>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <button type="button" id="search" class="genpyrll" onclick="genOtPay();">
                                        <i class="fas fa-search-plus"></i>GENERATE                       
                                    </button> 
                                </div>
                            </div>
                        </div>      
                    </fieldset>
            </div>
    </div>
</div>

<script type="text/javascript">

    function genAttPay()
    {

        var url = "../payroll_att/gen_att_process.php";
        var date = $('#ungenpco').children("option:selected").val();
        var dates = date.split(" - ");
        var eMplogName = $('#eMplogName').val();


        swal({
          title: "Are you sure?",
          text: "You want to generate this attendance?",
          icon: "success",
          buttons: true,
          dangerMode: true,
      })
        .then((genAttPay) => {
          document.getElementById("myDiv").style.display="block";
          if (genAttPay) {
            $.post (
                url,
                {
                    action: 1,
                    pyrollco_from: dates[0] ,
                    pyrollco_to: dates[1] ,
                    eMplogName: eMplogName                           
                },
                function(data) {                   
                    swal({
                        title: "Wow!", 
                        text: "Successfully generated attendance!", 
                        type: "success",
                        icon: "success",
                    }).then(function() {                        
                        location.href = '../payroll/payroll_view.php';
                    });  
                });
        } else {
            document.getElementById("myDiv").style.display="none";
            swal({text:"You cancel the generation of attendance!",icon:"error"});
        }
    });

    }

    function genLeavePay()
    {

        var url = "../payroll_att/gen_leave_process.php";
        var date = $('#ungenleave').children("option:selected").val();
        var dates = date.split(" - ");
        var eMplogName = $('#eMplogName').val();

        // console.log(dates[0]);  
        // console.log(dates[1]);  
        // console.log(eMplogName);
        // return false;

        swal({
          title: "Are you sure?",
          text: "You want to generate this leave to attendance?",
          icon: "success",
          buttons: true,
          dangerMode: true,
      })
        .then((genAttPay) => {
          document.getElementById("myDiv").style.display="block";
          if (genAttPay) {
            $.post (
                url,
                {
                    action: 1,
                    pyrollco_from: dates[0] ,
                    pyrollco_to: dates[1] ,
                    eMplogName: eMplogName                           
                },
                function(data) {                 
                    swal({
                        title: "Wow!", 
                        text: "Successfully generated attendance!", 
                        type: "success",
                        icon: "success",
                    }).then(function() {                        
                        location.href = '../payroll/payroll_view.php';
                    });  
                });
        } else {
            document.getElementById("myDiv").style.display="none";
            swal({text:"You cancel the generation of leave to attendance!",icon:"error"});
        }
    });

    }

</script>
<?php include('../_footer.php');  ?>
