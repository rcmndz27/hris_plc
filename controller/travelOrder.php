<?php

    function FileTravel($empCode, $empName, $travelLoc, $travelDesc, $dateFrom, $dateTo)
    {
        global $connL;

        $findEmployee = $connL->prepare(@"SELECT * FROM dbo.view_employee where emp_code = :emp");
        $findEmployee->bindValue(':emp', $empCode);
        $findEmployee->execute();

        $empDept = "";
        $empReport = "";
        $travelLength = ((strtotime($dateTo) - strtotime($dateFrom)) / 60 / 60 / 24) + 1;

        while($r = $findEmployee->fetch(PDO::FETCH_ASSOC))
        {
            $empDept = $r['department'];
            $empReport = $r['reporting_to'];
        }

        $insertLeave = $connL->prepare(@"INSERT INTO dbo.mf_official (emp_code, employee, department, approval, datefiled, date_from, date_to, no_of_days, location, remarks, approved, audituser, auditdate) VALUES
                                                                    (:code,     :emp,     :dept,      :appP,    :dtFiled,     :dtFrom,   :dtTo,    :num,     :loc,   :rem,        :appS,    :auditu,   :auditd)");
        $insertLeave->bindValue(':code', $empCode);
        $insertLeave->bindValue(':emp', $empName);
        $insertLeave->bindValue(':dept', $empDept);
        $insertLeave->bindValue(':appP', $empReport);
        $insertLeave->bindValue(':dtFiled', date('Y-m-d H:i:s'));
        $insertLeave->bindValue(':dtFrom', $dateFrom);
        $insertLeave->bindValue(':dtTo', $dateTo);
        $insertLeave->bindValue(':num', ceil($travelLength));
        $insertLeave->bindValue(':loc', $travelLoc);
        $insertLeave->bindValue(':rem', $travelDesc);
        $insertLeave->bindValue(':appS', 0);
        $insertLeave->bindValue(':auditu', $empCode);
        $insertLeave->bindValue(':auditd', date('Y-m-d H:i:s'));
        $insertLeave->execute();

        echo "<h2>Successfully filed a Travel Application!</h2>";
    }

    function ShowAllTravel($emp)
    {
        global $connL;

        $ct = $connL->prepare(@"SELECT COUNT(*) FROM dbo.mf_official where employee = :emp");
        $ct->bindValue(":emp", $emp);
        $ct->execute();

        echo '
            <table id="displayview" class="table table-dark table-striped table-sm">
                <thead>  
                    <tr>
                        <th>Date Filed</th>
                        <th>Location</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>';

        if ($ct->fetchColumn() >= 1)
        {
            $cmd = $connL->prepare(@"SELECT * FROM dbo.mf_official where employee = :emp ORDER BY datefiled DESC");
            $cmd->bindValue(":emp", $emp);
            $cmd->execute();

            while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
            {
                echo "<tr>
                        <td>" . date("F d, Y h:i A", strtotime($r["datefiled"])) . "</td>
                        <td>" . $r["location"] . "</td>
                        <td>" . date("F d, Y", strtotime($r["date_from"])) . "</td>
                        <td>" . date("F d, Y", strtotime($r["date_to"])) . "</td>
                        <td>
                ";

                switch ((int)$r["approved"])
                {
                    case 0:
                        echo '<p class="text-warning">PENDING</p>';
                        break;
                    case 1:
                        echo '<p class="text-success">APPROVED</p>';
                        break;
                    case -1:
                        echo '<p class="text-danger">REJECTED</p>';
                        break;
                    default:
                        break;
                }

                echo "</td></tr>";
            }
        }
        else { echo '<tr><td colspan="5" class="text-center">NO TRAVEL HISTORY!</td></tr>'; }

        echo "</tbody></table>";
    }

?>