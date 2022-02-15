<?php

    function ShowAllLoan($empName)
    {
        global $connL;

        $ct = $connL->prepare(@"SELECT COUNT(*) from dbo.loan_hd where emp_name = :emp");
        $ct->bindValue(':emp', $empName);
        $ct->execute();

        echo "
        <table id='loanList' class='table table-dark table-striped table-sm'>
            <thead>
                <tr>
                    <th>Document Number</th>
                    <th>Loan Type</th>
                    <th>Date Filed</th>
                    <th>Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>";

        if ($ct->fetchColumn() >= 1)
        {
            $cmd = $connL->prepare(@"SELECT * from dbo.loan_hd where emp_name = :emp");
            $cmd->bindValue(':emp', $empName);
            $cmd->execute();

            while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
            {
                echo "<tr>
                    <td><button class='btnViewLoan tableBtn' onmousedown='javascript:ShowLoan()'>" . $r['doc_no'] . "</button></td>
                    <td>" . $r['loan_type'] . "</td>
                    <td>" . date('m/d/Y', strtotime($r['doc_date'])) . "</td>
                    <td>₱ " . $r['amount'] . "</td>
                    <td>" . date('m/d/Y', strtotime($r['startdate'])) . "</td>
                    <td>" . date('m/d/Y', strtotime($r['enddate'])) . "</td>
                    </tr>";
            }
        }
        else { echo "<tr><td colspan='6' class='text-center'>You currently have no loans!</td></tr>"; }

        echo "</tbody></table>";
    }

    function ShowLoanDesc($docNo)
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT * from dbo.loan_dtl where doc_no = :dcn");
        $cmd->bindValue(':dcn', $docNo);
        $cmd->execute();

        echo "
        <table id='loanInfo' class='table table-dark table-striped table-sm'>
            <thead>
                <tr>
                    <td>#</td>
                    <td>Date</td>
                    <td>Amortization</td>
                    <td>Interest</td>
                    <td>Principal</td>
                    <td>Balance</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>";

        while($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
            echo "
                <tr>
                    <th scope='row'>" . $r['no_'] . "</th>
                    <td>" . date('m/d/Y', strtotime($r['sch_date'])) . "</td>
                    <td>₱ " . sprintf('%0.2f', (double)$r['amortization']) . "</td>
                    <td>₱ " . sprintf('%0.2f', (double)$r['interest_pay']) . "</td>
                    <td>₱ " . sprintf('%0.2f', (double)$r['principal_pay']) . "</td>
                    <td>₱ " . sprintf('%0.2f', (double)$r['balance']) . "</td>
                    <td>";

            if ($r['status'] == 'Y') { echo "PAID"; }
            else { echo "NOT PAID"; }
                    
            echo "</td></tr>";
        }

        echo "</tbody></table>";
    }

?>