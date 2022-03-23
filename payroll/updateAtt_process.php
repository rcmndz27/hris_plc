<?php

    include('../payroll/updateatt.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $badge_no = $_POST["badge_no"];
    $tot_overtime_reg = $_POST["tot_overtime_reg"];
    $tot_overtime_rest = $_POST["tot_overtime_rest"];
    $tot_overtime_regholiday = $_POST["tot_overtime_regholiday"];
    $tot_overtime_spholiday = $_POST["tot_overtime_spholiday"];
    $tot_overtime_sprestholiday = $_POST["tot_overtime_sprestholiday"];

    if ($action == 1)
    {
    UpdateAtt($badge_no,$tot_overtime_reg,$tot_overtime_rest,$tot_overtime_regholiday,
            $tot_overtime_spholiday,$tot_overtime_sprestholiday);
    }

?>
