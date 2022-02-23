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
        include('../overtime/ot_app.php');

        $otApp = new OtApp(); 
        $otApp->SetOtAppParams($empCode);

    }    
?>

<link rel="stylesheet" type="text/css" href="../leave/ot_view.css">
<script type='text/javascript' src='../overtime/ot_app.js'></script>
<script type='text/javascript' src='../js/validator.js'></script>
<script src="../overtime/moment2.min.js"></script>
<script src="../overtime/moment-range.js"></script>
<div class="container">
    <div class="section-title">
          <h1>OVERTIME APPLICATION</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-hourglass fa-fw'>
                        </i>&nbsp;OVERTIME APPLICATION</b></li>
            </ol>
          </nav>
   
    <div class="pt-3">

        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="appOt" id="applyOvertime"><i class="fas fa-plus-circle"></i> APPLY OVERTIME</button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $otApp->GetOtAppHistory(); ?>
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
                    <h5 class="modal-title bb" id="popUpModalTitle">APPLY OVERTIME <i class="fas fa-hourglass fa-fw">
                        </i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                      
                            <div class="form-row align-items-center mb-2">
                                   <div class="col-md-2 d-inline">
                                        <label for="">OT Date From:</label>
                                    </div>
                                    <div class="col-md-3 d-inline">
                                        <input type="date" id="otdate" name="otdate" class="form-control"
                                            value="<?php echo date('Y-m-d');?>">
                                    </div>
                                    <div class="col-md-2 d-inline">
                                        <label for="">OT Date To:</label>
                                    </div>
                                    <div class="col-md-3 d-inline">
                                        <input type="date" id="otdateto" name="otdateto" class="form-control"
                                            value="<?php echo date('Y-m-d');?>">
                                    </div>
                            </div>


                        <div class="form-row align-items-center mb-2">

                            <div class="col-md-2 d-inline">
                                <label for="">Time in:</label>
                            </div>
                            <div class="col-md-3 d-inline">
                                <input type="time" id="otstartdtime" name="otstartdtime" class="form-control"
                                    value="<?php echo date('h:i:sa');?>">
                            </div>
                            <div class="col-md-2 d-inline">
                                <label for="">Time out:</label>
                            </div>
                            <div class="col-md-3 d-inline">
                                <input type="time" id="otenddtime" name="otenddtime" class="form-control"
                                    value="<?php echo date('h:i:sa'); ?>" readonly>
                            </div>
                        </div>

                                    <div class="form-row align-items-center mb-2">
                                       <div class="col-md-2 d-inline">
                                            <label for="">Plan OT:</label>
                                        </div>
                                        <div class="col-md-3 d-inline">
                                              <select class="form-select" name="otreqhrs" id="otreqhrs" onchange="myChangeFunction(this)">
                                                <option value="0">0 hr.</option>
                                                <option value="1">1 hr.</option>
                                                <option value="2">2 hrs.</option>
                                                <option value="3">3 hrs.</option>
                                                <option value="4">4 hrs.</option>
                                                <option value="5">5 hrs.</option>
                                                <option value="6">6 hrs.</option>
                                                <option value="7">7 hrs.</option>
                                                <option value="8">8 hrs.</option>
                                                <option value="9">9 hrs.</option>
                                                <option value="10">10 hrs.</option>
                                              </select>              
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

                    </div>
                </div>


                <div class="modal-footer">
                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                    <button type="button" class="subbut" id="Submit" ><i class="fas fa-check-circle"></i> SUBMIT</button>
                </div>

            </div>
        </div>
    </div>
        <div class="col-md-12 mbot">
            <div id='contents'>       
            </div>
        </div>
      </div>
</div>
<br><br>

  <script>

        function myChangeFunction(input1) {
            var dte = $('#otdate').val();
            var dte_to = $('#otdateto').val();
            var otstrt = $('#otstartdtime').val();
            var dt = dte+' '+otstrt;
            var othrs = $('#otreqhrs').val();
            var dt_input = new Date(dt);
            var hr = parseFloat(othrs);

            var hours = dt_input.getHours() + hr;
            var minutes = dt_input.getMinutes();
            var ampm = hours < 12 || hours > 24 ? 'AM' : 'PM';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0'+minutes : minutes;
            var strTime = hours + ':' + minutes + ' ' + ampm;
            var dt = moment(strTime, ["h:mm A"]).format("HH:mm");

            var input2 = document.getElementById('otenddtime');
            input2.value = dt;

        }

 </script>



<?php include("../_footer.php");?>
