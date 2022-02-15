<?php


    session_start();

    if (empty($_SESSION['userid']))
    {

        echo '<script type="text/javascript">alert("Please login first!!");</script>';
        header( "refresh:1;url=../index.php" );
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

    }
        
?>


<!-- <script type='text/javascript' src='../payslip/payslips.js'></script>	 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js" ></script>
<style type="text/css">
    
 table,

            th,
            td {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 3px 3px 3px 3px;
                border-color: black;
                background-color: #ffff;
                /*font-style: italic;*/
                font-size: 15px;

            }
  
            table {
                /*width: 600px;*/
                display: block;
                overflow-y:auto;
                overflow-x:auto;
                padding: 20px 20px 20px 20px;
                color: black;
                /*background-image: url('../img/payroll4.png');*/
            }
.btn-save{
background-color: #b52020;
border-color: #b52020;
color: #ffff;

}
.paybg{
background-color: #D9E1F2;
}

.grossbg{
background-color: #B4C6E7;
}

.dedbg{
background-color: #FFF2CC;
}
.subbg{
background-color: #FFE699;
}
.netbg{
background-color: #C6E0B4;
}
.btn-save:hover{
/*opacity: 0.5;*/
background-color: #b71e1e;
}
.mbot{
    font-weight: bolder;    
    font-size: 17px;
}
.pdfimg:hover{
    opacity: 0.5;
    cursor: pointer;
}

.mleft{
    margin-left: 30px;
}
.bgen{
    font-weight: bolder;
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
</style>
<div class="container">
    <div class="section-title">
          <h1>PAYROLL REGISTER VIEW</h1>
        </div>
    <div class="main-body mbt">

          <!-- Breadcrumb -->
          <nav aria-label="breadcrumb" class="main-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item active" aria-current="page"><b><i class='fas fa-money-check fa-fw'>
                        </i>&nbsp;PAYROLL REGISTER VIEW</b></li>
            </ol>
          </nav>

      <div class="form-row pt-3">
                <label for="employeepaylist" class="col-form-label pad">EMPLOYEE:</label>
                <div class="col-md-6">      
                        <?php $dd->GenerateDropDown("emppay", $mf->GetAllEmployeePay("emppay")); ?>
                </div>

                <div class="col-md-3 d-flex">
                        <button type="button" id="search" class="genpyrll" onmousedown="javascript:filterAtt()">
                            <i class="fas fa-search-plus"></i>GENERATE                       
                        </button>
                        <a href='javascript:generatePDF()'><img src="../img/expdf.png" height="40" class="pdfimg" id='expdf'></a>                        
                </div>

        </div>

    <div class="row pt-5">
        <div class="col-md-12 mbot">
            <div class="d-flex justify-content-center">
                <div id='contents'></div>     
            </div>
        </div>
    </div>
</div>
</div>
<br><br>
<script type="text/javascript">
        $('#expdf').hide();
        $('#search').click(function(e){
            var showpay = $('#showpay').val();  
                if(showpay === 'ok'){
                    $('#expdf').show();
                }else{
                    $('#expdf').hide();
                }
    });
</script>
<script>



    function filterAtt()
    {
        $("body").css("cursor", "progress");
        var url = "../payslip/payslips_process.php";
        var cutoffe = $('#emppay').children("option:selected").val();
        var data = cutoffe.split(" - ");
        $('#expdf').show();

        $('#contents').html('')

        $.post (
            url,
            {
                _action: 1,
                _empCode: data[0],
                _from: data[2],
                _to: data[3]
                
            },
            function(data) { $("#contents").html(data).show(); }
        );
    }
</script>
<script type="text/javascript">
function generatePDF() {
  console.log('converting...');

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

        pdf.setPage(i + 1); 
        pdf.addImage(canvasDataURL, 'PNG', 20, 40, (width * .62), (height * .62)); 

      }
      pdf.save('payslip.pdf');
    }
  });
}
</script>
<?php include('../_footer.php');  ?>
