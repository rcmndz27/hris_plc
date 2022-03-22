<?php

    include('../payroll/payrollapp_reg.php');
    include('../config/db.php');

    $action = $_POST["_action"];
    $period_from = $_POST["period_from"];
    $period_to = $_POST["period_to"];
    $payroll_status = $_POST["payroll_status"];

    if ($action == 1)
    {
        GetPayrollAppRegList($period_from,$period_to,$payroll_status);
    }

?>