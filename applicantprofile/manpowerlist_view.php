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
            include("../applicantprofile/manpowerlist.php");
            include('../elements/DropDown.php');
            include('../controller/MasterFile.php');

            $mf = new MasterFile();
            $dd = new DropDown();
            $allManList = new ManpowerList(); 
        }
        else
        {
            header( "refresh:1;url=../index.php" );
        }

    }    
?>
<script type="text/javascript" src="../applicantprofile/manpower_ent.js"></script>
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
          <h1>MANPOWER REQUEST LIST</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active bb" aria-current="page"><b><i class='fas fa-warehouse  fa-fw'>
                        </i>&nbsp;MANPOWER REQUEST LIST</b></li>
            </ol>
          </nav>
    <div class="pt-3">

        <div class="row align-items-end justify-content-end">
            <div class="col-md-12 mb-3">
                <button type="button" class="bb addNewAppBut" id="manpowerEntry"><i class="fas fa-users"></i> ADD NEW MANPOWER REQUEST </button>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel-body">
                    <div id="tableList" class="table-responsive-sm table-body">
                        <?php $allManList->GetAllManpowerList(); ?>
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
                    <h5 class="modal-title bb" id="popUpModalTitle">MANPOWER REQUEST ENTRY <i class="fas fa-users"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
                <div class="modal-body">
            <div class="main-body mbt">
          <form id="applicantform">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="personal" role="tabpanel" aria-labelledby="personal-tab">
                      <fieldset class="fieldset-border">
                            <div class="d-flex justify-content-center">
                                <legend class="fieldset-border pad">
                                </legend>
                             </div>
                            <div class="form-row">
                                    <div class="form-group">
                                        <input type="text" class="form-control inputtext" name="entry_date"
                                            id="entry_date" placeholder="entry date" value="<?php echo date("Y/m/d"); ?>" hidden>    
                                    </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="control-label" for="position">Position<span class="req">*</span></label>
                                        <?php $dd->GenerateDropDown("position", $mf->GetJobPlantilla("jobpla")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="req_ment">Requirement<span class="req">*</span></label>
                                        <input class="form-control inputtext" type="text" onkeypress="return onlyNumberKey(event)"placeholder="00....." maxlength="2" name="req_ment"
                                                                    id="req_ment" /> 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="requirement">Date Needed:<span class="req">*</span></label>
                                        <input class="form-control inputtext" type="date" name="date_needed" id="date_needed" /> 
                                    </div>
                                </div>                                
                                <div class="col-lg-8">
                                </div> 
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label class="control-label" for="status">Status</label>
                                        <input type="text" class="form-control inputtext" name="status"
                                            id="status" placeholder="status" value="Open" readonly>    
                                    </div>
                                </div>                                                                   
                            </div>       
                    </div>
                        </fieldset>
                        </form>
                    </div>
            
</div>

                <div class="modal-footer">
                    <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                    <button type="button" class="subbut" id="Submit" ><i class="fas fa-check-circle"></i> SUBMIT</button>
                </div>
<!-- 
                                            <button type="button" id="search" class="btn btn-small btn-primary mr-1 bup subbut" onmousedown="javascript:filterAtt()">
                            SUBMIT
                            </button>
                            <button type="button" id="search" class="btn btn-small btn-primary mr-1 bup backbut">
                                <a href="../applicantprofile/plantillalist_view.php" class="backtxt">BACK</a>
                            </button> -->
                            

            </div>
        </div>
    </div>
 </div>
</div>

<script>
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("allManList");
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
</script>

<script>
    function onlyNumberKey(evt) {
          
        // Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return swal({text:"Only numbers are allowed!",icon:"error"});;
        return true;
    }
</script>

<?php include("../_footer.php");?>
