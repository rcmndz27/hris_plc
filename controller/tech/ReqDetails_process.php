<?php

    include('ReqDetails.php');
    include('../../config/db.php');

    UpdateRequestDetails($_POST['jobid'], $_POST['stats']);
?>