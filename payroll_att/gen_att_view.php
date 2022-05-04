<?php


session_start();

if (empty($_SESSION['userid']))
{

    include_once('../loginfirst.php');
    exit();
}
else
{

    include('../_header.php');
    include('../payroll_att/gen_att.php');
    include('../elements/DropDown.php');
    include('../controller/MasterFile.php');

    $mf = new MasterFile();
    $dd = new DropDown();
    $empCode = $_SESSION['userid'];

    if ($empUserType == 'Admin' || $empUserType == 'HR Generalist' ||$empUserType == 'HR Manager' || $empUserType == 'Group Head')
    {

    }else{
        echo '<script type="text/javascript">swal({text:"You do not have access here!",icon:"error"});';
        echo "window.location.href = '../index.php';";
        echo "</script>";
    }

}

?>

<link rel="stylesheet" type="text/css" href="../payslip/payslip.css">
<div id = "myDiv" style="display:none;" class="loader"></div>
<div class="container">
    <div class="section-title">
      <h1>GENERATE ATTENDANCE FOR PAYROLL</h1>
  </div>
  <div class="main-body mbt">
      <nav aria-label="breadcrumb" class="main-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-money-check fa-fw'>
          </i>&nbsp;GENERATE ATTENDANCE FOR PAYROLL </b></li>
      </ol>
  </nav>

  <div class="form-row pt-3">
    <label for="employeepaylist" class="col-form-label pad">PAYROLL PERIOD:</label>
    <div class="col-md-3">      
        <?php $dd->GenerateDropDown("ungenpco", $mf->GetUnGenPayrollCutoff("ungenpco")); ?>
    </div>

    <div class="col-md-3 d-flex">
        <button type="button" id="search" class="genpyrll" onclick="updateMfhol();">
            <i class="fas fa-search-plus"></i>GENERATE                       
        </button>  
        <input type="text" name="eMplogName" id="eMplogName" value="<?php echo $empName ?>" hidden>                  
    </div>
</div>
</div>
</div>

<script type="text/javascript">

    function updateMfhol()
    {

        var url = "../payroll_att/gen_att_process.php";
        var date = $('#ungenpco').children("option:selected").val();
        var dates = date.split(" - ");
        var eMplogName = $('#eMplogName').val();

        // console.log(dates[0]);  
        // console.log(dates[1]);  
        // console.log(eMplogName);
        // return false;
        swal({
          title: "Are you sure?",
          text: "You want to generate this attendance?",
          icon: "success",
          buttons: true,
          dangerMode: true,
      })
        .then((updateMfhol) => {
          document.getElementById("myDiv").style.display="block";
          if (updateMfhol) {
            $.post (
                url,
                {
                    action: 1,
                    pyrollco_from: dates[0] ,
                    pyrollco_to: dates[1] ,
                    eMplogName: eMplogName                           
                },
                function(data) {                   
                    swal({
                        title: "Wow!", 
                        text: "Successfully generated attendance!", 
                        type: "success",
                        icon: "success",
                    }).then(function() {                        
                        location.href = '../payroll/payroll_view.php';
                    });  
                });
        } else {
            document.getElementById("myDiv").style.display="none";
            swal({text:"You cancel the generation of attendance!",icon:"error"});
        }
    });

    }

</script>
<?php include('../_footer.php');  ?>
