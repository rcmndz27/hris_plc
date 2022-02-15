<?php

    include('../controller/dashboard.php');
    include('../config/db.php');

    $dashboard = json_decode($_POST["data"]);

    if($dashboard->{"Action"} == "GetPopulation")
    {
        $location = $dashboard->{"location"};
        GetPopulation($location);
    }
    elseif($dashboard->{"Action"} == "GetGenderCount")
    {
        $location = $dashboard->{"location"};
        GetGenderCount($location);
    }
    elseif($dashboard->{"Action"} == "GetAgeCount")
    {
        $location = $dashboard->{"location"};
        GetAgeCount($location);
    }
    else if ($dashboard->{"Action"} == "GetLocationList"){
        GetLocationList();
    }
    

?>