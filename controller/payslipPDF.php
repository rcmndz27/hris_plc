<?php
    session_start();

    $ct = $connL->prepare(@"SELECT COUNT(*) FROM dbo.payroll where employee = :emp and date_from = :dtfrom and date_to = :dtTo");
    $ct = $connL->bindvalue(':emp', $_POST['empCode']);
    $ct = $connL->bindValue('', $_POST['']);
    $ct = $connL->bindValue('', $_POST['']);
    $ct->execute();

    if ($ct->fetchColumn() == 1)
    {
        $cmd = $connL->prepare(@"SELECT COUNT(*) FROM dbo.payroll where employee = :emp and date_from = :dtfrom and date_to = :dtTo");
        $cmd = $connL->bindvalue(':emp', $_POST['empCode']);
        $cmd = $connL->bindValue('', $_POST['']);
        $cmd = $connL->bindValue('', $_POST['']);
        $cmd->execute();

        while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
?>
<!DOCTYPE html>
    <head>
        <style>
        @media print
        {
            @page { margin: 10px 25px 0 25px; }
        }
        .title
        {
            font-weight: bold;
            width: 100%;
            text-align:center;
            color: white;
            background-color: darkgreen;
        }
        table
        {
            border-collapse: collapse;
            font-size: 8px;
        }
        td, tr
        {
            height: 10px;
        }
        td
        {
            width: 25%;
            border: 1px solid black;
            padding: 3px;
            text-align: left;
        }
        td.header
        {
            font-weight: 700;
        }
        </style>
    </head>
    <body>
        <div style='height: 90vh; text-align:center; vertical-align:center;'>
            <div style='width: 80%; height: 100%; positon: relative; margin-right: auto; margin-left: auto;'>
                <div class='title'>PREMIUM MEGASTRUCTURES INC.</div>
                <table style='width: 100%; margin-top:20px'>
                    <tbody>
                        <tr>
                            <td class='header'>Name:</td><td><?= $r['employee']; ?></td>
                            <td class='header'>Payroll Period:</td><td><?= $r['date_from'] . ' - ' . $r['date_to']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Level:</td><td><?= $r['position']; ?></td>
                            <td class='header'>Cut-off Covered:</td><td><?= $r['date_from'] . ' - ' . $r['date_to']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Daily Rate:</td><td><?= $r['daily_rate']; ?></td>
                            <td class='header'>Location:</td><td><?= $r['loc']; ?></td>
                        </tr>


                        <tr>
                            <td class='header'> </td><td> </td>
                            <td class='header'> </td><td> </td>
                        </tr>
                        <tr>
                            <td class='header'>INCOME</td><td> </td>
                            <td class='header'>DEDUCTIONS</td><td> </td>
                        </tr>
                        

                        <tr>
                            <td class='header'>Basic Pay:</td><td><?= $r['monthly_rate']; ?></td>
                            <td class='header'>SSS Contribution - EE:</td><td><?= $r['sss']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Late:</td><td><?= $r['tardiness_amt']; ?></td>
                            <td class='header'>Phil health Contribution-EE:</td><td><?= $r['philhealth']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Undertime:</td><td><?= $r['undertime_amt']; ?></td>
                            <td class='header'>Pag-Ibig Contribution- EE:</td><td><?= $r['pagibig']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Salary Adjustment:</td><td><?= $r['salary_adj'] ?></td>
                            <td class='header'>Pag-Ibig Loan:</td><td><?= $r['pagibig_loan']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Regular Overtime:</td><td><?= $r['ot_reg_amt']; ?></td>
                            <td class='header'>Pag-Ibig Calamity Loan:</td><td><?= $r['pagibig_calamity_loan']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Rest Day OT:</td><td><?= $r['ot_rest_amt']; ?></td>
                            <td class='header'>SSS Loan:</td><td><?= $r['sss_loan']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Special Holiday Pay:</td><td><?= $r['ot_spholiday_amt']; ?></td>
                            <td class='header'>SSS Calamity Loan:</td><td><?= $r['sss_calamity_loan']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Regular Holiday Pay:</td><td><?= $r['ot_regholiday_amt']; ?></td>
                            <td class='header'>Company Loan:</td><td><?= $r['company_loan']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Night Differential Pay:</td><td><?= $r['diff_night']; ?></td>
                            <td class='header'>OMHAS (Advances):</td><td><?= $r['advances']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>OT Adjustment last cutoff:</td><td><?= $r["diff_overtime"]; ?></td>
                            <td class='header'>Salary Deduction:</td><td><?= $r['salary_deduction']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>GROSS TAXABLE:</td><td><?= $r['gross_pay_taxable']; ?></td>
                            <td class='header'>COOP CBU:</td><td><?= $r['coop_cbu']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Meal Allow.:</td><td><?= $r['meal_allowance']; ?></td>
                            <td class='header'>COOP Regular Loan:</td><td><?= $r['coop_regular_loan']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Salary Allow.:</td><td><?= $r['Salary_Allowance']; ?></td>
                            <td class='header'>COOP MESCCO:</td><td><?= $r['coop_mesco']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Out-of-town Allow.:</td><td><?= $r['out_of_town']; ?></td>
                            <td class='header'>COOP Petty Cash:</td><td><?= $r['coop_petty_cash_loan']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Relocation Allow.:</td><td><?= $r['Relocation_Allowance']; ?></td>
                            <td class='header'>Others (Pledges):</td><td><?= $r['others']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Incentives Allow.:</td><td><?= $r["incentives"]; ?></td>
                            <td class='header'>Tax Refund / Payable:</td><td><?= $r['diff_tax_refund']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Discretionary Allow.:</td><td><?= $r['discretionary']; ?></td>
                            <td class='header'>TOTAL DEDUCTIONS::</td><td><?= $r['total_deduction']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Transpo Allow.:</td><td><?= $r['transpo_allowance']; ?></td>
                            <td class='header'> </td><td> </td>
                        </tr>
                        <tr>
                            <td class='header'>Load Allow.:</td><td><?= $r['load_allowance']; ?></td>
                            <td class='header'>SSS – Employer Share:</td><td><?= $r['sss_employer']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>Cash Assistance:</td><td><?= $r['cash_assistance']; ?></td>
                            <td class='header'>SSS - EC:</td><td><?= $r['sss_ec']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>TOTAL GROSS PAY:</td><td><?= $r['total_gross_pay']; ?></td>
                            <td class='header'>Phil Health - Employer Share:</td><td><?= $r['philhealth_employer']; ?></td>
                        </tr>
                        <tr>
                            <td class='header'>NET PAY:</td><td><?= $r['total_net_pay']; ?></td>
                            <td class='header'>HDMF - Employer Share:</td><td><?= $r['pagibig_employer']; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </body>

</html>
<?php }} else {} ?>