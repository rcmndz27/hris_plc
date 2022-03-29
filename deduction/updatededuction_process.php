<?php

    include('../deduction/updatededuction.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $emp_code = $_POST["emp_code"];
    $deduction_id = $_POST["deduction_id"];
    $period_cutoff = $_POST["period_cutoff"];
    $amount = $_POST["amount"];
    $effectivity_date = $_POST["effectivity_date"];        


    if ($action == 1)
    {
        UpdateDeduction($emp_code,$deduction_id,$period_cutoff,$amount,$effectivity_date);
    }

?>
