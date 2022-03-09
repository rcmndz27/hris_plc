<?php 


function UpdateMfdepartment($rowid,$code,$descs)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.mf_dept SET code = :code,descs = :descs where rowid = :rowid");
            $cmd->bindValue('rowid',$rowid);
            $cmd->bindValue('code',$code);
            $cmd->bindValue('descs',$descs);
            $cmd->execute();
    }


?>
