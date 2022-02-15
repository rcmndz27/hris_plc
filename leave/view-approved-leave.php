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
}
?>

<link rel="stylesheet" type="text/css" href="../leave/leave.css">
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
        text-align: center;
}
.mbt {
    background-color: #faf9f9;
    padding: 30px;
    border-radius: 0.25rem;
}

.pad{
    padding: 5px 5px 5px 5px;
    font-weight: bolder;
}

.fb{
   font-weight: bolder; 
   width: 130px;
}
</style>
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
            <input type="submit" id="search" class="form-control btn btn-primary fb" value="SEARCH">
        </div>
    </div>

    <div id="approvedLeaveList" class="form-row pt-3"></div>
 </div>
</div>
<br><br>

<script type="text/javascript" src="../leave/leaveApplication.js"></script>


<?php include('../_footer.php');  ?>