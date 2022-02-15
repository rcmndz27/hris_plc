<?php

    function ShowAllTravel($empName)
    {
        global $connL;

        $ct = $connL->prepare(@"SELECT COUNT(*) FROM dbo.mf_official where approval = :name");
        $ct->bindValue(':name', $empName);
        $ct->execute();

        echo "
            <table id='list' class='table table-dark table-striped table-sm'>
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Date Filed</th>
                        <th>Location</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Remarks</th>
                        <th>Number of Days</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>";

        if ($ct->fetchColumn() >= 1)
        {
            $cmd = $connL->prepare(@'SELECT * from dbo.mf_official where approval = :name ORDER BY approved, datefiled ASC');
            $cmd->bindValue(':name', $empName);
            $cmd->execute();

            while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
            {
                echo "<tr>
                        <td>" . $r['employee'] ."</th>
                        <td>" . date("F d, Y h:i A", strtotime($r['datefiled'])) ."</td>
                        <td>" . $r['location'] ."</td>
                        <td>" . date("F d, Y", strtotime($r['date_from'])) ."</td>
                        <td>" . date("F d, Y", strtotime($r['date_to'])) ."</td>
                        <td>" . $r['remarks'] ."</td>
                        <td>" . $r['no_of_days'] ."</td>
                        <td>";
                
                switch((int)$r["approved"])
                {
                    case 0:
                        echo "<button class='btnApprove' id='" . $r['rowid'] . "' onmousedown='javascript:ApproveTravel()'><i class='fas fa-check'></i></button>";
                        echo "<button class='btnReject' id='" . $r['rowid'] . "' onmousedown='javascript:RejectTravel()'><i class='fas fa-times'></i></button>";
                        break;
                    case 1:
                        echo "<p style='color:green; font-weight:bold; vertical-align:middle; display:inline;'>APPROVED</p>";
                        break;
                    case -1:
                        echo "<p style='color:red; font-weight:bold; vertical-align:middle; display:inline;'>REJECTED</p>";
                        break;

                }

                echo "</td></tr>";
            }
        }
        else { echo '<tr><td colspan="8" class="text-center">There is nothing to view.</td></tr>'; }

        echo "<tbody></table>";
    }

    function ApproveTravel($rowid)
    {
        global $connL;

        $cmd = $connL->prepare('UPDATE dbo.mf_official SET approved = 1 where rowid = :rid');
        $cmd->bindValue('rid', $rowid);
        $cmd->execute();

        echo "<span class='etcMessage'>
                <script type='text/javascript'>
                    alert('Successfully updated travel approval list.');
                    $('etcMessage').remove();
                </script>
            </span>";
    }

    function RejectTravel($rowid)
    {
        global $connL;

        $cmd = $connL->prepare('UPDATE dbo.mf_official SET approved = -1 where rowid = :rid');
        $cmd->bindValue('rid', $rowid);
        $cmd->execute();

        echo "<span class='etcMessage'>
                <script type='text/javascript'>
                    alert('Successfully updated travel approval list.');
                    $('etcMessage').remove();
                </script>
            </span>";
    }

?>