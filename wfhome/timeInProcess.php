<?php

    include('../wfhome/timeIn.php');
    include('../config/db.php');

    $choice = $_POST['choice'];
    $wfhid = $_POST['wfhid'];
    $emp_code = $_POST['emp_code'];

    if ($choice == 1)
    {
        TimeIn($wfhid,$emp_code);
    }


?>