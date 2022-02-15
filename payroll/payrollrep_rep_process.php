<?php

    include('../payroll/payroll_rep.php');
    include('../config/db.php');

    $action = $_POST["_action"];
    $dateFrom = $_POST["_from"];
    $dateTo = $_POST["_to"];
    $company = $_POST["_company"];
    

   if ($action == 1)
    {
        GetPayrollRepList($action, $dateFrom, $dateTo,$company);
    }
    else {

    }

?>