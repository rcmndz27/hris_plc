<?php
            date_default_timezone_set('Asia/Manila'); 

            $dbstringsL = "sqlsrv:Server=192.168.201.8;Database=hrissys_test";
            $connL = new PDO($dbstringsL, "sa", "P@55w0rd123");
            $connL->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 

            try
            {
            $dbstrings = "sqlsrv:Server=192.168.201.8;Database=hrissys_dev";             
            $dbConnection = new PDO($dbstrings, "sa", "P@55w0rd123"); 

            $dbstringsLs = "sqlsrv:Server=192.168.201.8;Database=biotime8";     
            $dbConnectionL = new PDO($dbstringsLs, "sa", "P@55w0rd123"); 
            }


            catch (PDOException $e)
            {
                die($e->getMessage());
                echo 'Connection failed: ' ;
                . $e->getMessage();
            }
        
    
?>

