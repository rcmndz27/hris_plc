<?php

    include('../payroll/payrollApproval.php');
    include('../config/db.php');


    $choice = $_POST['choice'];

    if ($choice == 1)
    {
        ApprovePayroll();
    }
    else if ($choice == 2)
    {
        RejectPayroll();
    }
    else {}

?>