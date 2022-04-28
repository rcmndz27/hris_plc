<?php


    include('../mf_holiday/mfholidayent.php');
    include('../config/db.php');

$mfHol = new MfholidayEnt();

$mfhol = json_decode($_POST["data"]);

if($mfhol->{"Action"} == "InsertMfholidayEnt")
{

    $holidaydate = $mfhol->{"holidaydate"};
    $holidaytype = $mfhol->{"holidaytype"};
    $holidaydescs = $mfhol->{"holidaydescs"};
    $status = $mfhol->{"status"};


    $mfHol->InsertMfholidayEnt($holidaydate,$holidaytype,$holidaydescs,$status);

}
    

?>

