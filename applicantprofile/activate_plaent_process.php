<?php

    include('../applicantprofile/activate_plaent.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $status = $_POST["status"];
    $rowid = $_POST["rowid"];


    if ($action == 1)
    {
        ActivatePlaEnt($status,$rowid);
    }
    else {

    }

?>
