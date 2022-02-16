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
        include('../leave/leaveApproval.php');

        if ($empType == 'Staff')
        {
            echo '<span class="etcMessage">
                    <script type="text/javascript">
                        alert("This page is RESTRICTED!!");
                        $("etcMessage").remove();
                    </script>
                </span';
        }
        else
        {

        }
    }
?>
<style type="text/css">
table,th{

                border: 1px solid #dee2e6;
                font-weight: 700;
                font-size: 14px;
 }   


table,td{

                border: 1px solid #dee2e6;
 }  

 th,td{
    border: 1px solid #dee2e6;
 }
  
table {
        border: 1px solid #dee2e6;
        color: #ffff;
        margin-bottom: 100px;
        border: 2px solid black;
        background-color: white;
    }
  
.mbt {
    background-color: #faf9f9;
    padding: 30px;
    border-radius: 0.25rem;
}
</style>
<div class="container">
    <div class="section-title">
          <h1>LEAVE APPROVAL</h1>
    </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-suitcase fa-fw'>
                        </i>&nbsp;LEAVE APPROVAL</b></li>
            </ol>
          </nav>

         <div class="row">
            <div class="col-md-12 pt-3">
                <div class="panel-body" id="pendingList">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 pt-3">
                <div class="panel-body" id="summaryList">
                </div>
            </div>
        </div>

        <div class="modal fade" id="remarksModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="popUpModalTitle"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label for="rejectReason">Remarks</label>
                            <input type="text" name="remarks" id="remarks" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                        <button type="button" class="subbut btnRemarks" id="submit"><i class="fas fa-check-circle"></i> SUBMIT</button>
                    </div>

                </div>
            </div>
        </div>       
    </div>
</div>
<br><br>

<script type='text/javascript' src='../leave/leaveApplication.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php  include('../_footer.php');?>