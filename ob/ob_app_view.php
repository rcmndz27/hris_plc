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
        include('../ob/ob_app.php');

        $obApp = new ObApp(); 
        $obApp->SetObAppParams($empCode);

    }    
?>

<script type="text/javascript">
    

        function viewObModal(obdestination,obdate,obtime,obpurpose,obpercmp,stats){

   
        $('#viewObModal').modal('toggle');

        var hidful = document.getElementById('obdestination');
        hidful.value =  obdestination;   

        var bnkt = document.getElementById('obdate');
        bnkt.value =  obdate;  

        var at = document.getElementById('obtime');
        at.value =  obtime;  

        var ast = document.getElementById('obpurpose');
        ast.value =  obpurpose;  

        var bnkt2 = document.getElementById('obpercmp');
        bnkt2.value =  obpercmp;  

        var at2 = document.getElementById('stats');
        at2.value =  stats;                 

                          
    }

    function viewObHistoryModal(lvlogid)
    {
       $('#viewObHistoryModal').modal('toggle');
        var url = "../ob/ob_viewlogs.php";
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
<link rel="stylesheet" type="text/css" href="../ob/ob_view.css">
<script type='text/javascript' src='../ob/ob_app.js'></script>
<script type='text/javascript' src='../js/validator.js'></script>
<script src="../ob/moment2.min.js"></script>
<script src="../ob/moment-range.js"></script>
<div class="container">
    <div class="section-title">
          <h1>OFFICIAL BUSINESS APPLICATION</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-building'></i>&nbsp;OFFICIAL BUSINESS APPLICATION</b></li>
            </ol>
          </nav>
   
    <div class="pt-3">

        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="appWfh" id="applyOfBus"><i class="fas fa-plus-circle"></i> APPLY OFFICIAL BUSINESS</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $obApp->GetObAppHistory(); ?>
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
                    <h5 class="modal-title bb" id="popUpModalTitle">APPLY OFFICIAL BUSINESS <i class='fas fa-building'></i>
                        </i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                      
                            <div class="form-row align-items-center mb-2">
                                   <div class="col-md-2 d-inline">
                                        <label for="">OB Date From:</label>
                                    </div>
                                    <div class="col-md-3 d-inline">
                                        <input type="date" id="ob_from" name="ob_from" class="form-control"
                                            value="<?php echo date('Y-m-d');?>">
                                    </div>
                                    <div class="col-md-2 d-inline">
                                        <label for="">OB Date To:</label>
                                    </div>
                                    <div class="col-md-3 d-inline">
                                        <input type="date" id="ob_to" name="ob_to" class="form-control"
                                            value="<?php echo date('Y-m-d');?>">
                                    </div>
                            </div>


                        <div class="form-row align-items-center mb-2">

                            <div class="col-md-2 d-inline">
                                <label for="">OB Time:</label>
                            </div>
                            <div class="col-md-3 d-inline">
                                <input type="time" id="ob_time" name="ob_time" class="form-control">
                            </div>
                            <div class="col-md-2 d-inline">
                                <label for="">OB Destination:</label>
                            </div>
                            <div class="col-md-5 d-inline">
                                <input type="text" id="ob_destination" name="ob_destination" class="form-control inputtext">
                            </div>
                        </div>

                                    <div class="form-row align-items-center mb-2">
                                       <div class="col-md-2 d-inline">
                                            <label for="ob_percmp">Person/Company to See:</label>
                                        </div>
                                        <div class="col-md-10 d-inline">
                                            <input type="text" id="ob_percmp" name="ob_percmp" class="form-control inputtext">
                                        </div>
                                    </div>

                        <div class="form-row mb-2">
                            <div class="col-md-2 d-inline">
                                <label for='leaveDesc'>Purpose:</label>
                            </div>
                            <div class="col-md-10 d-inline">
                                <textarea class="form-control inputtext" id="ob_purpose" name="ob_purpose" rows="4" cols="50" ></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                    <button type="button" class="subbut" id="Submit" ><i class="fas fa-check-circle"></i> SUBMIT</button>
                </div>

            </div>
        </div>
    </div>
<div class="modal fade" id="viewObModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">VIEW OFFICIAL BUSINESS <i class="fas fa-building"></i></h5>
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
                            <!-- ob_from,ottype,otstartdtime,otenddtime,remark,otreqhrs,otrenhrs,rejectreason -->
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="obdate">OB Date</label>
                                        <input type="text" id="obdate" name="obdate" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="control-label" for="obdestination">Destination</label>
                                        <input type="text" id="obdestination" name="obdestination" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="obtime">Time</label>
                                        <input type="text" id="obtime" name="obtime" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="control-label" for="obpercmp">Person/Company to See</label>
                                        <input type="text" id="obpercmp" name="obpercmp" class="form-control" readonly>                                        
                                    </div>
                                </div> 
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="stats">Status</label>
                                        <input type="text" id="stats" name="stats" class="form-control" readonly>
                                    </div>
                                </div>   
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="control-label" for="obpurpose">Purpose</label>
                                        <input type="text" id="obpurpose" name="obpurpose" class="form-control" readonly>
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

<div class="modal fade" id="viewObHistoryModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-sg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">VIEW OVERTIME LOGS   <i class='fas fa-building'></i></i></h5>
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
