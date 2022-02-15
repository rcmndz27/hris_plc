<?php

    function UpdateRequestDetails($jobID, $status)
    {
        global $connL;

        $cmd = $connL->prepare(@"UPDATE dbo.ticket_requests SET status = :stat WHERE job_orderid = :id");
        $cmd->bindValue(":stat", $status);
        $cmd->bindValue(":id", $jobID);
        $cmd->execute();
    }

?>