<?php

    include('travelOrder.php');
    include('../config/db.php');

    FileTravel($_POST['empCode'], $_POST['empName'], $_POST['travelLoc'], $_POST['travelDesc'], $_POST['dateFrom'], $_POST['dateTo']);

?>