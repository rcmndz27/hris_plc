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
            include("../salary/salarylist.php");
            include('../elements/DropDown.php');
            include('../controller/MasterFile.php');
            $allSalaryList = new SalaryList(); 
            $mf = new MasterFile();
            $dd = new DropDown();

        }
        else
        {
            header( "refresh:1;url=../index.php" );
        }

    }    
?>
<script type="text/javascript" src="../salary/salary_ent.js"></script>
<script type='text/javascript' src='../js/validator.js'></script>
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
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
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
    .bb{
        font-weight: bolder;
        text-align: center;
        font-family: -apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol","Noto Color Emoji";
    }
    .cstat {
    color: #e65a5a;
    font-size: 10px;
    text-align: center;
    margin: 0;
    padding: 5px 5px 5px 5px;
    }
    .ppclip{
        height: 50px;
        width: 50px;
        cursor: pointer;
    }
    .ppclip:hover{
        opacity: 0.5;
    }

    .bb{
        font-weight: bolder;
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

.caps{
    text-transform: uppercase;
    font-weight: bolder;
    cursor: pointer;
    margin-bottom: 10px;
}

.addapp{
    color: #ffff;
    font-weight: bolder;
}
.req{
    color: red;
}


.addNewAppBut {
    background-color: #fbec1e;
    color: #ed6200;
    border-color: #fbec1e;
    border-radius: 1em;
}


.addNewAppBut:hover {
    opacity: 0.5;
}

.backbut{
    background-color: #fbec1e;
    border-color: #fbec1e;
    border-radius: 1rem;
    font-size: 20px;
    font-weight: bolder;
    color: #d64747;
}

.backbut:hover{
    opacity: 0.5;
}

.subbut{
    background-color: #ffaa00;
    border-color: #ffaa00;
    font-weight: bolder;
    color: #ffff;
    font-size: 20px;
    border-radius: 1rem;
}

.subbut:hover{
    opacity: 0.5;
}

</style>
<div class="container">
    <div class="section-title">
          <h1>ALL SALARY LIST</h1>
        </div>
    <div class="main-body mbt">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active bb" aria-current="page"><b><i class='fas fa-money-bill-wave fa-fw'>
                        </i>&nbsp;SALARY MANAGEMENT LIST</b></li>
            </ol>
          </nav>
    <div class="pt-3">
        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="bb addNewAppBut" id="salaryEntry"><i class="fas fa-money-bill"></i> ADD NEW EMPLOYEE SALARY </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $allSalaryList->GetAllSalaryList(); ?>

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
                    <h5 class="modal-title bb" id="popUpModalTitle">SALARY ENTRY <i class="fas fa-money-bill"></i></h5>
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
                                        <?php $dd->GenerateDropDown("emp_code", $mf->GetEmployeeSalary("empsal")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="bank_type">Bank Name<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("bank_type", $mf->GetAllBank("bankname")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="bank_no">Bank Account No.</label>
                                        <input type="text" class="form-control inputtext" name="bank_no"
                                            id="bank_no" onkeypress="return onlyNumberKey(event)" placeholder="Account No...." maxlength="15">
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="control-label" for="pay_rate">Payment Type<span class="req">*</span>
                                    </label>                                        
                                        <select type="select" class="form-select" id="pay_rate" name="pay_rate" >
                                            <option value="Monthly">Monthly</option>
                                            <option value="Daily">Daily</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="amount">Payment Rate<span class="req">*</span></label>
                                        <input type="text" class="form-control inputtext" name="amount"
                                            id="amount" onkeypress="return onlyNumberKey(event)" placeholder="000000.00" maxlength="15">
                                    </div>
                                </div> 
                                 <div class="col-lg-6">
                                 </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="status">Status<span class="req">*</span></label>
                                        <input type="text" class="form-control inputtext" name="status"
                                            id="status" value="Active" readonly>                                        
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

    <div class="modal fade" id="updateSal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">UPDATE SALARY ENTRY <i class="fas fa-money-bill"></i></h5>
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
                                        <label class="control-label" for="banktype">Bank Name<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("banktype", $mf->GetAllBank("bankname")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="bank_no">Bank Account No.<span class="req">*</span></label>
                                        <input type="text" class="form-control" name="bankno"
                                            id="bankno" onkeypress="return onlyNumberKey(event)" placeholder="Account No...." maxlength="15">
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                    <label class="control-label" for="pay_rate">Payment Type<span class="req">*</span>
                                    </label>                                        
                                        <select type="select" class="form-select" id="payrate" name="payrate" >
                                            <option value="Monthly">Monthly</option>
                                            <option value="Daily">Daily</option>
                                        </select>
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="amnt">Payment Rate<span class="req">*</span></label>
                                        <input type="text" class="form-control inputtext" name="amnt"
                                            id="amnt" onkeypress="return onlyNumberKey(event)" placeholder="000000.00" maxlength="15">
                                    </div>
                                </div> 
                                 <div class="col-lg-6">
                                 </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="stts">Status<span class="req">*</span></label>
                                        <select type="select" class="form-select" id="stts" name="stts" >
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>                                    
                                    </div>
                                </div>                                                   
                        </div> <!-- form row closing -->
                    </fieldset> 

                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                    <button type="button" class="subbut" onclick="updateSal()" ><i class="fas fa-check-circle"></i> SUBMIT</button>
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



    function editSalaryModal(empcd,banktype,bankno,payrate,amnt,stts){
          
        $('#updateSal').modal('toggle');

        var hidful = document.getElementById('empcode');
        hidful.value =  empcd;   

        var bnkt = document.getElementById('banktype');
        bnkt.value =  banktype;  

        var bno = document.getElementById('bankno');
        bno.value =  bankno;  

        var pyrte = document.getElementById('payrate');
        pyrte.value =  payrate;  

        var at = document.getElementById('amnt');
        at.value =  amnt;  

        var ss = document.getElementById('stts');
        ss.value =  stts;                                  


    }


     function updateSal()
    {

        $("body").css("cursor", "progress");
        var url = "../salary/updatesalary_process.php";
        var emp_code = document.getElementById("empcode").value;
        var bank_type = document.getElementById("banktype").value;
        var bank_no = document.getElementById("bankno").value;
        var pay_rate = document.getElementById("payrate").value;
        var amount = document.getElementById("amnt").value;
        var status = document.getElementById("stts").value;      

        $('#contents').html('');

                        swal({
                          title: "Are you sure?",
                          text: "You want to update this employee salary details?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((verifyApp) => {
                          if (verifyApp) {
                                $.post (
                                    url,
                                    {
                                        action: 1,
                                        emp_code: emp_code ,
                                        bank_type: bank_type ,
                                        bank_no: bank_no ,
                                        pay_rate: pay_rate ,
                                        amount: amount ,               
                                        status: status 
                                        
                                    },
                                    function(data) { $("#contents").html(data).show(); }
                                );

                                swal({text:"Successfully update the employee salary details!",icon:"success"});
                                location.reload();
                          } else {
                            swal({text:"You cancel the updating of employee salary details!",icon:"error"});
                          }
                        });
   
                }
    

</script>


<?php include("../_footer.php");?>
