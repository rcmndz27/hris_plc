<?php 


function UpdateManpowerEnt($man_pow,$rowid)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.applicant_manpower  SET status = 'Filled',app_no = :rowid  where rowid = :man_pow");
            $cmd->bindValue('man_pow',$man_pow);
            $cmd->bindValue('rowid',$rowid);
            $cmd->execute();
    }

function UpdateStatAppEnt($rowid)
    {
            global $connL;

            $cmd2 = $connL->prepare("UPDATE dbo.applicant_entry SET appent_status = '2'  where rowid = :rowid");
            $cmd2->bindValue('rowid',$rowid);
            $cmd2->execute();
    }



?>
