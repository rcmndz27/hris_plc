<?php

    include('../config/db.php');

    $dateFinal = explode(' - ', $_POST['row']);

    $cmd = $connL->prepare(@"SELECT * FROM dbo.payroll where date_from = :df AND date_to = :dt AND employee = :emp");
    $cmd->bindValue(':df', $dateFinal[0]);
    $cmd->bindValue(':dt', $dateFinal[1]);
    $cmd->bindValue(':emp', $_POST['empName']);
    $cmd->execute();

    $data = array();

    while ($r = $cmd->fetch(PDO::FETCH_BOTH))
    {
        array_push($data,
            $r[0], $r[1], $r[2], $r[3], $r[4], $r[5], $r[6], $r[7], $r[8], $r[9],
            $r[10], $r[11], $r[12], $r[13], $r[14], $r[15], $r[16], $r[17], $r[18], $r[19],
            $r[20], $r[21], $r[22], $r[23], $r[24], $r[25], $r[26], $r[27], $r[28], $r[29],
            $r[30], $r[31], $r[32], $r[33], $r[34], $r[35], $r[36], $r[37], $r[38], $r[39],
            $r[40], $r[41], $r[42], $r[43], $r[44], $r[45], $r[46], $r[47], $r[48], $r[49],
            $r[50], $r[51], $r[52], $r[53]
        );
    }

    $dateF = date("F d, Y", strtotime($data[2]));
    $dateT = date("F d, Y", strtotime($data[3]));

    $data[2] = $dateF;
    $data[3] = $dateT;

?>

<script type='text/javascript'>
    function CenterText(text, y) {
        var textWidth = doc.getStringUnitWidth(text) * doc.internal.getFontSize() / doc.internal.scaleFactor;
        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
        doc.text(textOffset, y, text);
    }

    function UnderlineText(pdoc, text, x, y)
    {
        const textWidth = pdoc.getTextWidth(text);
        pdoc.line(x, y, x + textWidth, y)
    }

    var doc = new jsPDF();
    var logoImg;
    
    // START - Header
    doc.setDrawColor(0, 0, 0);
    doc.setLineWidth(7.0);
    doc.line(10, 6.5, doc.internal.pageSize.width - 10, 6.5);

    doc.setFont("Calibri");
    doc.setFontSize(11);
    doc.setFontType("bold");
    doc.setTextColor(255,255,255);
    CenterText("PREMIUM MEGASTRUCTURES INC.", 8);
    // END - Header

    // START - Logo

    var img = new Image();
    img.src = '../img/logo-payslip.jpg';
    img.onload = function() {
        doc.addImage(img, 'JPEG', 80, 11.5, 50, 18);
        doc.output('dataurlnewwindow');
        $('#contents').html('');
    }

    // END - Logo

    // START - Body

    // Start - Label Dimensions

    var l1x = 12.5;
    var l2x = 42.5;
    var l3x = 106;
    var l4x = 136;
    var lstartRow = 35;

    // End - Label Dimensions

    // Start - Box Dimensions
    
    function createBox(pdoc, opt, x, y)
    {
        pdoc.setLineWidth(0.1);
        pdoc.setFillColor(0,0,0);

        switch(opt)
        {
            case "a":
                pdoc.rect(x, y, 29.9, 5, 'D');
                break;
            case "b":
                pdoc.rect(x, y, 63.5, 5, 'D');
                break;
            default:
                break;
        }
    }

    var c1x = 11;
    var c2x = 41;
    var c3x = 104.5;
    var c4x = 134.5;
    var cstartRow = 31.35;

    // End - Box Dimenstions

    // ROW 1
    doc.setFontSize(9);
    doc.setFontType("normal");
    doc.setTextColor(0,0,0);

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Name");

    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[1]; ?>");

    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Date Viewed");

    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo date('F d, Y'); ?>");

    // ROW 2
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Level");

    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[5]; ?>");

    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Cutoff Covered");

    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[2] . ' - ' . $data[3]; ?>");

    // ROW 3
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Daily Rate");

    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[9]; ?>");

    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Location");

    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "Makati");

    // ROW 4
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;
    
    createBox(doc, "a", c1x, cstartRow);
    createBox(doc, "b", c2x, cstartRow);
    createBox(doc, "a", c3x, cstartRow);
    createBox(doc, "b", c4x, cstartRow);

    // ROW 5
    doc.setFontType("bold");
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "INCOME");
    UnderlineText(doc, "INCOME", l1x, lstartRow + .5)

    createBox(doc, "b", c2x, cstartRow);

    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "DEDUCTIONS");
    UnderlineText(doc, "DEDUCTIONS", l3x, lstartRow + .5)

    createBox(doc, "b", c4x, cstartRow);

    // ROW 6
    doc.setFontType("normal");
    doc.setFontSize(6.5);
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Basic Pay");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[8]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Withholding Tax");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[31]; ?>");

