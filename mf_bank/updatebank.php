<?php 


function UpdateBank($rowid,$descsb,$descsb_name)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.mf_banktypes SET 
                descsb = :descsb,
                descsb_name = :descsb_name
             where rowid = :rowid");
            $cmd->bindValue('rowid',$rowid);
            $cmd->bindValue('descsb',$descsb);
            $cmd->bindValue('descsb_name',$descsb_name);
            $cmd->execute();
    }


?>
