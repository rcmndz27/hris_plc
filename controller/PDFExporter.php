<?php

    require_once('../TCPDF/tcpdf.php');
    include('../config/db.php');
    
    $id = $_GET["id"];
    $dtFrom = $_GET["dfrom"];
    $dtTo = $_GET["dto"];

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->SetHeaderData('../img/logo.png',20,'HRIS PORTAL','Overtime Approval Report');
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
        require_once(dirname(__FILE__).'/lang/eng.php');
        $pdf->setLanguageArray($l);
    }
    
    $pdf->AddPage();

    $pdf->SetFont('helvetica', '', 15);

    $html = '<div><b>' . date("F d, Y", strtotime($dtFrom)) . ' - ' . date("F d, Y", strtotime($dtTo)) . '</b></div>';

    $pdf->SetFont('helvetica', '', 9);

    $html .= '
            <div>
                <table>
                    <tr>
                        <th style="border: 1px solid black; background-color: darkgreen; color: white;">&nbsp;<b>Employee</b></th>
                        <th style="border: 1px solid black; background-color: darkgreen; color: white;">&nbsp;<b>Date</b></th>
                        <th style="border: 1px solid black; background-color: darkgreen; color: white;">&nbsp;<b>Work (Hrs)</b></th>
                        <th style="border: 1px solid black; background-color: darkgreen; color: white;">&nbsp;<b>OT Rendered (Hrs)</b></th>
                        <th style="border: 1px solid black; background-color: darkgreen; color: white;">&nbsp;<b>OT Approved (Hrs)</b></th>
                        <th style="border: 1px solid black; background-color: darkgreen; color: white;">&nbsp;<b>Remarks</b></th>
                    </tr>
    ';

    $sql = "";

    if ($id == null || $id == "")
    {
        $sql = $connL->prepare(@"SELECT emp_name, hours_work, ot_rendered, ot_approved, ISNULL(remarks, '') as remarks, date FROM dbo.att_ot_approve WHERE date >= :dtfrom AND date <= :dtto ORDER BY emp_name, date");
        $sql->bindValue(":dtfrom", $dtFrom);
        $sql->bindValue(":dtto", $dtTo);
    }
    else if ($id != null || $id != "")
    {
        $sql = $connL->prepare(@"SELECT emp_name, hours_work, ot_rendered, ot_approved, ISNULL(remarks, '') as remarks, date FROM dbo.att_ot_approve WHERE date >= :dtfrom AND date <= :dtto AND audituser = :rpt ORDER BY emp_name, date");
        $sql->bindValue(":dtfrom", $dtFrom);
        $sql->bindValue(":dtto", $dtTo);
        $sql->bindValue(":rpt", $id);
    }
    else {}

    $sql->execute();

    while($r = $sql->fetch(PDO::FETCH_ASSOC))
    {
        $html .= "
            <tr>
                <td style=\"border: 1px solid black; \">&nbsp;" . $r["emp_name"] . "</td>
                <td style=\"border: 1px solid black; \">&nbsp;" . date("F d, Y", strtotime($r["date"])) . "</td>
                <td style=\"border: 1px solid black; \">&nbsp;" . number_format($r["hours_work"], 2) . "</td>
                <td style=\"border: 1px solid black; \">&nbsp;" . number_format($r["ot_rendered"], 2) . "</td>
                <td style=\"border: 1px solid black; \">&nbsp;" . number_format($r["ot_approved"], 2) . "</td>
                <td style=\"border: 1px solid black; \">&nbsp;" . $r["remarks"] . "</td>
            </tr>
        ";
    }

    $html .= "</tbody></table></div>";

    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output('Overtime Approval Report.pdf', 'I');

?>