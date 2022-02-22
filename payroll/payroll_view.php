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
        include('../payroll/payroll.php');
        include('../elements/DropDown.php');
        include('../controller/MasterFile.php');
        $empCode = $_SESSION['userid'];
        $empInfo->SetEmployeeInformation($_SESSION['userid']);
        $empUserType = $empInfo->GetEmployeeUserType();
        $empInfo = new EmployeeInformation();
        $mf = new MasterFile();
        $dd = new DropDown();

            if($empUserType == 'Admin'|| $empUserType == 'Payroll') {

            }else{
                        echo '<script type="text/javascript">alert("You do not have access here!");';
                        echo "window.location.href = '../index.php';";
                        echo "</script>";
            }
    }
        
?>

<link rel="stylesheet" href="../payroll/payroll.css">
<script type='text/javascript' src='../payroll/payroll.js'></script>
<script src="<?= constant('NODE'); ?>xlsx/dist/xlsx.core.min.js"></script>
<script src="<?= constant('NODE'); ?>file-saverjs/FileSaver.min.js"></script>
<script src="<?= constant('NODE'); ?>tableexport/dist/js/tableexport.min.js"></script>
<div id = "myDiv" style="display:none;" class="loader"></div>
<div class="container">
    <div class="section-title">
          <h1>PAYROLL VIEW</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-money-check fa-fw'>
                        </i>&nbsp;PAYROLL VIEW</b></li>
            </ol>
          </nav>

                <div class="form-row">
                    <label for="payroll_period" class="col-form-label pad">PAYROLL PERIOD/LOCATION:</label>
                    <!-- <label for="payroll_period" class="col-form-label mbot pad">Payroll Period/Location:</label> -->
                <div class='col-md-4'>
                    <select class="form-control" id="empCode" name="empCode" value="" hidden>
                        <option value="<?php echo $empCode ?>"><?php echo $empCode ?></option>
                    </select>
                    <?php $dd->GenerateDropDown("ddcutoff", $mf->GetAllCutoffPay("payview")); ?>
                </div>           
                        <button type="button" id="search" class="genpyrll" onclick="generatePayrll()">
                            <i class="fas fa-search-plus"></i> GENERATE                      
                        </button>
                        <button type="button" id="srch" class="gotopay" onclick="show()">
                                <a href="../payroll/payroll_view_register.php" class="payreggoto">
                                <i class="far fa-arrow-alt-circle-right"></i> PAYROLL REGISTER</a>
                        </button>                                          
                </div>
                <div class="row pt-5">
                    <div class="col-md-12 mbot"><br>
                        <div id='contents'></div>
                    </div>
                </div>
        </div>
</div>

<script>

function show() {
    document.getElementById("myDiv").style.display="block";
}

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("payrollList");
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
                $("body").css("cursor", "progress");
                var empCode = $('#empCode').children("option:selected").val();
                var url = "../payroll/payrollViewProcess.php";

                $('#contents').html('');
  
              
                        swal({
                          title: "Are you sure?",
                          text: "You want to save this payroll?",
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
                                        function(data) {window.location.replace("../payroll/payroll_view_register.php"); }
                                    );
                                    // swal({text:"Successfully saved the payroll!",icon:"success"});
                      } else {
                            swal({text:"You cancel the saving of payroll!",icon:"error"});
                          }
                        });

    
    }


    function generatePayrll()
    {
        $("body").css("cursor", "progress");
        var url = "../payroll/payrollrep_process.php";
        var cutoff = $('#ddcutoff').children("option:selected").val();
        var dates = cutoff.split(" - ");
        var empCode = $('#empCode').children("option:selected").val();

        $('#contents').html('');

        $.post (
            url,
            {
                _action: 1,
                _from: dates[0],
                _to: dates[1],
                _location: dates[2],
                _empCode: empCode
                
            },
            function(data) { $("#contents").html(data).show(); }
        );
    }
</script>


<?php include('../_footer.php');  ?>
