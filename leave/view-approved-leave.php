<?php
session_start();

if (empty($_SESSION["userid"]))
{
    header( "refresh:1;url=../index.php" );
}
else
{
    include("../_header.php");
    include("../leave/leaveApproval.php");

        if ($empUserType == 'Admin' || $empUserType == 'HR Generalist' ||$empUserType == 'HR Manager' || $empUserType == 'Group Head' ||  $empUserType =='Team Manager' ||  $empUserType =='President')
        {
  
        }else{
            echo '<script type="text/javascript">swal({text:"You do not have access here!",icon:"error"});';
            echo "window.location.href = '../index.php';";
            echo "</script>";
        }     
}
?>

<link rel="stylesheet" type="text/css" href="../leave/leave.css">
<link rel="stylesheet" type="text/css" href="..leave/leave_vapp.css">
<div class="container">
    <div class="section-title">
          <h1>APPROVE LEAVE VIEW</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-cogs fa-fw'>
                        </i>&nbsp;APPROVE LEAVE VIEW</b></li>
            </ol>
          </nav>
      <div class="form-row pt-3">
        <div class="col-md-6">
            <input type="text" class="form-control" id="employeeSearch" name="employeeSearch" placeholder="Enter first 3 letters of Lastname or Firstname only">
            <div id="list-box"></div>
        </div>
        <div class="col-md-1">
        <button type="submit" id="search" class="genpyrll" ><i class="fas fa-search-plus"></i> SEARCH</button>
        </div>
    </div>

    <div id="approvedLeaveList" class="form-row pt-3"></div>
 </div>
</div>
<br><br>

<script type="text/javascript" src="../leave/leaveApplication.js"></script>


<?php include('../_footer.php');  ?>