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



                        <div class="form-row mb-2">
                            <div class="col-md-2 d-inline">
                                <label for='leaveDesc'>Remarks:</label>
                            </div>
                            <div class="col-md-10 d-inline">
                                <textarea class="form-control inputtext" id="remarks" name="remarks" rows="4" cols="50" ></textarea>
                            </div>
                        </div>


                        <div id='Attachment'>
                             <div class="row pb-2">
                                <div class="col-md-2">
                                    <label for="">Attachment:</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="file" name="attachment" id="attachment" onChange="GetWfhFile()">
                                </div>
                            </div>
                        </div>


                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                    <button type="button" class="subbut" id="Submit" onclick="uploadFile();"  ><i class="fas fa-check-circle"></i> SUBMIT</button>
                </div>

            </div>
        </div>
    </div>
        <div class="col-md-12 mbot">
            <div id='contents'>       
            </div>
        </div>
</div>
<br><br>
<?php include("../_footer.php");?>
