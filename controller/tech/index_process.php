<?php

    include('index.php');
    include('../../config/db.php');

    UpdateSupportStaff($_POST['jobid'], $_POST['support']);
?>