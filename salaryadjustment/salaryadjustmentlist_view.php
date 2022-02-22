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
        if ($empUserType == "Admin" || $empUserType == "HR-CreateStaff")
        {
            include("../salaryadjustment/salaryadjustmentlist.php");
            include('../elements/DropDown.php');
            include('../controller/MasterFile.php');
            $allSalaryList = new SalaryAdjList(); 
            $mf = new MasterFile();
            $dd = new DropDown();

        }
        else
        {
            header( "refresh:1;url=../index.php" );
        }

    }    
?>
<link rel="stylesheet" href="../salaryadjustment/salaryadjustmentent.css">
<script type="text/javascript" src="../salaryadjustment/salaryadjustment_ent.js"></script>
<script type='text/javascript' src='../js/validator.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="container">
    <div class="section-title">
          <h1>ALL PAYROLL ADJUSTMENT MANAGEMENT LIST</h1>
        </div>
    <div class="main-body mbt">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active bb" aria-current="page"><b><i class='fas fa-money-bill-wave fa-fw'>
                        </i>&nbsp;PAYROLL ADJUSTMENT MANAGEMENT LIST</b></li>
            </ol>
          </nav>
    <div class="pt-3">
        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="bb addNewAppBut" id="salaryAdjEntry"><i class="fas fa-money-bill"></i> ADD NEW  ADJUSTMENT </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $allSalaryList->GetAllSalaryAdjList(); ?>

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
                    <h5 class="modal-title bb" id="popUpModalTitle">SALARY ADJUSTMENT ENTRY <i class="fas fa-money-bill"></i></h5>
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
                        <div class="form-row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label" for="bank_type">Employee Code/Name<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("emp_code", $mf->GetEmployeeNames("allempnames")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="description">Adjustment Category<span class="req">*</span>
                                        </label>
                                        <input class="form-control inputtext" type="text"  id="description" name="description" placeholder="ex.Salary,Allowances etc.">
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="period_cutoff">Period Cutoff<span class="req">*</span>
                                        </label>
                                        <?php $dd->GenerateDropDown("ddcutoff", $mf->GetCutoffSalAdj("saladj")); ?>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="form-group">
                                    <label class="control-label" for="inc_decr"> &nbsp;
                                    </label> 
                                        <select type="select" class="form-select" id="inc_decr" name="inc_decr" >
                                            <option value="1">+</option>
                                            <option value="0">-<n/option>
                                        </select>                                                                           
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="amount">Adjustment Amount<span class="req">*</span></label>
                                        <input type="number" class="form-control inputtext" name="amount"
                                            id="amount"placeholder="Amount" maxlength="15">
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="remarks">Remarks<span class="req">*</span></label>
                                        <input class="form-control" type="text"  id="remarks" name="remarks" placeholder="Remarks....">
                                    </div>
                                </div>                                                                                  
                        </div> <!-- form row closing -->
                    </fieldset> 

                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                    <button type="button" class="subbut" id="Submit" ><i class="fas fa-check-circle"></i> SUBMIT</button>
                                </div> 
                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->

    <div class="modal fade" id="updateSalAdj" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">UPDATE SALARY ADJUSTMENT ENTRY <i class="fas fa-money-bill"></i></h5>
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
                                        <label class="control-label" for="empcode">Employee Code<span class="req">*</span></label>
                                        <input type="text" class="form-control" name="empcode" id="empcode" readonly>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="descript">Adjustment Category<span class="req">*</span>
                                        </label>
                                        <input class="form-control inputtext" type="text"  id="descript" name="descript">
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="ddcut">Period Cutoff<span class="req">*</span>
                                        </label>
                                        <?php $dd->GenerateDropDown("ddcut", $mf->GetCutoffSalAdj("saladj")); ?>
                                    </div>
                                </div> 
                                <div class="col-lg-2">
                                    <div class="form-group">
                                    <label class="control-label" for="inc_de"> &nbsp;
                                    </label> 
                                        <select type="select" class="form-select" id="inc_de" name="inc_de" >
                                            <option value="+">+</option>
                                            <option value="-">-<n/option>
                                        </select>                                                                           
                                    </div>
                                </div> 
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="amnt">Adjustment Amount<span class="req">*</span></label>
                                        <input type="number" class="form-control inputtext" name="amnt"
                                            id="amnt"placeholder="Amount" maxlength="15">
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="remark">Remarks<span class="req">*</span></label>
                                        <input class="form-control" type="text"  id="remark" name="remark" placeholder="Remarks....">
                                    </div>
                                </div>                                                                                  
                        </div> <!-- form row closing -->
                    </fieldset> 

                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                    <button type="button" class="subbut" onclick="updateSalAdj()" ><i class="fas fa-check-circle"></i> SUBMIT</button>
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
  table = document.getElementById("allSalaryList");
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



    function editSalAdjModal(empcd,percutoff,descrip,amnts,rremark,inc){
          
        $('#updateSalAdj').modal('toggle');

        var hidful = document.getElementById('empcode');
        hidful.value =  empcd;   

        var bnkt = document.getElementById('ddcut');
        bnkt.value =  percutoff;  

        var bno = document.getElementById('descript');
        bno.value =  descrip;  

        var pyrte = document.getElementById('amnt');
        pyrte.value =  amnts;  

        var at = document.getElementById('remark');
        at.value =  rremark;

        var ats = document.getElementById('inc_de');
        ats.value =  inc;  
                            
    }


     function updateSalAdj()
    {

        $("body").css("cursor", "progress");
        var url = "../salaryadjustment/updatesalaryadjustment_process.php";
        var emp_code = document.getElementById("empcode").value;
        var ddcuts = $('#ddcut').children("option:selected").val();
        var ddcutoff = ddcuts.split(" - ");
        var period_from = ddcutoff[0];
        var period_to = ddcutoff[1];
        var description = document.getElementById("descript").value;
        var amount = document.getElementById("amnt").value;
        var inc_decr = document.getElementById("inc_de").value;
        var remarks = document.getElementById("remark").value;  


        // swal(amount);
        // exit();

        $('#contents').html('');

                        swal({
                          title: "Are you sure?",
                          text: "You want to update this employee salary adjustment details?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((updateSlAdj) => {
                          if (updateSlAdj) {
                                $.post (
                                    url,
                                    {
                                        action: 1,
                                        emp_code: emp_code ,
                                        period_from: period_from,
                                        period_to: period_to,
                                        description: description,
                                        amount: amount,
                                        inc_decr: inc_decr,               
                                        remarks: remarks 
                                        
                                    },
                                    function(data) { $("#contents").html(data).show(); }
                                );

                                swal({text:"Successfully update the employee salary adjustment details!",icon:"success"});
                                location.reload();
                          } else {
                            swal({text:"You cancel the updating of employee salary adjustment details!",icon:"error"});
                          }
                        });
   
                }
    

</script>


<?php include("../_footer.php");?>
