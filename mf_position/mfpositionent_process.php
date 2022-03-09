<?php


    include('../mf_position/mfpositionent.php');
    include('../config/db.php');

$mfPos = new MfpositionEnt();

$mfpos = json_decode($_POST["data"]);

if($mfpos->{"Action"} == "InsertMfpositionEnt")
{

    $position = $mfpos->{"position"};
    $status = $mfpos->{"status"};


    $mfPos->InseryMfpositionEnt($position,$status);

}else{

}
    

?>

