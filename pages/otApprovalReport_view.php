<?php
    session_start();

        $empID = $_SESSION['userid'];
        
    if (empty($_SESSION['userid']))
    {
        echo '<script type="text/javascript">alert("Please login first!!");</script>';
        header( "refresh:1;url=../index.php" );
    }
    else
    {
        include('../_header.php');
        include('../controller/otApprovalReport.php');
        include('../elements/DropDown.php');
        include('../controller/MasterFile.php');

        $mf = new MasterFile();
        $dd = new DropDown();
    }
?>
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
.fb{
    font-weight: bolder;
}
</style>
<div class="container">
    <div class="section-title">
          <h1>OT APPROVAL REPORT</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-suitcase fa-fw'>
                        </i>&nbsp;OT APPROVAL REPORT</b></li>
            </ol>
          </nav>

        <div class="form-row pt-3">
                <label for="payroll_period" class="col-form-label pad">PAYROLL PERIOD/LOCATION:</label>
                <div class='col-md-4'>
                    <select class="form-control" id="empCode" name="empCode" value="" hidden>
                        <option value="<?php echo $empCode ?>"><?php echo $empCode ?></option>
                    </select>
                    <?php $dd->GenerateDropDown("ddcutoff", $mf->GetAllCutoffPay("payview")); ?>
                </div>
                        <button type="button" id="search" class="genpyrll" onmousedown="javascript:filterAtt()">
                        <i class="fas fa-search-plus"></i> GENERATE                      
                        </button>
        </div>
            <div class="row pt-5">
                <div class="col-md-12 mbot">
                    <div id='contents'></div>
                </div>
            </div>
    </div>
</div>
<br><br>


<script>
    function filterAtt()
    {
        $("body").css("cursor", "progress");
        var url = "../controller/otApprovalReportProcess.php";
        var cutoff = $('#ddcutoff').children("option:selected").val();
        var dates = cutoff.split(" - ");

        $('#contents').html('');

        $.post (
            url,
            {
                _action: 1,
                _from: dates[0],
                _to: dates[1],
                _rpt: '<?= $empID; ?>'
            },
            function(data) { $("#contents").html(data).show(); }
        );
    }

    function filterAttAll()
    {
        $("body").css("cursor", "progress");
        var url = "../controller/otApprovalReportProcess.php";
        var cutoff = $('#ddcutoff').children("option:selected").val();
        var dates = cutoff.split(" - ");

        $('#contents').html('');

        $.post (
            url,
            {
                _action: 0,
                _from: dates[0],
                _to: dates[1]
            },
            function(data) { $("#contents").html(data).show(); }
        );
    }

function ExportToPDF(status)
{
    var cutoff = $('#ddcutoff').children("option:selected").val();
    var dates = cutoff.split(" - ");
    var rpt = "<?= $empID; ?>";

    if (status == 0)
    {
        window.open('../controller/PDFExporter.php?id=' + '&dfrom=' + dates[0] + '&dto=' + dates[1], '_blank');
    }
    else if (status == 1)
    {
        window.open('../controller/PDFExporter.php?id=' + rpt + '&dfrom=' + dates[0] + '&dto=' + dates[1], '_blank');
    }
    else { }
}
</script>

<?php  include('../_footer.php');  ?>