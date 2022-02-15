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
            include("../users/userslist.php");
            include('../elements/DropDown.php');
            include('../controller/MasterFile.php');
            $allUsersList = new UsersList(); 
            $mf = new MasterFile();
            $dd = new DropDown();

        }
        else
        {
            header( "refresh:1;url=../index.php" );
        }

    }    
?>
<link rel="stylesheet" href="../users/users.css">
<script type="text/javascript" src="../users/users_ent.js"></script>
<script type='text/javascript' src='../js/validator.js'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<div class="container">
    <div class="section-title">
          <h1>ALL USERS LIST</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active bb" aria-current="page"><b><i class='fas fa-money-bill-wave fa-fw'>
                        </i>&nbsp;USERS MANAGEMENT LIST</b></li>
            </ol>
          </nav>
    <div class="pt-3">
        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="bb addNewAppBut" id="usersEntry"><i class="fas fa-plus-circle"></i> ADD NEW USER ACCOUNT </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $allUsersList->GetAllUsersList(); ?>
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
                    <h5 class="modal-title bb" id="popUpModalTitle">USERS ENTRY  <i class="fas fa-minus-circle"></i></h5>
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
                                        <label class="control-label" for="empcode name">Employee Code/Name<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("emp_code", $mf->GetUserAccntNames("allusracnt")); ?> 
                                    </div>
                                </div> 
                              <div class="col-12">
                                <div class="form-group">
                                 <label class="control-label" for="users_id">User Password<span class="req">*</span>
                                 </label>
                                <div class="input-group mb-3">
                                  <input name="password" type="password"  class="form-control inputtext" id="password" nameplaceholder="Password" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                  <div class="input-group-append">
                                    <span class="input-group-text" onclick="confirmpassword_show_hide();">
                                      <i class="fas fa-eye" id="cfshow_eye"></i>
                                      <i class="fas fa-eye-slash d-none" id="cfhide_eye"></i>
                                    </span>
                                  </div>
                                </div>
                                </div>
                              </div> 
<!--                                 <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="useremail">User Email<span class="req">*</span></label>
                                        <input type="text" class="form-control inputtext" name="useremail"
                                            id="useremail" readonly>    
                                    </div>
                                </div> -->
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="emp_level">User Level<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("emp_level", $mf->GetAllEmployeeLevelWrds("emp_levelwrds")); ?> 
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="status">Status
                                            <span class="req">*</span></label>
                                        <select type="select" class="form-select" id="status" name="status" >
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>                                               
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

<div class="modal fade" id="updateUsrs" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">UPDATE USERS   <i class="fas fa-minus-circle"></i></h5>
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
                                        <label class="control-label" for="empcode name">Employee Code/Name<span class="req">*</span></label>
                                  <input name="empcode" id="empcode" class="form-control" readonly />
                                  <input name="usrid" id="usrid" class="form-control" hidden />
                                    </div>
                                </div> 
                              <div class="col-12">
                                <div class="form-group">
                                 <label class="control-label" for="users_id">User Password<span class="req">*</span>
                                 </label>
                                <div class="input-group mb-3">
                                  <input name="password" type="password"  class="form-control inputtext" id="pssword" nameplaceholder="Password" required="true" aria-label="password" aria-describedby="basic-addon1" />
                                  <div class="input-group-append">
                                    <span class="input-group-text" onclick="password_show_hide();">
                                      <i class="fas fa-eye" id="cfdshow_eye"></i>
                                      <i class="fas fa-eye-slash d-none" id="cfdhide_eye"></i>
                                    </span>
                                  </div>
                                </div>
                                </div>
                              </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="usrtyp">User Level<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("usrtyp", $mf->GetAllEmployeeLevelWrds("emp_levelwrds")); ?> 
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="stts">Status
                                            <span class="req">*</span></label>
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
                                    <button type="button" class="subbut" onclick="updateUsrs()" ><i class="fas fa-check-circle"></i> SUBMIT</button>
                                </div> 
                        </div> <!-- main body closing -->
                    </div> <!-- modal body closing -->
                </div> <!-- modal content closing -->
            </div> <!-- modal dialog closing -->
        </div><!-- modal fade closing -->        

    </div> <!-- main body mbt closing -->
</div><!-- container closing -->

<script>

function confirmpassword_show_hide() {
  var xcfd = document.getElementById("password");
  var cfdshow_eye = document.getElementById("cfdshow_eye");
  var cfdhide_eye = document.getElementById("cfdhide_eye");
  cfdhide_eye.classList.remove("d-none");
  if (xcfd.type === "password") {
    xcfd.type = "text";
    cfdshow_eye.style.display = "none";
    cfdhide_eye.style.display = "block";
  } else {
    xcfd.type = "password";
    cfdshow_eye.style.display = "block";
    cfdhide_eye.style.display = "none";
  }
}

function password_show_hide() {
  var xcf = document.getElementById("pssword");
  var cfshow_eye = document.getElementById("cfshow_eye");
  var cfhide_eye = document.getElementById("cfhide_eye");
  cfhide_eye.classList.remove("d-none");
  if (xcf.type === "password") {
    xcf.type = "text";
    cfshow_eye.style.display = "none";
    cfhide_eye.style.display = "block";
  } else {
    xcf.type = "password";
    cfshow_eye.style.display = "block";
    cfhide_eye.style.display = "none";
  }
}

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("allUsersList");
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

      function editUsrModal(empcd,name,usrtyp,usrmail,stts){

   
        $('#updateUsrs').modal('toggle');

        var hidful = document.getElementById('empcode');
        hidful.value =  name;   

        var bnkt = document.getElementById('usrtyp');
        bnkt.value =  usrtyp;  

        var at = document.getElementById('stts');
        at.value =  stts;  

        var ast = document.getElementById('usrid');
        ast.value =  empcd;  

                                


    }


     function updateUsrs()
    {

        $("body").css("cursor", "progress");
        var url = "../users/updateusers_process.php";
        var emp_code = document.getElementById("usrid").value;
        var userpassword = document.getElementById("pssword").value;
        var status = $('#stts').children("option:selected").val();
        var usertype = $('#usrtyp').children("option:selected").val();


        $('#contents').html('');

                        swal({
                          title: "Are you sure?",
                          text: "You want to update this employee users details?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((updateUsrsd) => {
                          if (updateUsrsd) {
                                $.post (
                                    url,
                                    {
                                        action: 1,
                                        emp_code: emp_code ,
                                        userpassword: userpassword,
                                        status: status,
                                        usertype: usertype
                                        
                                    },
                                    function(data) { $("#contents").html(data).show(); }
                                );

                                swal({text:"Successfully update the employee users details!",icon:"success"});
                                location.reload();
                          } else {
                            swal({text:"You cancel the updating of employee users details!",icon:"error"});
                          }
                        });
   
                }
    

</script>



<?php include("../_footer.php");?>
