<?php
    function showOwnLeave()
    {
        $db = getDB();
        $stmt = $db->prepare("SELECT * FROM dbo.mf_leave WHERE employee=:userid");
        $stmt->bindParam("userid", $_SESSION['userid'],PDO::PARAM_STR) ;
        $stmt->execute();
        $data=$stmt->fetchAll();
        $db = null;

        foreach ($data as $empInfo)
        {
            $empID = trim($empInfo['userid']);
            $empName = trim($empInfo['username']);
            $empType = trim($empInfo['usertype']);
        }

        echo "
            <table id='displayview' class='table table-striped table-fluid'>
                <thead class='thead-dark'>
                    <tr>
                        <td>Employee</td>
                        <td>Department</td>
                        <td>Date Filed</td>
                        <td>Leave Type</td>
                        <td>Date From</td>
                        <td>Date To</td>
                        <td>Duration (days)</td>
                        <td></td>
                    </tr>
                </thead><tbody>";

        while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
        {
            echo "
                <tr>
                    <td>" . $empInfo['userid'] . "</td>
                    <td>" . $r['department'] . "</td>
                    <td>" . date('m/d/Y', strtotime($r['datefiled'])) . "</td>
                    <td>" . $r['leavetype'] . "</td>
                    <td>" . date('m/d/Y', strtotime($r['date_from'])) . "</td>
                    <td>" . date('m/d/Y', strtotime($r['date_to'])) . "</td>
                    <td>" . $r['no_of_days'] . "</td>
                    <td>
                </tr>";
        }  
    }
?>