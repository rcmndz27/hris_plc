<?php

    include('otApprovalReport.php');
    include('../config/db.php');

    $action = $_POST["_action"];
    $dateFrom = $_POST["_from"];
    $dateTo = $_POST["_to"];

    if ($action == 0)
    {
        GenerateOTApprovAll($action, $dateFrom, $dateTo);
    }
    else if ($action == 1)
    {
        GenerateOTApprov($action, $dateFrom, $dateTo, $_POST["_rpt"]);
    }
    else {}

?>