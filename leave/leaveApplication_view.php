<?php
    session_start();

    if (empty($_SESSION['userid']))
    {
        echo '<script type="text/javascript">alert("Please login first!!");</script>';
        header('refresh:1;url=../index.php' );
    }
    else
    {
        include('../_header.php');
        include('../leave/leaveApplication.php');

        $leaveApp = new LeaveApplication(); 
        $leaveApp->SetLeaveApplicationParams($empCode,$empType);

        $query = 'SELECT * FROM dbo.employee_profile WHERE emp_code = :empcode ';
        $param = array(":empcode" => $_SESSION['userid']);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $r = $stmt->fetch();

        $querys = 'SELECT * FROM dbo.employee_leave WHERE emp_code = :empcode ';
        $params = array(":empcode" => $_SESSION['userid']);
        $stmts =$connL->prepare($querys);
        $stmts->execute($params);
        $rs = $stmts->fetch();


    }    
?>

<script type="text/javascript">
    
     function showAttachment() {

            $("#Attachment").show();
            $("#medicalfiles").show();
            $("#LabelAttachment").show();
            $("#AddAttachment").hide();            
          }

        function viewLeaveModal(datefl,leavedesc,leavetyp,datefr,dateto,remark,appdays,appr_oved,actlcnt){

   
        $('#viewLeaveModal').modal('toggle');

        var hidful = document.getElementById('datefl');
        hidful.value =  datefl;   

        var bnkt = document.getElementById('leavedesc');
        bnkt.value =  leavedesc;  

        var at = document.getElementById('leavetyp');
        at.value =  leavetyp;  

        var ast = document.getElementById('datefr');
        ast.value =  datefr;  

        var hidful2 = document.getElementById('dateto');
        hidful2.value =  dateto;   

        var bnkt2 = document.getElementById('remark');
        bnkt2.value =  remark;  

        var at2 = document.getElementById('appdays');
        at2.value =  appdays;  

        var ast2 = document.getElementById('appr_oved');
        ast2.value =  appr_oved;  

        var ast3 = document.getElementById('actlcnt');
        ast3.value =  actlcnt;        

                          
    }

    function viewLeaveHistoryModal(lvlogid)
    {
       $('#viewLeaveHistoryModal').modal('toggle');
        var url = "../leave/leave_viewlogs.php";
        var lvlogid = lvlogid;

        $.post (
            url,
            {
                _action: 1,
                lvlogid: lvlogid             
            },
            function(data) { $("#contents2").html(data).show(); }
        );
    }

</script>
<link rel="stylesheet" type="text/css" href="../leave/leave_view.css">
<script type='text/javascript' src='../leave/leaveApplication.js'></script>
<script type='text/javascript' src='../js/validator.js'></script>

