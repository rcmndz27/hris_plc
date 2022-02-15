<?php 


function UpdateMfposition($rowid,$position)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.mf_position SET position = :position where rowid = :rowid");
            $cmd->bindValue('rowid',$rowid);
            $cmd->bindValue('position',$position);
            $cmd->execute();
    }


?>
