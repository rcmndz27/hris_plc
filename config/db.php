<?php
            date_default_timezone_set('Asia/Manila'); 

            $dbstringsL = "sqlsrv:Server=192.168.50.137;Database=hris_plc";
            $connL = new PDO($dbstringsL, "biotime", "Ob@nana2022");
            $connL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 

            try
            {
            $dbstrings = "sqlsrv:Server=192.168.50.137;Database=hris_plc";             
            $dbConnection = new PDO($dbstrings, "biotime", "Ob@nana2022"); 

            $dbstringsLs = "sqlsrv:Server=192.168.50.137;Database=hris_plc";     
            $dbConnectionL = new PDO($dbstringsLs, "biotime", "Ob@nana2022"); 
            }


            catch (PDOException $e)
            {
                die($e->getMesbiotimege());
                echo 'Connection failed: ' ;
                // . $e->getMesbiotimege();
            }
        
    
?>

