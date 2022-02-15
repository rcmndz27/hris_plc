<?php

    include('../payroll/payroll_reg.php');
    include('../config/db.php');

    $choice = $_POST['choice'];
    $empCode = $_POST['emp_code'];

    if ($choice == 1)
    {
        ApprovePayRegView($empCode);
    }
    else {

    }

?>