<?php


    include('../applicantprofile/appent.php');
    include('../config/db.php');

$appEnt = new AppEnt();

$appent = json_decode($_POST["data"]);

if($appent->{"Action"} == "InsertAppEnt")
{

    $fname = $appent->{"fname"};
    $mi = $appent->{"mi"};
    $fmname = $appent->{"fmname"};
    $howtoa = $appent->{"howtoa"};
    $refby = $appent->{"refby"};
    $refdate = $appent->{"refdate"};
    $jpos1 = $appent->{"jpos1"};
    $jpos2 = $appent->{"jpos2"};    
    $hono = $appent->{"hono"};
    $sbrgy = $appent->{"sbrgy"};
    $cty = $appent->{"cty"};
    $cn1 = $appent->{"cn1"};
    $cn2 = $appent->{"cn2"};
    $eadd = $appent->{"eadd"};
    $ttry = $appent->{"ttry"};
    $ds1 = $appent->{"ds1"};
    $scname1 = $appent->{"scname1"};
    $scndry = $appent->{"scndry"};
    $ds2 = $appent->{"ds2"};
    $scname2 = $appent->{"scname2"};
 

    $appEnt->InsertAppEnt($fname,$mi,$fmname,$howtoa,$refby,$refdate,$jpos1,$jpos2,$hono,$sbrgy,$cty,$cn1,$cn2,$eadd,$ttry,$ds1,$scname1,$scndry,$ds2,$scname2);

}else{

}
    

?>

