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
            include("../allowances/allowanceslist.php");
            include('../elements/DropDown.php');
            include('../controller/MasterFile.php');
            $allAllowancesList = new AllowancesList(); 
            $mf = new MasterFile();
            $dd = new DropDown();


        if ($empUserType == 'Admin' || $empUserType == 'HR Generalist' ||$empUserType == 'HR Manager' || $empUserType == 'Group Head')
        {
  
        }else{
            echo '<script type="text/javascript">swal({text:"You do not have access here!",icon:"error"});';
            echo "window.location.href = '../index.php';";
            echo "</script>";
        } 

    }    
?>
<link rel="stylesheet" type="text/css" href="../allowances/all_view.css">
<script type="text/javascript" src="../allowances/allowances_ent.js"></script>
<script type='text/javascript' src='../js/validator.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="container">
    <div class="section-title">
          <h1>ALL ALLOWANCE LIST</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active bb" aria-current="page"><b><i class='fas fa-money-bill-wave fa-fw'>
                        </i>&nbsp;ALLOWANCE MANAGEMENT LIST</b></li>
            </ol>
          </nav>
    <div class="pt-3">
        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="bb addNewAppBut" id="allowancesEntry"><i class="fas fa-money-check"></i> ADD NEW EMPLOYEE ALLOWANCE</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $allAllowancesList->GetAllAllowancesList(); ?>
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
                    <h5 class="modal-title bb" id="popUpModalTitle">ALLOWANCES ENTRY <i class="fas fa-money-check"></i> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
        <div class="modal-body">
            <div class="main-body">
                <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad">
                                </legend>
                             </div>
                        <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label" for="bank_type">Employee Code/Name<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("emp_code", $mf->GetEmployeeNames("allempnames")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="benefit_id">Allowance Name<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("benefit_id", $mf->GetAllEmployeeAllowances("benlist")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="period_cutoff">Period Cutoff<span class="req">*</span>
                                        </label>
                                        <select type="select" class="form-select" id="period_cutoff" name="period_cutoff" >
                                            <option value="Both">Both</option>
                                            <option value="First Half">First Half</option>
                                            <option value="Second Half">Second Half</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="control-label" for="effectivity_date">Effectivity Date<span class="req">*</span>
                                    </label>                                        
                                        <input type="date" class="form-control inputtext" name="effectivity_date"
                                            id="effectivity_date" min="<?php  echo date('Y-m-d'); ?>" value="<?php  echo date('Y-m-d'); ?>" onkeydown="return false">
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="amount">Allowance Amount<span class="req">*</span></label>
                                        <input class="form-control" type="number"  id="amount" name="amount" step=".01">
                                    </div>
                                </div>                                                   
                        </div> <!-- form row closing -->
                    </fieldset> 

                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                    <button type="button" class="subbut" id="Submit"  ><i class="fas fa-check-circle"></i> SUBMIT</button>
                                </div> 
                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->

    <div class="modal fade" id="updateAlw" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">UPDATE ALLOWANCES <i class="fas fa-money-check"></i> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
        <div class="modal-body">
            <div class="main-body">
                <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad">
                                </legend>
                             </div>
                        <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label" for="bank_type">Employee Code<span class="req">*</span></label>
                                        <input type="text" class="form-control" name="empcode" id="empcode" readonly>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="benefitid">Allowance Name<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("benefitid", $mf->GetAllEmployeeAllowances("benlist")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="periodcutoff">Period Cutoff<span class="req">*</span>
                                        </label>
                                        <select type="select" class="form-select" id="periodcutoff" name="periodcutoff" >
                                            <option value="Both">Both</option>
                                            <option value="First Half">First Half</option>
                                            <option value="Second Half">Second Half</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="control-label" for="effectivitydate">Effectivity Date<span class="req">*</span>
                                    </label>                                        
                                        <input type="date" class="form-control" name="effectivitydate"
                                            id="effectivitydate">
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="amnt">Allowance Amount<span class="req">*</span></label>
                                        <input class="form-control" type="number"  id="amnt" name="amnt" step=".01">
                                    </div>
                                </div>                                                   
                        </div> <!-- form row closing -->
                    </fieldset> 

                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                    <button type="button" class="subbut" onclick="updateAlw()"  ><i class="fas fa-check-circle"></i> SUBMIT</button>
                                </div> 

                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->        

    </div> <!-- main body mbt closing -->
</div><!-- container closing -->


<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("allAllowancesList");
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

    function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return swal({text:"Only numbers are allowed!",icon:"error"});;
        return true;
    }

 function editAlwModal(empcd,benname,periodcutoff,amnt,effectivitydate){

   
        $('#updateAlw').modal('toggle');

        var hidful = document.getElementById('empcode');
        hidful.value =  empcd;   

        var bnkt = document.getElementById('benefitid');
        bnkt.value =  benname;  

        var bno = document.getElementById('periodcutoff');
        bno.value =  periodcutoff;  

        var at = document.getElementById('amnt');
        at.value =  amnt;  

        var ss = document.getElementById('effectivitydate');
        ss.value =  effectivitydate;                                  


    }


     function updateAlw()
    {

        $("body").css("cursor", "progress");
        var url = "../allowances/updateallowances_process.php";
        var emp_code = document.getElementById("empcode").value;
        var benefitid = $('#benefitid').children("option:selected").val();
        var benefit_id = benefitid.split(" - ");
        var period_cutoff = document.getElementById("periodcutoff").value;
        var amount = document.getElementById("amnt").value;
        var effectivity_date = document.getElementById("effectivitydate").value; 

        $('#contents').html('');

                        swal({
                          title: "Are you sure?",
                          text: "You want to update this allowances deduction details?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((updateAlw) => {
                          if (updateAlw) {
                                $.post (
                                    url,
                                    {
                                        action: 1,
                                        emp_code: emp_code ,
                                        benefit_id: benefit_id[0],
                                        period_cutoff: period_cutoff,
                                        amount: amount ,               
                                        effectivity_date: effectivity_date 
                                        
                                    },
                                    function(data) { $("#contents").html(data).show(); }
                                );

                                swal({text:"Successfully update the employee allowances details!",icon:"success"});
                                location.reload();
                          } else {
                            swal({text:"You cancel the updating of employee allowances details!",icon:"error"});
                          }
                        });
   
                }
    



</script>


<?php include("../_footer.php");?>
