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
            include("../mf_company/mfcompanylist.php");
            include('../elements/DropDown.php');
            include('../controller/MasterFile.php');
            $allMfcompanyList = new MfcompanyList(); 
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
<link rel="stylesheet" href="../mf_company/mfcompany.css">
<script type="text/javascript" src="../mf_company/mfcompany_ent.js"></script>
<script type='text/javascript' src='../js/validator.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<div class="container">
    <div class="section-title">
          <h1>ALL COMPANY  LIST</h1>
        </div>
    <div class="main-body mbt">
          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active bb" aria-current="page"><b><i class='fas fa-warehouse'>
                        </i>&nbsp;COMPANY LIST</b></li>
            </ol>
          </nav>
    <div class="pt-3">
        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="bb addNewAppBut" id="mfcompanyEntry"><i class="fas fa-warehouse"></i> ADD NEW COMPANY </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $allMfcompanyList->GetAllMfcompanyList(); ?>

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
                    <h5 class="modal-title bb" id="popUpModalTitle">COMPANY ENTRY <i class="fas fa-warehouse"></i></h5>
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
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="code">Company Code<span class="req">*</span></label>
                                        <input type="text" style="text-transform:uppercase" class="form-control inputtext" name="code" id="code" placeholder="CMP....." maxlength="3" >
                                    </div>
                                </div> 
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="control-label" for="descs">Company Name<span class="req">*</span></label>
                                        <input type="text" class="form-control inputtext" name="descs"
                                            id="descs" placeholder="Company Name....." > 
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

    <div class="modal fade" id="updateMfcmp" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">UPDATE COMPANY <i class="fas fa-warehouse"></i></h5>
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
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="cde">Company Code<span class="req">*</span></label>
                                        <input type="text" class="form-control inputtext" name="cde"
                                            id="cde" maxlength="3">
                                    </div>
                                </div> 
                                <div class="col-lg-9">
                                    <div class="form-group">
                                        <label class="control-label" for="dscs">Company Name<span class="req">*</span></label>
                                        <input type="text" class="form-control inputtext" name="dscs"
                                            id="dscs"> 
                                    </div>
                                </div> 
                                <input type="text" class="form-control" name="rowd"
                                            id="rowd" hidden> 

                        </div> <!-- form row closing -->
                    </fieldset> 

                                <div class="modal-footer">
                                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                    <button type="button" class="subbut" onclick="updateMfcmp()" ><i class="fas fa-check-circle"></i> SUBMIT</button>
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
  table = document.getElementById("allMfcompanyList");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
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

    function editMfcompanyModal(id,desc,name){
          
        $('#updateMfcmp').modal('toggle');

        var hidful = document.getElementById('rowd');
        hidful.value =  id;   

        var bnkt = document.getElementById('cde');
        bnkt.value =  desc;  

        var bno = document.getElementById('dscs');
        bno.value =  name;  
                                 

    }


     function updateMfcmp()
    {

        $("body").css("cursor", "progress");
        var url = "../mf_company/updatemfcompany_process.php";
        var rowid = document.getElementById("rowd").value;
        var code = document.getElementById("cde").value;
        var descs = document.getElementById("dscs").value;     

        $('#contents').html('');

                        swal({
                          title: "Are you sure?",
                          text: "You want to update this company type?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((updateMfcmp) => {
                          if (updateMfcmp) {
                                $.post (
                                    url,
                                    {
                                        action: 1,
                                        rowid: rowid ,
                                        code: code ,
                                        descs: descs 
                                        
                                    },
                                    function(data) { $("#contents").html(data).show(); }
                                );

                                swal({text:"Successfully update the company details!",icon:"success"});
                                location.reload();
                          } else {
                            swal({text:"You cancel the updating of company details!",icon:"error"});
                          }
                        });
   
                }
    

</script>


<?php include("../_footer.php");?>
