<?php

    include('../payroll/updateatt.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $badge_no = $_POST["badge_no"];
    $tot_days_absent = $_POST["tot_days_absent"];
    $tot_days_work = $_POST["tot_days_work"];   
    $tot_lates = $_POST["tot_lates"];   
    $tot_overtime_reg = $_POST["tot_overtime_reg"];
    $tot_rest = $_POST["tot_rest"];
    $total_undertime = $_POST["total_undertime"];
    $tot_overtime_rest = $_POST["tot_overtime_rest"];
    $tot_overtime_regholiday = $_POST["tot_overtime_regholiday"];
    $tot_overtime_spholiday = $_POST["tot_overtime_spholiday"];
    $tot_overtime_sprestholiday = $_POST["tot_overtime_sprestholiday"];
    $night_differential = $_POST["night_differential"];
    $night_differential_ot = $_POST["night_differential_ot"];
    $night_differential_ot_rest = $_POST["night_differential_ot_rest"];
    $sick_leave = $_POST["sick_leave"];
    $vacation_leave = $_POST["vacation_leave"];           

    if ($action == 1)
    {
UpdateAtt($badge_no,$tot_days_absent,$tot_days_work,$tot_lates,$tot_overtime_reg,$tot_rest,$total_undertime,$tot_overtime_rest,$tot_overtime_regholiday,$tot_overtime_spholiday,$tot_overtime_sprestholiday,$night_differential,$night_differential_ot,$night_differential_ot_rest,$sick_leave,$vacation_leave);
    }

?>
