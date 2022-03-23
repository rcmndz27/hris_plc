<?php 


function UpdateAtt($badge_no,$tot_overtime_reg,$tot_overtime_rest,$tot_overtime_regholiday,$tot_overtime_spholiday,$tot_overtime_sprestholiday)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.att_summary SET 
                tot_overtime_reg = :tot_overtime_reg,
                tot_overtime_rest = :tot_overtime_rest,
                tot_overtime_regholiday = :tot_overtime_regholiday,
                tot_overtime_spholiday = :tot_overtime_spholiday,
                tot_overtime_sprestholiday = :tot_overtime_sprestholiday
             where badge_no = :badge_no");
            $cmd->bindValue('badge_no',$badge_no);
            $cmd->bindValue('tot_overtime_reg',$tot_overtime_reg);
            $cmd->bindValue('tot_overtime_rest',$tot_overtime_rest);
            $cmd->bindValue('tot_overtime_regholiday',$tot_overtime_regholiday);
            $cmd->bindValue('tot_overtime_spholiday',$tot_overtime_spholiday);
            $cmd->bindValue('tot_overtime_sprestholiday',$tot_overtime_sprestholiday);
            $cmd->execute();
    }


?>
