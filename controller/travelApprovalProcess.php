<?php

    include('travelApproval.php');
    include('../config/db.php');

    $rid = $_POST['row'];
    $choice = $_POST['choice'];

    if ($choice == 1)
    {
        ApproveTravel($rid);
    }
    else if ($choice == 2)
    {
        RejectTravel($rid);
    }
    else {}

?>