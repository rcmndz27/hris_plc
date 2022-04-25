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
        include('../payslip/payslips.php');
        include('../elements/DropDown.php');
        include('../controller/MasterFile.php');

        $mf = new MasterFile();
        $dd = new DropDown();
        $empCode = $_SESSION['userid'];

        $empInfo = new EmployeeInformation();

        $empInfo->SetEmployeeInformation($_SESSION['userid']);
    }
        
?>
<link rel="stylesheet" type="text/css" href="../payslip/payslip.css">
<script src="../js/pdf.js" ></script>
<div id = "myDiv" style="display:none;" class="loader"></div>
<div class="container">
    <div class="section-title">
          <h1>PAYSLIP VIEW</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-money-bill-wave fa-fw'>
                        </i>&nbsp;PAYSLIP VIEW</b></li>
            </ol>
          </nav>

        <div class="form-row pt-3">
                    <select class="form-control" id="empCode" name="empCode" value="" hidden>
                        <option value="<?php echo $empCode ?>"><?php echo $empCode ?></option>
                    </select>
                    <select class="form-control" id="empName" name="empName" value="" hidden>
                        <option value="<?php echo $empName ?>"><?php echo $empName ?></option>
                    </select>
                  <label for="payroll_period" class="col-form-label pad">PAYROLL PERIOD:</label>

                <div class='col-md-3'>
                    <?php $dd->GenerateDropDown("ddcutoff", $mf->GetAllPayCutoff("paycut")); ?>
                </div>

                <div class="col-md-3 d-flex">
                        <button type="button" id="search" class="genpyrll" onclick="genePayrl()" ><i class="fas fa-search-plus"></i>GENERATE                    
                        </button>
                        <a href='javascript:generatePDF()'><img src="../img/expdf.png" height="40" class="pdfimg" id='expdf'></a>
                </div>
        </div>
      <div class="row pt-2">
        <div class="col-md-12 mbot d-flex justify-content-center">
            <div id='contents'></div>
        </div>
    </div>
    <span id='pdfres'></span>
</div>
</div>

<script type="text/javascript">
    
        $('#expdf').hide();


    function genePayrl()
    {

        $('#expdf').show();
        document.getElementById("myDiv").style.display="block";
        $("body").css("cursor", "progress");
        var url = "../payslip/payslips_process.php";
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
                _empCode: empCode
                
            },
            function(data) { $("#contents").html(data).show(); 
            document.getElementById("myDiv").style.display="none";}

        );
    }

function generatePDF() {

  // console.log('converting...');
  var printableArea = document.getElementById('payslipsList');

  html2canvas(printableArea, {
    useCORS: true,
    onrendered: function(canvas) {

      var pdf = new jsPDF('p', 'pt', 'letter');

      var pageHeight = 980;
      var pageWidth = 900;
      for (var i = 0; i <= printableArea.clientHeight / pageHeight; i++) {
        var srcImg = canvas;
        var sX = 0;
        var sY = pageHeight * i; // start 1 pageHeight down for every new page
        var sWidth = pageWidth;
        var sHeight = pageHeight;
        var dX = 0;
        var dY = 0;
        var dWidth = pageWidth;
        var dHeight = pageHeight;

        window.onePageCanvas = document.createElement("canvas");
        onePageCanvas.setAttribute('width', pageWidth);
        onePageCanvas.setAttribute('height', pageHeight);
        var ctx = onePageCanvas.getContext('2d');
        ctx.drawImage(srcImg, sX, sY, sWidth, sHeight, dX, dY, dWidth, dHeight);

        var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);
        var width = onePageCanvas.width;
        var height = onePageCanvas.clientHeight;

        if (i > 0) // if we're on anything other than the first page, add another page
          pdf.addPage(612, 791); // 8.5" x 11" in pts (inches*72)

        pdf.setPage(i + 1); // now we declare that we're working on that page
        pdf.addImage(canvasDataURL, 'PNG', 20, 40, (width * .62), (height * .62)); // add content to the page

      }

      var name = $('#empName').val();
      pdf.save('payslip' + name +  '.pdf');
    }
  });
}
</script>

<?php include('../_footer.php');  ?>
