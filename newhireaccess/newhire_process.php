<?php

    include('../newhireaccess/newhire-access.php');
    include('../config/db.php');

    $dd = new NewHireAccess();
    $action = $_POST["_action"];
    $empstatus = $_POST["_empstatus"];


    if ($action == 1)
    {
        $dd->GetAllEmpHistory($empstatus);
    }
?>