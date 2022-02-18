<?php

    include('../salaryadjustment/updatesalaryadjustment.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $emp_code = $_POST["emp_code"];
    $salaryadjustment_id = $_POST["salaryadjustment_id"];
    $period_cutoff = $_POST["period_cutoff"];
    $amount = $_POST["amount"];
    $effectivity_date = $_POST["effectivity_date"];        


    if ($action == 1)
    {
        UpdateSalaryAdj($emp_code,$salaryadjustment_id,$period_cutoff,$amount,$effectivity_date);
    }
    else {

    }

?>
