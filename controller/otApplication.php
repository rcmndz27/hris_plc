<?php

    function GetOTHistory($empCode)
    {
        global $connL;

        $validate = $connL->prepare(@"SELECT COUNT(res.emp_code) FROM (SELECT emp_code FROM dbo.att_ot_approve where emp_code = :emp UNION ALL SELECT emp_code FROM dbo.att_ot_filed where emp_code = :emp2) as res");
        $validate->bindValue(":emp", $empCode);
        $validate->bindValue(":emp2", $empCode);
        $validate->execute();

        echo '
            <table id="dtrList" class="table table-dark table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="7" class ="text-center">History</th>
                </tr>
                <tr>
                    <th>Date Filed</th>
                    <th>Date Rendered</th>
                    <th>Pre Shift OT</th>
                    <th>Post Shift OT</th>
                    <th>Overtime Approved</th>
                    <th>Remarks</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>';

        if ((int)$validate->fetchColumn() >= 1)
        {
            $getPendingHistory = $connL->prepare(@"SELECT filed.auditdate AS datefiled, filed.ot_date as rendereddate, filed.preot_time as preshift, filed.postot_time as postshift, ISNULL(approved.hours_work, 0) as work, ISNULL(approved.ot_rendered, 0) as renderedot, ISNULL(approved.ot_approved, 0) as approvedot, approved.remarks as remarks,
                                                    CASE
                                                        WHEN filed.ot_date in (SELECT date FROM dbo.att_ot_approve where emp_code = :emp1)
                                                            THEN 1
                                                        ELSE 0
                                                    END AS status
                                                    FROM dbo.att_ot_approve approved 
                                                    FULL OUTER JOIN dbo.att_ot_filed filed 
                                                    ON approved.emp_code = filed.emp_code
                                                    AND approved.date =  filed.ot_date
                                                    WHERE filed.emp_code = :emp2
                                                    ORDER BY datefiled, rendereddate");
            $getPendingHistory->bindValue(":emp1", $empCode);
            $getPendingHistory->bindValue(":emp2", $empCode);
            $getPendingHistory->execute();

            while($r = $getPendingHistory->fetch(PDO::FETCH_ASSOC))
            {
                echo "<tr>
                        <td>" . date("F d, Y", strtotime($r["datefiled"])) . "</td>
                        <td>" . date("F d, Y", strtotime($r["rendereddate"])) . "</td>
                        <td>" . number_format($r["preshift"], 2) . "</td>
                        <td>" . number_format($r["postshift"], 2) . "</td>
                        <td>" . number_format($r["approvedot"], 2) . "</td>
                        <td>" . $r["remarks"] . "</td>
                        <td>" . ($r["status"] == 0 ? "PENDING" : ($r["approvedot"] == 0 ? "REJECTED" : "APPROVED")) . "</td>
                    </tr>
                ";
            }
        }
        
        echo "</tbody></table>";
    }

    /*
        -string: employee name
        -string: ot start dates
        -array: number of hours
        -array: remarks
        -base64string: uploadedfile
        -string: reporting to
    */
    function InsertOt($empCode, $date, $hrs, $hrs2, $remarks, $base64)
    {
        global $connL;

        $validate = $connL->prepare(@"SELECT COUNT(emp_code) FROM dbo.att_ot_approve where emp_code = :emp AND date = :otdate");
        $validate->bindValue(":emp", $empCode);
        $validate->bindValue(":otdate", $date);
        $validate->execute();

        if ((int)$validate->fetchColumn() == 1)
        {
	    echo "<script>alert('OT Application is already approved or rejected!');</script>";
            return;
        }

        $findempname = $connL->prepare(@"SELECT Employee from dbo.view_employee where emp_code = :emp");
        $findempname->bindValue(":emp", $empCode);
        $findempname->execute();

        $findreportingto = $connL->prepare(@"SELECT reporting_to from dbo.view_employee where emp_code = :emp");
        $findreportingto->bindValue(":emp", $empCode);
        $findreportingto->execute();

        $empName = (string)$findempname->fetchColumn();
        $reportingto = (string)$findreportingto->fetchColumn();
        $now = date("Y-m-d H:i:s");

        $dates = [
            $date,
            date("Y-m-d", strtotime($date . " + 1 days ")),
            date("Y-m-d", strtotime($date . " + 2 days ")),
            date("Y-m-d", strtotime($date . " + 3 days ")),
            date("Y-m-d", strtotime($date . " + 4 days ")),
            date("Y-m-d", strtotime($date . " + 5 days ")),
            date("Y-m-d", strtotime($date . " + 6 days "))
        ];

        $cutoff = date("F d, Y", strtotime($dates[0])) . " - " . date("F d, Y", strtotime($dates[count($dates) - 1]));

        for ($i = 0; $i < count($hrs); $i++)
        {
            $sql = $connL->prepare(@"INSERT INTO dbo.att_ot_filed VALUES(:empcode, :empname, :otdate, :ottime, :ottime2, :remarks, :upload, :reporting_to, :audituser, :auditdate)");
            $sql->bindValue(":empname", $empName);
            $sql->bindValue(":empcode", $empCode);
            $sql->bindValue(":otdate", $dates[$i]);
            $sql->bindValue(":ottime", $hrs[$i]);
            $sql->bindValue(":ottime2", $hrs2[$i]);
            $sql->bindValue(":remarks", $remarks[$i]);
            $sql->bindValue(":upload", $base64);
            $sql->bindValue(":reporting_to", $reportingto);
            $sql->bindValue(":audituser", $empCode);
            $sql->bindValue(":auditdate", $now);
            $sql->execute();
        }

        $em = $connL->prepare(@"exec dbo.sp_autoemail_overtime :emp, :dt");
        $em->bindValue(':emp', $empCode);
        $em->bindValue(':dt', $cutoff);
        $em->execute();
    }

?>