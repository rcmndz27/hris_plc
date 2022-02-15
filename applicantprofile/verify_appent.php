<?php 


function VerifyAppEnt($relevant,$not_relevant,$verified_by,$verified_date,$action_taken,$referred_to,$referral_date,$appent_status,$rowid)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.applicant_entry 
            SET relevant = :relevant,
            not_relevant = :not_relevant,
            verified_by = :verified_by,
            verified_date = :verified_date, 
            action_taken = :action_taken,
            referred_to = :referred_to,
            referral_date = :referral_date,
            appent_status = :appent_status
            where rowid = :rowid");

            $cmd->bindValue('relevant',$relevant);
            $cmd->bindValue('not_relevant', $not_relevant);
            $cmd->bindValue('verified_by',$verified_by);
            $cmd->bindValue('verified_date', $verified_date);
            $cmd->bindValue('action_taken',$action_taken);
            $cmd->bindValue('referred_to', $referred_to);
            $cmd->bindValue('referral_date',$referral_date);
            $cmd->bindValue('appent_status',$appent_status);
            $cmd->bindValue('rowid', $rowid);
            $cmd->execute();
    }


?>
