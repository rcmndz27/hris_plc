<?php

    include('payslip.php');
    include('../config/db.php');

    GetPayrollAmount($_POST['empName'], $_POST['row']);

?>