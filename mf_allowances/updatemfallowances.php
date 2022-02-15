<?php 


function UpdateMfallowances($rowid,$benefit_code,$benefit_name)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.mf_benefits SET 
                benefit_code = :benefit_code,
                benefit_name = :benefit_name
             where rowid = :rowid");
            $cmd->bindValue('rowid',$rowid);
            $cmd->bindValue('benefit_code',$benefit_code);
            $cmd->bindValue('benefit_name',$benefit_name);
            $cmd->execute();
    }


?>
