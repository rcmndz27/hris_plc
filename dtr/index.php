<?php
session_start();

if (empty($_SESSION["userid"]))
{
    header( "refresh:1;url=../index.php" );
}
else
{
    include("../_header.php");
    
    if ($empUserType == "Admin" || $empUserType == "HR-CreateStaff")
    {
        include("../dtr/dtr-viewing.php");
    }
    else
    {
        header( "refresh:1;url=../index.php" );
    }
}
?>


<script type="text/javascript" src="../dtr/dtr-viewing.js"></script>

<script src="<?= constant('NODE'); ?>xlsx/dist/xlsx.core.min.js"></script>
<script src="<?= constant('NODE'); ?>file-saverjs/FileSaver.min.js"></script>
<script src="<?= constant('NODE'); ?>tableexport/dist/js/tableexport.min.js"></script>
<script type="text/javascript" src='../js/script.js'></script>

<style type="text/css">
.bgen{
    font-weight: bolder;
    width: 120px;
}
    
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
</style>
<div class="container">
    <div class="section-title">
          <h1>ALL EMPLOYEE DAILY TIME RECORD VIEWING</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-suitcase fa-fw'>
                        </i>&nbsp;ALL EMPLOYEE DAILY TIME RECORD VIEWING</b></li>
            </ol>
          </nav>
        <div class="form-row pt-3">
            <label for="employee" class="col-form-label pad">EMPLOYEE:</label>
        <div class="col-md-3">
            <input type="text" class="form-control" name="empCode" id="empCode" placeholder="Employee Code Only" onkeyup="this.value = this.value.toUpperCase();">
        </div>
        <label for="from" class="col-form-label pad">FROM:</label>
        <div class="col-md-2">
            <input type="date" id="dateFrom" class="form-control" name="dateFrom" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <label for="to" class="col-form-label pad">TO:</label>
        <div class="col-md-2">
            <input type="date" id="dateTo" class="form-control" name="dateTo" value="<?php echo date('Y-m-d'); ?>">
        </div>
        <div class="col-md-1">
            <input type="submit" id="search" class="form-control btn btn-primary bgen" value="SEARCH">
        </div>

    </div>

    <div id="dtrViewList" class="form-row pt-3">
    </div>
 </div>
</div>
<br><br>




<?php include('../_footer.php');  ?>