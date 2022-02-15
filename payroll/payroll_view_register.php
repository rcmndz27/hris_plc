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
<script type='text/javascript' src='../payroll/payroll_reg.js'></script>
<script src="<?= constant('NODE'); ?>xlsx/dist/xlsx.core.min.js"></script>
<script src="<?= constant('NODE'); ?>file-saverjs/FileSaver.min.js"></script>
<script src="<?= constant('NODE'); ?>tableexport/dist/js/tableexport.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


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
        width: 100%;
        height: 600px;
        display: block;
        overflow-y:auto;
}
.paytop{
text-align: left;
}

.btn-save{
background-color: #b52020;
border-color: #b52020;
color: #ffff;

}
.btn-save:hover{
/*opacity: 0.5;*/
background-color: #b71e1e;
}
.mbot{
    font-weight: bolder;
    font-size: 17px;
    margin-top: -50px;
}

.mleft{
    margin-left: 50px;
}

#myInput {
  background-image: url('../img/searchicon.png');
  background-size: 30px;
  background-position: 5px 5px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;  
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
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
    <span id='pdfres'></span>
</div>
</div>
<br><br>
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

    function ApprovePayView()
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
<script type='text/javascript' src='../js/tableFilter.js'></script>
<?php include('../_footer.php');  ?>
