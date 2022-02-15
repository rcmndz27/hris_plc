<?php

    include('../payroll/payroll_reg.php');
    include('../config/db.php');

    $action = $_POST["_action"];
    $dateFrom = $_POST["_from"];
    $dateTo = $_POST["_to"];
    $location = $_POST["_location"];

    if ($action == 1)
    {
        GetPayrollRegList($action, $dateFrom, $dateTo,$location);
    }
    else {

    }

?>