<?php

    include('../mf_position/updatemfposition.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $rowid = $_POST["rowid"];
    $position = $_POST["position"];
    $status = $_POST["status"];

    if ($action == 1)
    {
        UpdateMfposition($rowid,$position,$status);
    }
    else {

    }

?>
