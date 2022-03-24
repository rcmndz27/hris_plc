<?php 


function UpdateAtt($badge_no,$tot_days_absent,$tot_days_work,$tot_overtime_reg,$tot_overtime_rest,$tot_overtime_regholiday,
            $tot_overtime_spholiday,$tot_overtime_sprestholiday,$night_differential,$night_differential_ot)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.att_summary SET 
                tot_days_absent = :tot_days_absent,
                tot_days_work = :tot_days_work,                
                tot_overtime_reg = :tot_overtime_reg,
                tot_overtime_rest = :tot_overtime_rest,
                tot_overtime_regholiday = :tot_overtime_regholiday,
                tot_overtime_spholiday = :tot_overtime_spholiday,
                tot_overtime_sprestholiday = :tot_overtime_sprestholiday,
                night_differential = :night_differential,
                night_differential_ot = :night_differential_ot                
             where badge_no = :badge_no");
            $cmd->bindValue('badge_no',$badge_no);
            $cmd->bindValue('tot_days_absent',$tot_days_absent);
            $cmd->bindValue('tot_days_work',$tot_days_work);            
            $cmd->bindValue('tot_overtime_reg',$tot_overtime_reg);
            $cmd->bindValue('tot_overtime_rest',$tot_overtime_rest);
            $cmd->bindValue('tot_overtime_regholiday',$tot_overtime_regholiday);
            $cmd->bindValue('tot_overtime_spholiday',$tot_overtime_spholiday);
            $cmd->bindValue('tot_overtime_sprestholiday',$tot_overtime_sprestholiday);
            $cmd->bindValue('night_differential',$night_differential);
            $cmd->bindValue('night_differential_ot',$night_differential_ot);            
            $cmd->execute();
    }


?>
