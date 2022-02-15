<?php

    function GetAllCutoff()
    {
        global $connL;

        $cmd = $connL->prepare(@"SELECT DISTINCT date_from, date_to FROM dbo.payroll ORDER BY date_from ASC");
        $cmd->execute();

        $cutoffs = array();

        echo "<ul>";

        while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
            $df = new DateTime($r['date_from']);
            $dt = new DateTime($r['date_to']);

            $dfFormat = $df->format('F d, Y');
            $dtFormat = $dt->format('F d, Y');

            $cutOffDates = $dfFormat . ' - ' . $dtFormat;

            echo "<li><button value='" . $cutOffDates . "' class='btn btn-link btnCutoff'>" . $cutOffDates . "</button></li>";
        }

        echo "</ul>";
    }

    function GetPayrollAmount($empName, $dateRow)
    {
        $dateFinal = explode(' - ', $dateRow);

        global $connL;

        $cmd = $connL->prepare(@"SELECT * FROM dbo.payroll where date_from = :df AND date_to = :dt AND employee = :emp");
        $cmd->bindValue(':df', $dateFinal[0]);
        $cmd->bindValue(':dt', $dateFinal[1]);
        $cmd->bindValue(':emp', $empName);
        $cmd->execute();

        while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
            echo "<div class='row'>
                    <table id='list' class='table table-striped'><tbody>
                        <tr>
                            <th scope='col'>Monthly Rate</th>
                            <th scope='col'>" . $r['monthly_rate'] . "</th>
                            <th scope='col'>Daily Rate</th>
                            <th scope='col'>" . $r['daily_rate'] . "</th>
                            <th scope='col'>Hourly Rate</th>
                            <th scope='col'>" . $r['hour_rate'] . "</th>
                        </tr>
                        <tr>
                            <td><b>Days Worked</b></td>
                            <td>" . $r['days_work'] . "</td>
                            <td><b>Days Worked Amount</b></td>
                            <td>" . $r['days_work_amt'] . "</td>
                            <td><b>Absence Amount</b></td>
                            <td>" . $r['absence_amt'] . "</td>
                        </tr>
                        <tr>
                            <td><b>Tardiness (Hrs)</b></td>
                            <td>" . $r['tardiness'] . "</td>
                            <td colspan=2><b>Tardiness Amount</b></td>
                            <td colspan=2>" . $r['tardiness_amt'] . "</td>
                        </tr>
                        <tr>
                            <td><b>Overtime (Hrs)</b></td>
                            <td>" . $r['overtime'] . "</td>
                            <td colspan=2><b>Overtime Amount</b></td>
                            <td colspan=2>" . $r['overtime_amt'] . "</td>
                        </tr>
                        <tr>
                            <td><b>Overtime (Hrs)</b></td>
                            <td>" . $r['overtime'] . "</td>
                            <td colspan=2><b>Overtime Amount</b></td>
                            <td colspan=2>" . $r['overtime_amt'] . "</td>
                        </tr>";
        }
    }

?>