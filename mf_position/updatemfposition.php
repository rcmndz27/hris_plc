<?php 


function UpdateMfposition($rowid,$position,$status)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.mf_position SET position = :position,status = :status where rowid = :rowid");
            $cmd->bindValue('rowid',$rowid);
            $cmd->bindValue('position',$position);
            $cmd->bindValue('status',$status);
            $cmd->execute();
    }


?>
