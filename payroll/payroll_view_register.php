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
        include('../payroll/payroll_reg.php');
        include('../elements/DropDown.php');
        include('../controller/MasterFile.php');
        $empCode = $_SESSION['userid'];
        $empInfo->SetEmployeeInformation($_SESSION['userid']);
        $empUserType = $empInfo->GetEmployeeUserType();
        $empInfo = new EmployeeInformation();
        $mf = new MasterFile();
        $dd = new DropDown();
        $payrollApplication = new PayrollRegApplication();

            if($empUserType == 'Payroll' or $empUserType == 'Admin') {

            }else{
                        echo '<script type="text/javascript">alert("You do not have access here!");';
                        echo "window.location.href = '../index.php';";
                        echo "</script>";
            }
    }
        
?>
<link rel="stylesheet" type="text/css" href="../payroll/payroll_reg.css">
<script type='text/javascript' src='../payroll/payroll_reg.js'></script>
<script src="<?= constant('NODE'); ?>xlsx/dist/xlsx.core.min.js"></script>
<script src="<?= constant('NODE'); ?>file-saverjs/FileSaver.min.js"></script>
<script src="<?= constant('NODE'); ?>tableexport/dist/js/tableexport.min.js"></script>
<div class="container">
    <div class="section-title">
          <h1>PAYROLL REGISTER VIEW</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-money-check fa-fw'>
                        </i>&nbsp;PAYROLL REGISTER VIEW</b></li>
            </ol>
          </nav>

            <div class="row">
                <div class="col-md-12">
                    <select class="form-control" id="empCode" name="empCode" value="" hidden>
                        <option value="<?php echo $empCode ?>"><?php echo $empCode ?></option>
                    </select>
                        <button type="button" id="search" hidden>GENERATE</button>
                            <?php $payrollApplication->GetPayrollRegList()?>
                </div>
            </div>
    </div>
</div>
<script>
jQuery(function(){
   jQuery('#search').click();
   $(".xprtxcl").prepend('<i class="fas fa-file-export"></i> ');
});


function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("payrollRegList");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

    function ConfirmPayRegView()
    {
       
                var empCode = $('#empCode').children("option:selected").val();
                var url = "../payroll/payrollRegViewProcess.php";

                    swal({
                          title: "Are you sure?",
                          text: "You want to confirm this payroll for approval?",
                          icon: "info",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((savePayroll) => {
                          if (savePayroll) {
                                    
                                    $.post (
                                        url,
                                        {
                                            choice: 1,
                                            emp_code: empCode
                                        },
                                        function(data) { location.reload(true); }
                                    );
                                    swal({text:"Successfully comfirmed the payroll register!",icon:"success"});
                          } else {
            
                            swal({text:"You cancel the confirmation of payroll register!",icon:"error"});
                          }
            });         
    }

    
</script>
<?php include('../_footer.php');  ?>
