<?php 


function UpdateAtt($badge_no,$tot_days_absent,$tot_days_work,$tot_lates,$tot_overtime_reg,$tot_rest,$total_undertime,$tot_overtime_rest,$tot_overtime_regholiday,$tot_overtime_spholiday,$tot_overtime_sprestholiday,$night_differential,$night_differential_ot,$night_differential_ot_rest,$sick_leave,$vacation_leave)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.att_summary SET 
                tot_days_absent = :tot_days_absent,
                tot_days_work = :tot_days_work,   
                tot_lates = :tot_lates,              
                tot_overtime_reg = :tot_overtime_reg,
                tot_rest = :tot_rest,
                total_undertime = :total_undertime,
                tot_overtime_rest = :tot_overtime_rest,
                tot_overtime_regholiday = :tot_overtime_regholiday,
                tot_overtime_spholiday = :tot_overtime_spholiday,
                tot_overtime_sprestholiday = :tot_overtime_sprestholiday,
                night_differential = :night_differential,
                night_differential_ot = :night_differential_ot,
                night_differential_ot_rest = :night_differential_ot_rest,
                sick_leave = :sick_leave,
                vacation_leave = :vacation_leave                                
             where badge_no = :badge_no");
            $cmd->bindValue('badge_no',$badge_no);
            $cmd->bindValue('tot_days_absent',$tot_days_absent);
            $cmd->bindValue('tot_days_work',$tot_days_work);  
            $cmd->bindValue('tot_lates',$tot_lates);           
            $cmd->bindValue('tot_overtime_reg',$tot_overtime_reg);
            $cmd->bindValue('tot_rest',$tot_rest);
            $cmd->bindValue('total_undertime',$total_undertime);
            $cmd->bindValue('tot_overtime_rest',$tot_overtime_rest);
            $cmd->bindValue('tot_overtime_regholiday',$tot_overtime_regholiday);
            $cmd->bindValue('tot_overtime_spholiday',$tot_overtime_spholiday);
            $cmd->bindValue('tot_overtime_sprestholiday',$tot_overtime_sprestholiday);
            $cmd->bindValue('night_differential',$night_differential);
            $cmd->bindValue('night_differential_ot',$night_differential_ot);            
            $cmd->bindValue('night_differential_ot_rest',$night_differential_ot_rest);
            $cmd->bindValue('sick_leave',$sick_leave);            
            $cmd->bindValue('vacation_leave',$vacation_leave);                           
            $cmd->execute();
    }


?>
