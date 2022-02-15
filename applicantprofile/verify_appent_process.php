<?php

    include('../applicantprofile/verify_appent.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $relevant = $_POST["relevant"];
    $not_relevant = $_POST["not_relevant"];
    $verified_by = $_POST["verified_by"];
    $verified_date = $_POST["verified_date"];
    $action_taken = $_POST["action_taken"];
    $referred_to = $_POST["referred_to"];
    $referral_date = $_POST["referral_date"];
    $appent_status = $_POST["appent_status"];
    $rowid = $_POST["rowid"];


    if ($action == 1)
    {
        VerifyAppEnt($relevant,$not_relevant,$verified_by,$verified_date,$action_taken,$referred_to,$referral_date,$appent_status,$rowid);
    }
    else {

    }

?>
