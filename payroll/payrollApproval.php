<?php

    function ShowAllPayroll()
    {
        global $connL;

        $ct = $connL->prepare(@"SELECT COUNT(*) FROM dbo.payroll");
        $ct->execute();

        echo "
            <table id='list' class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Location</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Total Netpay</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>";

        if ($ct->fetchColumn() >= 1)
        {
            $cmd = $connL->prepare(@"SELECT company,location,date_from,date_to,payroll_status,sum(netpay) as net_pay from payroll where payroll_status = 'N'
                group by company,location,date_from,date_to,payroll_status ");
            $cmd->execute();

            while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
            {
                $rnd = round($r['net_pay'],2) ;
                $netpy = number_format($rnd, 2,'.',',');
                $datefrom = "'".date('Y-m-d', strtotime($r['date_from']))."'";  
                $dateto = "'".date('Y-m-d', strtotime($r['date_to']))."'";
                $stats = "'".ucfirst($r['payroll_status'])."'";  
                echo "<tr>
                        <td>" . $r['company'] ."</td>
                        <td>" . $r['location'] ."</td>
                        <td>" . date("F d, Y", strtotime($r['date_from'])) ."</td>
                        <td>" . date("F d, Y", strtotime($r['date_to'])) ."</td>
                        <td>" . '&#8369; '. $netpy ."</td>
                        <td>";
                
                switch($r["payroll_status"])
                {
                    case "N":
                        echo "<button class='chckbt'  onclick='ApprovePayroll()' title='Approve Payroll'><i class='fas fa-check'></i></button>";
                        echo "<button class='rejbt'  onclick='RejectPayroll()' title='Reject Payroll'><i class='fas fa-times'></i></button>";
                        echo'<button title="View Payroll Register" type="button" class="vwPyReg" onclick="ViewPyReg('.$datefrom.','. $dateto.','.$stats.')"><i class="fas fa-search-dollar"></i></button>';
                        break;
                    case "A":
                        echo "<p style='color:green; font-weight:bold; vertical-align:middle; display:inline;'>APPROVED</p>";
                        break;
                    case "R":
                        echo "<p style='color:red; font-weight:bold; vertical-align:middle; display:inline;'>REJECTED</p>";
                        break;

                

                }   echo "</td></tr>";
            }
        }
        else { 
            echo '<tr><td colspan="8" class="text-center">You have zero pending payroll approval.</td></tr>'; 
        }
        
    }

     echo "<tbody></table>";

    function ApprovePayroll()
    {
        global $connL;

        $cmd = $connL->prepare("UPDATE dbo.payroll SET payroll_status = 'A'");
        $cmd->execute();

        echo "<span class='etcMessage'>
                <script type='text/javascript'>
                    alert('Successfully updated payroll approval list.');
                    $('etcMessage').remove();
                </script>
            </span>";
    }

    function RejectPayroll()
    {
        global $connL;

        $cmd = $connL->prepare("UPDATE dbo.payroll SET payroll_status = 'R'");
        $cmd->execute();

        echo "<span class='etcMessage'>
                <script type='text/javascript'>
                    alert('Successfully updated payroll approval list.');
                    $('etcMessage').remove();
                </script>
            </span>";
    }

?>