<?php 


function ActivatePlaEnt($status,$rowid)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.applicant_plantilla SET status = :status where rowid = :rowid");
            $cmd->bindValue('status',$status);
            $cmd->bindValue('rowid', $rowid);
            $cmd->execute();
    }


?>
