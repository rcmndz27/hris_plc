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
            include("../applicantprofile/plantillalist.php");
            include('../elements/DropDown.php');
            include('../controller/MasterFile.php');

            $mf = new MasterFile();
            $dd = new DropDown();
            $allPlaList = new PlantillaList(); 
            
       if ($empUserType == 'Admin' || $empUserType == 'HR Generalist' ||$empUserType == 'HR Manager' || $empUserType == 'Group Head')
        {
  
        }else{
            echo '<script type="text/javascript">swal({text:"You do not have access here!",icon:"error"});';
            echo "window.location.href = '../index.php';";
            echo "</script>";
        }

    }    
?>
<script type="text/javascript" src="../applicantprofile/plantilla_ent.js"></script>
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
        font-family: "Dosis", sans-serif;
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
        font-family: "Dosis", sans-serif;
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
          <h1>PLANTILLA LIST</h1>
        </div>
<div class="main-body mbt">
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active bb" aria-current="page"><b><i class='fas fa-warehouse  fa-fw'>
                        </i>&nbsp;PLANTILLA LIST</b></li>
            </ol>
          </nav>
            <div class="pt-3">
                <div class="row align-items-end justify-content-end">
                    <div class="col-md-12 mb-3">
                        <button type="button" class="bb addNewAppBut" id="plantillaEntry"><i class="fas fa-plus-circle"></i> ADD NEW PLANTILLA </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="panel-body">
                            <div id="tableList" class="table-responsive-sm table-body">
                                <?php $allPlaList->GetAllPlantillaList(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <div class="modal fade" id="popUpModal" tabindex="-1" role="dialog" aria-labelledby="informationModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title bb" id="popUpModalTitle">PLANTILLA ENTRY  <i class="fas fa-plus-circle"></i></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times; </span>
                    </button>
                </div>
            <div class="modal-body">
                <div class="main-body mbt">
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
                                        <label class="control-label" for="Department">Department</label>
                                        <?php $dd->GenerateDropDown("department", $mf->GetAllDepartment("alldep")); ?> 
                                    </div>
                                </div>  
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="presentAddress">Position</label>
                                        <?php $dd->GenerateDropDown("position", $mf->GetJobPosition("jobpos")); ?> 
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="control-label" for="presentAddress">Reporting To</label>
                                        <?php $dd->GenerateDropDown("reporting_to", $mf->GetJobPosition("jobpos")); ?> 
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
                        </fieldset>
                            <div class="modal-footer">
                                <button type="button" class="backbut" data-dismiss="modal"><i class="fas fa-times-circle"></i> CANCEL</button>
                                <button type="button" class="subbut" id="Submit" ><i class="fas fa-check-circle"></i> SUBMIT</button>
                            </div>                                 
                        </div>
                    </div>    
                    
                    </div>
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
  table = document.getElementById("allPlaList");
  tr = table.getElementsByTagName("tr");
for (i = 0; i < tr.length; i++) {
   td = tr[i].getElementsByTagName("td");
    if(td.length > 0){ // to avoid th
       if (td[0].innerHTML.toUpperCase().indexOf(filter) > -1 || td[1].innerHTML.toUpperCase().indexOf(filter) > -1 
        || td[2].innerHTML.toUpperCase().indexOf(filter) > -1  || td[3].innerHTML.toUpperCase().indexOf(filter) > -1 ) {
         tr[i].style.display = "";
       } else {
         tr[i].style.display = "none";
       }

    }
 }
}
</script>
<script>
    function activatePlant(data)
    {       
     
        $("body").css("cursor", "progress");
        var url = "../applicantprofile/activate_plaent_process.php";
        var status = 'Active';
        var rowid = data;

        $('#contents').html('');


                        swal({
                          title: "Are you sure?",
                          text: "You want to activate this plantilla?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((actPlaent) => {
                          if (actPlaent) {
                                $.post (
                                    url,
                                    {
                                        action: 1,
                                        status: status ,
                                        rowid: rowid                
                                    },
                                    function(data) { $("#contents").html(data).show(); }
                                );
                            swal({text:"Successfully activated the plantilla!",icon:"success"});
                            location.reload();
                          } else {
                            swal({text:"You cancel the activating of plantilla!",icon:"error"});
                          }
                        });


    }

    function deactivatePlant(data)
    {
 
        $("body").css("cursor", "progress");
        var url = "../applicantprofile/activate_plaent_process.php";
        var status = 'De-Activated';
        var rowid = data;

        $('#contents').html('');


                        swal({
                          title: "Are you sure?",
                          text: "You want to de-activate this plantilla?",
                          icon: "success",
                          buttons: true,
                          dangerMode: true,
                        })
                        .then((deactPlaent) => {
                          if (deactPlaent) {
                                $.post (
                                    url,
                                    {
                                        action: 1,
                                        status: status ,
                                        rowid: rowid                
                                    },
                                    function(data) { $("#contents").html(data).show(); }
                                );
                            swal({text:"Successfully de-activated the plantilla!",icon:"success"});
                            location.reload();
                          } else {
                            swal({text:"You cancel the de-activateing of plantilla!",icon:"error"});
                          }
                        });
    }
</script>

<?php include("../_footer.php");?>
