<?php

    function UpdateSupportStaff($jobId, $staff)
    {
        global $connL;

        $cmd = $connL->prepare(@"UPDATE dbo.ticket_requests SET support_assigned=:sp WHERE job_orderid=". $jobId);
        $cmd->bindValue(":sp", $staff);
        $cmd->execute();
        
        echo "<script>alert('Successfully updated support assignment to ticket request: " . $_POST['jobid'] . ".');</script>";
    }

?>