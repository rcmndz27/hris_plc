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
        include('../wfhome/wfh_app.php');

        $wfhApp = new WfhApp(); 
        $wfhApp->SetWfhAppParams($empCode);

    }    
?>
<script type="text/javascript">
    

        function viewWfhModal(wfhdate,wfhtask,wfhoutput,wfhpercentage,wfhstats){

   
        $('#viewWfhModal').modal('toggle');

        var hidful = document.getElementById('wfhdates');
        hidful.value =  wfhdate;   

        var bnkt = document.getElementById('wfhtask');
        bnkt.value =  wfhtask;  

        var at = document.getElementById('wfhoutput');
        at.value =  wfhoutput;  

        var ast = document.getElementById('wfhpercentage');
        ast.value =  wfhpercentage;  

        var bnkt2 = document.getElementById('wfhstats');
        bnkt2.value =  wfhstats;  

                          
    }

    function viewWfhHistoryModal(lvlogid)
    {
       $('#viewWfhHistoryModal').modal('toggle');
        var url = "../wfhome/wfh_viewlogs.php";
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
<link rel="stylesheet" type="text/css" href="../wfhome/wfh_view.css">
<script type='text/javascript' src='../wfhome/wfh_app.js'></script>
<script type='text/javascript' src='../js/validator.js'></script>
<script src="../wfhome/moment.min.js"></script>
<script src="../wfhome/moment2.min.js"></script>
<script src="../wfhome/moment-range.js"></script>
<div class="container">
    <div class="section-title">
          <h1>WORK FROM HOME APPLICATION</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-warehouse fa-fw'>
                        </i>&nbsp;WORK FROM HOME APPLICATION</b></li>
            </ol>
          </nav>
<div class="pt-3">
        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="appWfh" id="applyWfh"><i class="fas fa-plus-circle"></i> APPLY WORK FROM HOME </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $wfhApp->GetWfhAppHistory(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popUpModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3 class="text-danger text-center"><label for="" id="modalText"></label></h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="popUpModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">APPLY WORK FROM HOME <i class="fas fa-warehouse"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                      
                            <div class="form-row align-items-center mb-2">
                                   <div class="col-md-2 d-inline">
                                        <label for="">WFH Date From:</label>
                                    </div>
                                    <div class="col-md-3 d-inline">
                                        <input type="date" id="wfhdate" name="wfhdate" class="form-control"
                                            value="<?php echo date('Y-m-d');?>">
                                    </div>
                                    <div class="col-md-2 d-inline">
                                        <label for="">WFH Date To:</label>
                                    </div>
                                    <div class="col-md-3 d-inline">
                                        <input type="date" id="wfhdateto" name="wfhdateto" class="form-control"
                                            value="<?php echo date('Y-m-d');?>">
                                    </div>
                            </div>

                      
                            <div class="form-row align-items-center mb-2">
                                   <div class="col-md-2 d-inline">
                                        <label for="">Task:</label>
                                    </div>
                                    <div class="col-md-10 d-inline">
                                        <input type="text" id="wfh_task" name="wfh_task" class="form-control inputtext">
                                    </div>
                            </div>

                            <div class="form-row align-items-center mb-2">
                                    <div class="col-md-2 d-inline">
                                        <label for="">Expected Output:</label>
                                    </div>
                                    <div class="col-md-10 d-inline">
                                        <input type="text" id="wfh_output" name="wfh_output" class="form-control inputtext">
                                    </div>
                            </div>

                            <div class="form-row align-items-center mb-2">
                                   <div class="col-md-2 d-inline">
                                        <label for="">Percentage:</label>
                                    </div>
                                    <div class="col-md-2 d-inline">
                                        <input type="number" id="wfh_percentage" name="wfh_percentage" class="form-control inputtext">
                                    </div>
                                    <div class="col-md-1 d-inline">
                                        <label for="">%</label>
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

<div class="modal fade" id="viewWfhModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">VIEW WORK FROM HOME <i class="fas fa-warehouse"></i></h5>
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
                             <!-- wfhdate,wfhtask,wfhoutput,wfhpercentage,wfhstats -->
                        <div class="form-row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="wfhdates">WFH Date</label>
                                        <input type="text" id="wfhdates" name="wfhdates" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <label class="control-label" for="wfhtask">Task</label>
                                        <input type="text" id="wfhtask" name="wfhtask" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="wfhpercentage">Percentage %</label>
                                        <input type="text" id="wfhpercentage" name="wfhpercentage" class="form-control" readonly>
                                    </div>
                                </div>                              
                                <div class="col-lg-10">
                                    <div class="form-group">
                                        <label class="control-label" for="wfhoutput">Expected Output</label>
                                        <input type="text" id="wfhoutput" name="wfhoutput" class="form-control" readonly>                                        
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="wfhstats">Status</label>
                                        <input type="text" id="wfhstats" name="wfhstats" class="form-control" readonly>
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

<div class="modal fade" id="viewWfhHistoryModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-sg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">VIEW WORK FROM HOME LOGS   <i class='fas fa-warehouse'></i></i></h5>
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
