<?php

    include('../config/db.php');
    include('otApprovalTotals.php');

    RetrieveTotals($_POST["dateFrom"], $_POST["dateTo"], $_POST["emp"]);

?>