<div class="container">
    <div class="section-title">
          <h1>LEAVE APPLICATION</h1>
        </div>
    <div class="main-body mbt">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-suitcase fa-fw'>
                        </i>&nbsp;LEAVE APPLICATION</b></li>
            </ol>
          </nav>
    <div class="pt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $leaveApp->GetLeaveSummary(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="appLv" id="applyLeave"><i class="fas fa-plus-circle"></i> APPLY LEAVE</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $leaveApp->GetLeaveHistory(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="popUpModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                        <h5 class="modal-title bb" id="popUpModalTitle">APPLY LEAVE <i class="fas fa-suitcase ">
                        </i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                        <?php $leaveApp->GetLeaveType(); ?>
                        <div id="leavepay">
                            <div class="row">
                                <div class=col-md-2>
                                    <label for="">Leave Pay:</label>
                                </div>
                                <div class="col-md-10">                                
                                        <div class="form-check form-check-inline" id="wpay" id="wpay">
                                            <input class="form-check-input" type="radio" name="leavepay"
                                                id="leave_pay1" value="WithPay" checked>
                                            <label class="form-check-label" for="withpay">With Pay</label>
                                        </div>
                                       <div class="form-check form-check-inline" id="woutpay">
                                        <input class="form-check-input" type="radio" name="leavepay"
                                            id="leave_pay2" value="WithoutPay">
                                        <label class="form-check-label" for="withoutpay">Without Pay</label>
                                        </div>
                                </div>
                            </div>
                        </div> 
                        <input type='text' id='emptype' name='emptype' class='form-control'
                                            value=<?php echo $r['emp_type']; ?> hidden>                            
                        
                        
                                <?php 
                                $emp_type = $r['emp_type'];
                                $sl = isset($rs['earned_sl']) ? $rs['earned_sl'] : 0; 

                                if($emp_type == 'Regular'){
                                echo'<div id="sickleavebal">
                                            <div class="form-row align-items-center mb-2">
                                               <div class="col-md-2 d-inline">
                                                    <label for="">SL Balance:</label>
                                                </div>
                                                <div class="col-md-3 d-inline">
                                                        <input type="text" id="sick_leavebal" name="sickleavebal" class="form-control"
                                                        value='.$sl.' readonly>
                                                </div>
                                            </div>
                                    </div>';
                                }else{
                                }
                                 ?>                                            

                         <!-- sick leave advance filing  -->

                        <div id="advancefiling">
                            <div class="row">
                                <div class=col-md-2>
                                    <label for="">Advance Filing:</label>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input advancesl" type="radio" name="advancesl"
                                            id="advancesl" value="yes">
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input advancesl" type="radio" name="advancesl"
                                            id="advancesl" value="no">
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <?php 
                        $emp_type = $r['emp_type'];
                        $vl =  isset($rs['earned_vl']) ? $rs['earned_vl'] : 0; 
                     
                       echo'<div id="vacleavebal">
                                    <div class="form-row align-items-center mb-2">
                                       <div class="col-md-2 d-inline">
                                            <label for="">VL Balance:</label>
                                        </div>
                                        <div class="col-md-3 d-inline">
                                                <input type="text" id="vac_leavebal" name="vacleavebal" class="form-control"
                                                value='.$vl.' readonly>
                                        </div>
                                    </div>
                                </div>';
                      

                        ?>

                    <div id="paternity">
                               <div class="form-row mb-2">
                                    <div class=col-md-2>
                                        <label for="">Civil Status:</label>
                                    </div>
                                    <div class="col-md-4">
                                          <div class="form-check form-check-inline">
                                        <?php 
                                            $cs = $r['civilstatus'];
                                            if($cs =='Single'){
                                           echo"<input type='text' id='civilstatus' name='civilstatus' class='form-control wr'
                                                value=".$cs." readonly>
                                                <h3 class='cstat'>*Please contact HRD to update your civil status*</h3>";

                                            }else{
                                                  echo"<input type='text' id='civilstatus' name='civilstatus' class='form-control'value=".$cs." readonly>";
                                            }
                                         ?>
                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row align-items-center mb-2">
                                   <div class="col-md-2 d-inline">
                                        <label for="">Child Date of Birth:</label>
                                    </div>
                                        <div class="col-md-3 d-inline">
                                            <input type="date" id="dateBirth" name="dateBirth" class="form-control"
                                                value="<?php echo date('Y-m-d');?>">
                                        </div>
                                </div>
                     </div>

                           <div id="maternity">
                                <div class="form-row align-items-center mb-2">
                                   <div class="col-md-2 d-inline">
                                        <label for="">Delivery Date:</label>
                                    </div>
                                    <div class="col-md-3 d-inline">
                                        <input type="date" id="dateStartMaternity" name="dateStartMaternity" class="form-control"
                                            value="<?php echo date('Y-m-d');?>">
                                    </div>
                                </div>
                        </div>


                        <div id="specialviolence">
                                <div class="form-row align-items-center mb-2">
                                   <div class="col-md-2 d-inline">
                                        <label for="">Operation Date:</label>
                                    </div>
                                    <div class="col-md-3 d-inline">
                                        <input type="date" id="dateOfOperation" name="dateOfOperation" class="form-control"
                                            value="<?php echo date('Y-m-d');?>">
                                    </div>
                                </div>
                        </div>

                        <div class="form-row align-items-center mb-2">

                            <div class="col-md-2 d-inline">
                                <label for="">Leave From:</label>
                            </div>
                            <div class="col-md-3 d-inline">
                                <input type="date" id="dateFrom" name="dateFrom" class="form-control"
                                    value="<?php echo date('Y-m-d');?>">
                            </div>
                            <div class="col-md-1 d-inline">
                                <label for="">To:</label>
                            </div>
                            <div class="col-md-3 d-inline">
                                <input type="date" id="dateTo" name="dateTo" class="form-control"
                                    value="<?php echo date('Y-m-d'); ?>">
                            </div>
                            <div class="col-md-3 d-inline">
                                <div class="form-check" id="singleHalf">
                                    <input class="form-check-input" type="checkbox" id="halfDay">
                                        <label class="form-check-label " for="halfDay">Half Day</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-2 align-items-center" id="halfdayset">
                            <div class="col-md-2 d-inline"></div>

                            <div class="col-md-3 d-inline">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="lastDayHalfDay" name="lastDayHalfDay">
                                    <label class="form-check-label " for="lastDayHalfDay">Single Half Day</label>
                                </div>
                            </div>

                            <div class="col-md-3 d-inline">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="multiHalfDay" name="multiHalfDay">
                                    <label class="form-check-label " for="multiHalfDay">All Half Day</label>
                                </div>
                            </div>

                            <div class="col-md-4 d-inline">
                                <span id="errMsg"></span>
                            </div>

                        </div>

                        <div class="form-row mb-2">
                            <div class="col-md-2 d-inline">
                                <label for='leaveDesc'>Reason:</label>
                            </div>
                            <div class="col-md-10 d-inline">
                                <textarea class="form-control inputtext" id="leaveDesc" name="leaveDesc" rows="4" cols="50" ></textarea>
                            </div>
                        </div>



                        <div id='AddAttachment'>
                            <div class="form-row mb-2">
                                <div class="col-md-2">
                                    <label for="">Attach File:</label>
                                </div>
                                <div class="col-md-10 d-inline">
                                    <a class="" onclick="showAttachment()"><img src='../img/ppclip.jpg' class='ppclip'></img></a>
                                </div>
                            </div>
                        </div>


                        <div id='Attachment'>
                             <div class="row pb-2">
                                <div class="col-md-2">
                                    <label for="Attachment" id="LabelAttachment">Attachment:</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="file" name="medicalfiles" id="medicalfiles" accept=".pdf" onChange="GetMedFile()">
                                </div>
                            </div>
                        </div>

                <div class="modal-footer">
                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                    <button type="button" class="subbut" id="Submit" onclick="uploadFile();"  ><i class="fas fa-check-circle"></i> SUBMIT</button>
                </div>
                </div> <!-- main body closing -->
            </div> <!-- modal body closing -->
        </div> <!-- modal content closing -->
    </div> <!-- modal dialog closing -->


    <div class="modal fade" id="viewLeaveModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">VIEW LEAVE <i class="fas fa-suitcase fa-fw"></i></h5>
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
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="datefl">Date Filed</label>
                                        <input type="text" id="datefl" name="datefl" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label class="control-label" for="leavetyp">Leave Type</label>
                                        <input type="text" id="leavetyp" name="leavetyp" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="datefr">Date From</label>
                                        <input type="text" id="datefr" name="datefr" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="dateto">Date To</label>
                                        <input type="text" id="dateto" name="dateto" class="form-control" readonly>                                        
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="actlcnt">Leave Count</label>
                                        <input type="text" id="actlcnt" name="actlcnt" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="appdays">Approved/Rejected</label>
                                        <input type="text" id="appdays" name="appdays" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label" for="leavedesc">Description</label>
                                        <input type="text" id="leavedesc" name="leavedesc" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label class="control-label" for="remark">Remarks</label>
                                        <input type="text" id="remark" name="remark" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="appr_oved">Status</label>
                                        <input type="text" id="appr_oved" name="appr_oved" class="form-control" readonly>
                                    </div>
                                </div>                                
                            </div> <!-- form row closing -->
                    </fieldset> 
                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CLOSE</button>
                                </div> 
                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->

<div class="modal fade" id="viewLeaveHistoryModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-sg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">VIEW LEAVE LOGS   <i class="fas fa-suitcase"></i></h5>
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
                            <div class="row pt-3">
                                <div class="col-md-12">
                                    <div class="panel-body">
                                        <div id="contents2" class="table-responsive-sm table-body">
                                            <button type="button" id="search" hidden>GENERATE</button>
                                        </div>
                                    </div>
                                </div>
                            </div>                                               
                        </div> <!-- form row closing -->
                    </fieldset> 

                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CLOSE</button>
                                </div> 
                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->        

    </div> <!-- main body mbt closing -->
</div><!-- container closing -->



<?php include("../_footer.php");?>
