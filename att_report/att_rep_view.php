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
    // include('../payroll_att/gen_att.php');
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

<script type='text/javascript' src='../att_report/att_rep.js'></script>
<link rel="stylesheet" type="text/css" href="../pages/dtr.css">
<div id = "myDiv" style="display:none;" class="loader"></div>
<div class="container">
    <div class="section-title">
          <h2>ATTENDANCE REPORTS MODULE</h2>
        </div>
    <div class="main-body mbt">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-users fa-fw'>
                        </i>&nbsp; ATTENDANCE REPORTS MODULE</b></li>
            </ol>
          </nav>

                <ul class="nav nav-tabs tabrec" id="myTab" name="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="attendance-tab" name="attendance-tab" data-toggle="tab"
                            href="#attendance" role="tab" aria-controls="attendance" aria-selected="true">Perfect Attendance</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="late-tab" name="late-tab" data-toggle="tab" href="#late"
                            role="tab" aria-controls="late" aria-selected="false">Late</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="overtime-tab" name="overtime-tab" data-toggle="tab" href="#overtime" role="tab"
                            aria-controls="overtime" aria-selected="false">Overtime</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="dtr-tab" name="dtr-tab" data-toggle="tab" href="#dtr" role="tab"
                            aria-controls="dtr" aria-selected="false">DTR</a>
                    </li>                    
                </ul>
               
                <!-- ATTENDANCE -->
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                      <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad2">
                                    PERFECT ATTENDANCE <span id="pfromt"></span> <span id="ptot"></span>
                                </legend>
                             </div>
                    <div class="form-row">
                            <input type="text" name="empCode" id="empCode" value="<?php $empCode ?>" hidden>
                                <label class="control-label pad" for="dateFrom">FROM:</label>
                            <div class="col-md-2">
                                <input type="date" id="dateFrom" class="form-control" name="dateFrom"
                                    value="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
                            </div>
                                <label class="control-label pad" for="dateTo">TO:</label>
                            <div class="col-md-2">
                                <input type="date" id="dateTo" class="form-control" name="dateTo" value="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" id="searchPerfect" class="genpyrll"><i class="fas fa-search-plus"></i> GENERATE
                                </button>
                            </div>
                        </div>  
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-body">
                            <div id="attRepListTab" class="table-responsive-sm table-body"></div>
                        </div>
                    </div>
                </div>                                                        
                    </fieldset>
                </div>
                <!-- late -->
                <div class="tab-pane fade" id="late" role="tabpanel" aria-labelledby="late-tab">
                    <fieldset class="fieldset-border">
                        <div class="d-flex justify-content-center">
                            <legend class="fieldset-border pad2">
                                LATES
                            </legend>
                        </div>
                    <div class="form-row pt-3">
                            <input type="text" name="empCode" id="empCode" value="<?php $empCode ?>" hidden>
                                <label class="control-label pad" for="dateFrom">FROM:</label>
                            <div class="col-md-2">
                                <input type="date" id="dateFromL" class="form-control" name="dateFromL"
                                    value="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
                            </div>
                                <label class="control-label pad" for="dateTo">TO:</label>
                            <div class="col-md-2">
                                <input type="date" id="dateToL" class="form-control" name="dateToL" value="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
                            </div>
                            <div class="col-md-1">
                                <button type="submit" id="searchLate" class="genpyrll"><i class="fas fa-search-plus"></i> GENERATE
                                </button>
                            </div>
                        </div>  
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-body">
                            <div id="lateListTab" class="table-responsive-sm table-body"></div>
                        </div>
                    </div>
                </div>     
                    </fieldset>
                </div>
                <!-- OVERTIME -->
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

                <!-- dtr -->
                    <div class="tab-pane fade" id="dtr" role="tabpanel" aria-labelledby="dtr-tab">
                        <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad">
                                    Generate DTR from Biometrics
                                </legend>
                            </div>
                        <div class="d-flex justify-content-center">
                            <div class="form-row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <button type="button" id="search" class="genpyrll" onclick="genDTR();">
                                                <i class="fas fa-search-plus"></i>GENERATE                       
                                            </button> 
                                        </div>
                                    </div>
                                  </div>
                            </div>      
                        </fieldset>
                    </div>                    
    </div>
</div>

<script type="text/javascript">

           $('#dateTo').change(function(){

                if($('#dateTo').val() < $('#dateFrom').val()){

                    swal({text:"DATE TO must be greater than date from!",icon:"error"});

                    var input2 = document.getElementById('dateTo');
                    input2.value = '';               
                }
            });


            $('#dateFrom').change(function(){

                if($('#dateFrom').val() > $('#dateTo').val()){
                    var input2 = document.getElementById('dateTo');
                    document.getElementById("dateTo").min = $('#dateFrom').val();
                    input2.value = '';
                }
            });

</script>
<?php include('../_footer.php');  ?>