////////////////////////////////////////////////////////////////////////// FIX VALUE /////////////////////////////////////////////////////////////////////////////////////

    // ROW 7
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Absences");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[8]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "SSS Contribution - EE");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[31]; ?>");

    // ROW 8
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "late");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[19]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "PhilHealth Contribution - EE");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[30]; ?>");

    // ROW 9
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Undertime");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[21]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Pag-ibig Contribution - EE");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[29]; ?>");

    // ROW 10
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Salary Adjustment");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo " "; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Pag-ibig Loan");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[35]; ?>");

    // ROW 11
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Regular Overtime");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[16]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Pag-ibig Calamity Loan");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 12
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Rest Day OT");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo " "; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "SSS Loan");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[34]; ?>");

    // ROW 13
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Special Holiday Pay");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo " "; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "SSS Calamity Loan");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 14
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Regular Holiday Pay");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo " "; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Company Loan");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 15
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Night Differential Pay");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[23]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "OMHAS (Advances)");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 16
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "OT Adjustments");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[24]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Salary Deductions");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[36]; ?>");

    // ROW 17
    doc.setFontType("bold");
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "GROSS TAXABLE");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo " "; ?>");
    
    doc.setFontType("normal");

    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "COOP CBU");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[37]; ?>");

    // ROW 18
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Meal Allowance");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[43]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Coop Regular Loan");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[38]; ?>");

    // ROW 19
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Salary Allowance");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[48]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "COOP MESCCO");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 20
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Out-of-Town Allowance");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[45]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "COOP Rice Loan");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 21
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Relocation Allowance");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[49]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Others");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[41]; ?>");

    // ROW 22
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Incentives Allowance");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[44]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "Tax Refund / Payable");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[28]; ?>");

    // ROW 23
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "De Minimis");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[50]; ?>");
    
    doc.setFontType("bold");

    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "TOTAL DEDUCTIONS");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 24
    doc.setFontType("normal");
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Transportation Allowance");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[47]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "SSS - Employer Share");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 25
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "Load Allowance");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[46]; ?>");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "SSS - EC");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo $data[28]; ?>");

    // ROW 26
    doc.setFontType("bold");
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "TOTAL GROSS PAY");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo " "; ?>");

    doc.setFontType("normal");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "PhilHealth - Employer Share");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");

    // ROW 27
    doc.setFontType("bold");
    lstartRow = lstartRow + 5;
    cstartRow = cstartRow + 5;

    createBox(doc, "a", c1x, cstartRow);
    doc.text(l1x, lstartRow, "NET PAY");
    
    createBox(doc, "b", c2x, cstartRow);
    doc.text(l2x, lstartRow, "<?php echo $data[51]; ?>");

    doc.setFontType("normal");
    
    createBox(doc, "a", c3x, cstartRow);
    doc.text(l3x, lstartRow, "HDMF - Employer Share");
    
    createBox(doc, "b", c4x, cstartRow);
    doc.text(l4x, lstartRow, "<?php echo " "; ?>");
    
    // END - Body
</script>