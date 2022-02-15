<?php
session_start();

if (empty($_SESSION["userid"]))
{
    header( "refresh:1;url=../index.php" );
}
else
{
    include("../_header.php");
    include("../overtime/overtime-approval.php");
}
?>

<link rel="stylesheet" type="text/css" href="../overtime/overtime.css">
<style type="text/css">
    
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
          <h1>APPROVE OVERTIME VIEW</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-hourglass fa-fw'>
                        </i>&nbsp;APPROVE OVERTIME VIEW</b></li>
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

    <div id="approvedOvertimeList" class="form-row pt-3"></div>

 </div>
</div>
<br><br>

<script type="text/javascript" src="../overtime/overtime-approval.js"></script>


<?php include('../_footer.php');  ?>