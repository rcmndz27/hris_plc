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
        include('../controller/dtr.php');
        $employeedtr = new EmployeeDTR();
    }
        
?>
<link rel="stylesheet" type="text/css" href="../pages/dtr.css">
<script type='text/javascript' src='../js/dtr.js'></script>
<script src="<?= constant('NODE'); ?>xlsx/dist/xlsx.core.min.js"></script>
<script src="<?= constant('NODE'); ?>file-saverjs/FileSaver.min.js"></script>
<script src="<?= constant('NODE'); ?>tableexport/dist/js/tableexport.min.js"></script>
<div id = "myDiv" style="display:none;" class="loader"></div>
<div class="container">
    <div class="section-title">
          <h1>MY ATTENDANCE</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-calendar fa-fw'>
                        </i>&nbsp;MY ATTENDANCE</b></li>
            </ol>
          </nav>
    <div class="form-row pt-3">
            <input type="text" name="empCode" id="empCode" value="<?php $empCode ?>" hidden>
                <label class="control-label pad" for="dateFrom">FROM:</label>
            <div class="col-md-2">
                <input type="date" id="dateFrom" class="form-control" name="dateFrom"
                    value="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
            </div>
                <label class="control-label pad" for="dateTo">TO:</label>
            <div class="col-md-2">
                <input type="date" id="dateTo" class="form-control" name="dateTo" value="<?php echo date('Y-m-d'); ?>" onkeydown="return false">
            </div>
            <div class="col-md-1">
                <button type="submit" id="search" class="genpyrll" ><i class="fas fa-search-plus"></i> GENERATE
                </button>
            </div>
        </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <div id="tableList" class="table-responsive-sm table-body"></div>
            </div>
        </div>
    </div>
    </div>
</div>
<script type="text/javascript">

// jQuery(function(){
//    jQuery('#search').click();
//    $(".xprtxcl").prepend('<i class="fas fa-file-export"></i> ');
// });


           $('#dateTo').change(function(){

                if($('#dateTo').val() < $('#dateFrom').val()){

                    swal({text:"Date to must be greater than date from!",icon:"error"});

                    var input2 = document.getElementById('dateTo');
                    input2.value = '';               
                }
            });


            $('#dateFrom').change(function(){

                    var input2 = document.getElementById('dateTo');
                    document.getElementById("dateTo").min = $('#dateFrom').val();
                    input2.value = '';

            });
</script>

<?php include('../_footer.php');  ?>
